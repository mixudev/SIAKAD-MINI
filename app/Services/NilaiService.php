<?php

namespace App\Services;

use App\Models\Dosen;
use App\Models\KelasMatkul;
use App\Models\Nilai;
use App\Models\Semester;
use Illuminate\Support\Collection;

class NilaiService
{
    public function daftarKelasDiampu(Dosen $dosen, ?Semester $semester = null): Collection
    {
        $query = KelasMatkul::with(['mataKuliah', 'semester'])
            ->where('dosen_id', $dosen->id);

        if ($semester) {
            $query->where('semester_id', $semester->id);
        } else {
            $semesterAktif = Semester::aktif();
            if ($semesterAktif) {
                $query->where('semester_id', $semesterAktif->id);
            }
        }

        return $query->get();
    }

    public function getNilaiPerKelas(KelasMatkul $kelasMatkul): Collection
    {
        $mahasiswaDiKelas = $kelasMatkul->krsDetails()
            ->with('krs.mahasiswa.user')
            ->whereHas('krs', fn ($q) => $q->where('status', 'disetujui'))
            ->get()
            ->pluck('krs.mahasiswa');

        $nilaiExisting = $kelasMatkul->nilais()->get()->keyBy('mahasiswa_id');

        $result = collect();

        foreach ($mahasiswaDiKelas as $mhs) {
            if ($nilaiExisting->has($mhs->id)) {
                $result->push($nilaiExisting->get($mhs->id));
            } else {
                $nilai = Nilai::create([
                    'mahasiswa_id' => $mhs->id,
                    'kelas_matkul_id' => $kelasMatkul->id,
                ]);
                $result->push($nilai);
            }
        }

        return $result;
    }

    public function getKelasMatkulBySemester(?int $semesterId): Collection
    {
        return KelasMatkul::with(['mataKuliah', 'dosen', 'semester'])
            ->when($semesterId, fn ($q) => $q->where('semester_id', $semesterId))
            ->orderBy('mata_kuliah_id')
            ->get();
    }

    public function getNilaiWithFilters(?int $kelasFilter = null, ?int $semesterId = null): Collection
    {
        $query = Nilai::with(['mahasiswa.user', 'kelasMatkul.mataKuliah', 'kelasMatkul.dosen']);

        if ($kelasFilter) {
            $query->where('kelas_matkul_id', $kelasFilter);
        } elseif ($semesterId) {
            $query->whereHas('kelasMatkul', fn ($q) => $q->where('semester_id', $semesterId));
        }

        return $query->latest()->get();
    }

    public function updateNilai(KelasMatkul $kelasMatkul, array $data, int $diinputOleh): void
    {
        foreach ($data as $mahasiswaId => $nilaiData) {
            $nilai = Nilai::where('kelas_matkul_id', $kelasMatkul->id)
                ->where('mahasiswa_id', $mahasiswaId)
                ->first();

            if (! $nilai) {
                continue;
            }

            $update = [
                'diinput_oleh' => $diinputOleh,
            ];

            if (array_key_exists('nilai_tugas', $nilaiData)) {
                $update['nilai_tugas'] = $nilaiData['nilai_tugas'] !== '' ? $nilaiData['nilai_tugas'] : null;
            }
            if (array_key_exists('nilai_uts', $nilaiData)) {
                $update['nilai_uts'] = $nilaiData['nilai_uts'] !== '' ? $nilaiData['nilai_uts'] : null;
            }
            if (array_key_exists('nilai_uas', $nilaiData)) {
                $update['nilai_uas'] = $nilaiData['nilai_uas'] !== '' ? $nilaiData['nilai_uas'] : null;
            }

            $nilai->update($update);
        }
    }
}
