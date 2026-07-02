<?php

namespace App\Services\Ai;

use App\Models\KelasMatkul;
use App\Models\Mahasiswa;
use App\Models\Semester;
use App\Services\DashboardService;
use App\Services\KhsService;

class AiPromptBuilder
{
    public function __construct(
        private readonly DashboardService $dashboardService,
        private readonly KhsService $khsService,
    ) {}

    public function buildInsightAdmin(): array
    {
        $statMahasiswa = $this->dashboardService->getStatMahasiswa();
        $statDosen = $this->dashboardService->getStatDosen();
        $matkulAktif = $this->dashboardService->getStatMatkulAktif();
        $krsMenunggu = $this->dashboardService->getKrsMenunggu();
        $krsTrend = $this->dashboardService->getKrsTrend();
        $gradeDist = $this->dashboardService->getGradeDistribution();
        $prodiData = $this->dashboardService->getMahasiswaPerProdi();

        $totalNilai = $gradeDist->sum('total');
        $krsTotal30 = $krsTrend->sum('count');

        $data = [
            'stat_mahasiswa' => $statMahasiswa,
            'stat_dosen' => $statDosen,
            'matkul_aktif' => $matkulAktif,
            'krs_menunggu' => $krsMenunggu,
            'krs_30hari' => $krsTotal30,
            'total_nilai' => $totalNilai,
            'prodi_list' => $prodiData->pluck('program_studi')->implode(', '),
        ];

        return [
            ['role' => 'system', 'content' => 'Kamu adalah asisten AI akademik SIAKAD. WAJIB gunakan Bahasa Indonesia. Berikan insight singkat (maks 3 kalimat). JANGAN gunakan markdown, bold, atau list.'],
            ['role' => 'user', 'content' => 'Berdasarkan data berikut, buat insight dashboard untuk admin:'.json_encode($data)],
        ];
    }

    public function buildInsightDosen(int $dosenId): array
    {
        $kelasCount = $this->dashboardService->getStatKelasDiampu($dosenId);
        $totalMahasiswa = $this->dashboardService->getStatTotalMahasiswa($dosenId);
        $persen = $this->dashboardService->getStatPersentaseNilai($dosenId);
        $rataNilai = $this->dashboardService->getRataNilaiPerKelas($dosenId);

        $kelasData = $rataNilai->map(fn ($r) => "{$r['label']}: rata-rata {$r['rata_rata']}")->implode('; ');

        $data = [
            'kelas_diampu' => $kelasCount,
            'total_mahasiswa' => $totalMahasiswa,
            'progress_nilai' => $persen['persen'].'%',
            'rata_nilai_per_kelas' => $kelasData ?: 'belum ada data',
        ];

        return [
            ['role' => 'system', 'content' => 'Kamu adalah asisten AI akademik SIAKAD. WAJIB gunakan Bahasa Indonesia. Berikan insight singkat (maks 3 kalimat). JANGAN gunakan markdown, bold, atau list.'],
            ['role' => 'user', 'content' => 'Buat insight dashboard untuk dosen berdasarkan data:'.json_encode($data)],
        ];
    }

    public function buildInsightMahasiswa(Mahasiswa $mahasiswa): array
    {
        $semesterAktif = Semester::aktif();
        $ipk = $this->khsService->hitungIpk($mahasiswa);
        $ips = $semesterAktif ? $this->khsService->hitungIpSemester($mahasiswa, $semesterAktif) : null;
        $nilaiList = $semesterAktif ? $this->khsService->getKhs($mahasiswa, $semesterAktif) : collect();
        $ipTrend = $this->dashboardService->getIpTrend($mahasiswa);

        $nilaiSummary = $nilaiList->map(fn ($n) => "{$n->kelasMatkul->mataKuliah->nama}: {$n->nilai_huruf}")->implode('; ');

        $trendDesc = $ipTrend->count() > 1
            ? ($ipTrend->first()['ip'] >= $ipTrend->last()['ip'] ? 'meningkat' : 'menurun')
            : 'baru semester pertama';

        $data = [
            'ipk' => $ipk,
            'ips_sekarang' => $ips,
            'trend_ip' => $trendDesc,
            'nilai_semester_ini' => $nilaiSummary ?: 'belum ada',
        ];

        return [
            ['role' => 'system', 'content' => 'Kamu adalah asisten AI akademik SIAKAD. WAJIB gunakan Bahasa Indonesia. Berikan insight singkat (maks 3 kalimat). Beri semangat jika IP bagus, saran jika perlu improve. JANGAN gunakan markdown, bold, atau list.'],
            ['role' => 'user', 'content' => 'Buat insight dashboard untuk mahasiswa berdasarkan data:'.json_encode($data)],
        ];
    }

