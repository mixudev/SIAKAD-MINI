<?php

namespace App\Services;

use App\Models\Dosen;
use App\Models\KelasMatkul;
use App\Models\Krs;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\Nilai;
use App\Models\Semester;
use Illuminate\Support\Collection;

class DashboardService
{
    protected KhsService $khsService;

    public function __construct(KhsService $khsService)
    {
        $this->khsService = $khsService;
    }

    public function getStatMahasiswa(): int
    {
        return Mahasiswa::count();
    }

    public function getStatDosen(): int
    {
        return Dosen::count();
    }

    public function getStatMatkulAktif(): int
    {
        return MataKuliah::where('is_active', true)->count();
    }

    public function getSemesterAktif(): ?Semester
    {
        return Semester::aktif();
    }

    public function getKrsMenunggu(): int
    {
        return Krs::where('status', 'diajukan')->count();
    }

    public function getKrsTrend(): Collection
    {
        return Krs::whereNotNull('diajukan_at')
            ->where('diajukan_at', '>=', now()->subDays(30))
            ->selectRaw('DATE(diajukan_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    public function getGradeDistribution(): Collection
    {
        $order = ['A', 'A-', 'B+', 'B', 'B-', 'C+', 'C', 'D', 'E'];

        return Nilai::whereNotNull('nilai_huruf')
            ->selectRaw('nilai_huruf, COUNT(*) as total')
            ->groupBy('nilai_huruf')
            ->get()
            ->sortBy(fn ($item) => array_search($item->nilai_huruf, $order))
            ->values();
    }

    public function getMahasiswaPerProdi(): Collection
    {
        return Mahasiswa::selectRaw('program_studi, COUNT(*) as total')
            ->groupBy('program_studi')
            ->orderByDesc('total')
            ->get();
    }

    public function getRecentKrs(): Collection
    {
        return Krs::with(['mahasiswa', 'semester'])
            ->where('status', 'diajukan')
            ->latest('diajukan_at')
            ->take(5)
            ->get();
    }

    public function getStatKelasDiampu(int $dosenId): int
    {
        $semesterAktif = Semester::aktif();
        if (! $semesterAktif) {
            return 0;
        }

        return KelasMatkul::where('dosen_id', $dosenId)
            ->where('semester_id', $semesterAktif->id)
            ->count();
    }

    public function getStatTotalMahasiswa(int $dosenId): int
    {
        $semesterAktif = Semester::aktif();
        if (! $semesterAktif) {
            return 0;
        }

        $kelasIds = KelasMatkul::where('dosen_id', $dosenId)
            ->where('semester_id', $semesterAktif->id)
            ->pluck('id');

        if ($kelasIds->isEmpty()) {
            return 0;
        }

        return Nilai::whereIn('kelas_matkul_id', $kelasIds)
            ->distinct('mahasiswa_id')
            ->count('mahasiswa_id');
    }

    public function getStatPersentaseNilai(int $dosenId): array
    {
        $semesterAktif = Semester::aktif();
        if (! $semesterAktif) {
            return ['persen' => 0, 'terisi' => 0, 'total' => 0];
        }

        $kelasIds = KelasMatkul::where('dosen_id', $dosenId)
            ->where('semester_id', $semesterAktif->id)
            ->pluck('id');

        if ($kelasIds->isEmpty()) {
            return ['persen' => 0, 'terisi' => 0, 'total' => 0];
        }

        $total = Nilai::whereIn('kelas_matkul_id', $kelasIds)->count();
        $terisi = Nilai::whereIn('kelas_matkul_id', $kelasIds)
            ->whereNotNull('nilai_akhir')
            ->count();

        return [
            'persen' => $total > 0 ? round(($terisi / $total) * 100) : 0,
            'terisi' => $terisi,
            'total' => $total,
        ];
    }

    public function getRataNilaiPerKelas(int $dosenId): Collection
    {
        $semesterAktif = Semester::aktif();
        if (! $semesterAktif) {
            return collect();
        }

        return KelasMatkul::with('mataKuliah')
            ->where('dosen_id', $dosenId)
            ->where('semester_id', $semesterAktif->id)
            ->get()
            ->map(function (KelasMatkul $km) {
                $rata = Nilai::where('kelas_matkul_id', $km->id)
                    ->whereNotNull('nilai_akhir')
                    ->avg('nilai_akhir');

                return [
                    'label' => "{$km->mataKuliah->nama} - {$km->nama_kelas}",
                    'rata_rata' => $rata ? round($rata, 2) : 0,
                ];
            });
    }

    public function getNilaiProgress(int $dosenId): array
    {
        $semesterAktif = Semester::aktif();
        if (! $semesterAktif) {
            return ['terisi' => 0, 'belum' => 0];
        }

        $kelasIds = KelasMatkul::where('dosen_id', $dosenId)
            ->where('semester_id', $semesterAktif->id)
            ->pluck('id');

        if ($kelasIds->isEmpty()) {
            return ['terisi' => 0, 'belum' => 0];
        }

        $terisi = Nilai::whereIn('kelas_matkul_id', $kelasIds)
            ->whereNotNull('nilai_akhir')
            ->count();
        $total = Nilai::whereIn('kelas_matkul_id', $kelasIds)->count();

        return [
            'terisi' => $terisi,
            'belum' => $total - $terisi,
        ];
    }

    public function getKelasList(int $dosenId): Collection
    {
        $semesterAktif = Semester::aktif();
        if (! $semesterAktif) {
            return collect();
        }

        return KelasMatkul::with('mataKuliah')
            ->where('dosen_id', $dosenId)
            ->where('semester_id', $semesterAktif->id)
            ->get()
            ->map(function (KelasMatkul $km) {
                $total = Nilai::where('kelas_matkul_id', $km->id)->count();
                $terisi = Nilai::where('kelas_matkul_id', $km->id)
                    ->whereNotNull('nilai_akhir')
                    ->count();

                return [
                    'id' => $km->id,
                    'label' => $km->label,
                    'matkul' => $km->mataKuliah->nama,
                    'nama_kelas' => $km->nama_kelas,
                    'hari' => $km->hari,
                    'jam' => substr($km->jam_mulai, 0, 5).' - '.substr($km->jam_selesai, 0, 5),
                    'total_mahasiswa' => $total,
                    'terisi' => $terisi,
                    'persen' => $total > 0 ? round(($terisi / $total) * 100) : 0,
                ];
            });
    }

    public function getStatSks(?Mahasiswa $mahasiswa): int
    {
        if (! $mahasiswa) {
            return 0;
        }

        $semesterAktif = Semester::aktif();
        if (! $semesterAktif) {
            return 0;
        }

        $krs = $mahasiswa->krsSemester($semesterAktif);

        return $krs?->total_sks ?? 0;
    }

    public function getIps(?Mahasiswa $mahasiswa): ?float
    {
        if (! $mahasiswa) {
            return null;
        }

        $semesterAktif = Semester::aktif();

        return $semesterAktif
            ? $this->khsService->hitungIpSemester($mahasiswa, $semesterAktif)
            : null;
    }

    public function getIpk(?Mahasiswa $mahasiswa): float
    {
        if (! $mahasiswa) {
            return 0;
        }

        return $this->khsService->hitungIpk($mahasiswa);
    }

    public function getIpTrend(?Mahasiswa $mahasiswa): Collection
    {
        if (! $mahasiswa) {
            return collect();
        }

        $semesters = $this->khsService->getSemesterList($mahasiswa);

        return $semesters->map(function (Semester $semester) use ($mahasiswa) {
            return [
                'semester' => $semester->nama.' '.$semester->tahun_ajaran,
                'ip' => $this->khsService->hitungIpSemester($mahasiswa, $semester) ?? 0,
            ];
        })->reverse()->values();
    }

    public function getSksTrend(?Mahasiswa $mahasiswa): Collection
    {
        if (! $mahasiswa) {
            return collect();
        }

        $semesterAktif = Semester::aktif();
        if (! $semesterAktif) {
            return collect();
        }

        $semesters = $this->khsService->getSemesterList($mahasiswa);

        return $semesters->map(function (Semester $semester) use ($mahasiswa) {
            $nilaiList = $this->khsService->getKhs($mahasiswa, $semester);
            $totalSks = $nilaiList->sum(fn ($n) => $n->kelasMatkul->mataKuliah->sks);

            return [
                'semester' => $semester->nama.' '.$semester->tahun_ajaran,
                'sks' => $totalSks,
            ];
        })->reverse()->values();
    }

    public function getNilaiSemesterIni(?Mahasiswa $mahasiswa): Collection
    {
        if (! $mahasiswa) {
            return collect();
        }

        $semesterAktif = Semester::aktif();
        if (! $semesterAktif) {
            return collect();
        }

        return $this->khsService->getKhs($mahasiswa, $semesterAktif);
    }
}