    public function buildChatMessage(string $role, string $message, ?Mahasiswa $mahasiswa = null): array
    {
        $context = 'Kamu adalah asisten AI akademik SIAKAD. WAJIB gunakan Bahasa Indonesia baku dan santun. Jawab SINGKAT maksimal 2-3 kalimat (50 kata). JANGAN gunakan markdown, bold, atau list.';

        if ($role === 'mahasiswa' && $mahasiswa) {
            $semesterAktif = Semester::aktif();
            $ipk = $this->khsService->hitungIpk($mahasiswa);
            $ips = $semesterAktif ? $this->khsService->hitungIpSemester($mahasiswa, $semesterAktif) : null;
            $totalSks = $mahasiswa->krsSemester($semesterAktif)?->total_sks ?? 0;

            $context .= "\n\nData mahasiswa:\n- Nama: {$mahasiswa->nama_lengkap}\n- NIM: {$mahasiswa->nim}\n- Prodi: {$mahasiswa->program_studi}\n- Angkatan: {$mahasiswa->angkatan}\n- IPK: {$ipk}\n- IP Semester ini: ".($ips ?? '-')."\n- SKS diambil: {$totalSks}";
        }

        if ($role === 'dosen') {
            $context .= "\n\nKamu membantu dosen yang sedang mengelola nilai dan kelas.";
        }

        if ($role === 'admin') {
            $context .= "\n\nKamu membantu admin yang mengelola seluruh sistem SIAKAD.";
        }

        return [
            ['role' => 'system', 'content' => $context],
            ['role' => 'user', 'content' => $message],
        ];
    }

    public function buildGradeAnalysis(KelasMatkul $kelasMatkul): array
    {
        $nilaiList = $kelasMatkul->nilai()->with('mahasiswa')->get();
        $total = $nilaiList->count();
        $terisi = $nilaiList->whereNotNull('nilai_akhir')->count();

        $rataTugas = $nilaiList->avg('nilai_tugas');
        $rataUts = $nilaiList->avg('nilai_uts');
        $rataUas = $nilaiList->avg('nilai_uas');
        $rataAkhir = $nilaiList->avg('nilai_akhir');

        $gradeCounts = $nilaiList->whereNotNull('nilai_huruf')
            ->groupBy('nilai_huruf')
            ->map(fn ($g) => $g->count());

        $rawData = [
            'mata_kuliah' => $kelasMatkul->mataKuliah->nama,
            'kelas' => $kelasMatkul->nama_kelas,
            'total_mahasiswa' => $total,
            'nilai_terisi' => $terisi,
            'rata_tugas' => round($rataTugas, 2),
            'rata_uts' => round($rataUts, 2),
            'rata_uas' => round($rataUas, 2),
            'rata_akhir' => round($rataAkhir, 2),
            'distribusi_nilai' => $gradeCounts->toArray(),
        ];

        if ($terisi > 0) {
            $lowPerforming = $nilaiList->where('nilai_akhir', '<', 60)
                ->take(3)
                ->map(fn ($n) => "{$n->mahasiswa->nama_lengkap} ({$n->nilai_akhir})")
                ->values();

            if ($lowPerforming->isNotEmpty()) {
                $rawData['mhs_perlu_perhatian'] = $lowPerforming->toArray();
            }
        }

        return [
            ['role' => 'system', 'content' => 'Kamu adalah asisten AI akademik SIAKAD untuk dosen. WAJIB gunakan Bahasa Indonesia. Analisis data nilai kelas maks 5 kalimat. JANGAN gunakan markdown, bold, atau list.'],
            ['role' => 'user', 'content' => 'Analisis data nilai kelas ini:'.json_encode($rawData)],
        ];
    }
}
