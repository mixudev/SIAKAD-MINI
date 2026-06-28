<?php

namespace App\Services;

use App\Models\Mahasiswa;
use App\Models\Nilai;
use App\Models\Semester;
use Illuminate\Support\Collection;

class KhsService
{
    public function getKhs(Mahasiswa $mahasiswa, Semester $semester): Collection
    {
        return Nilai::with(['kelasMatkul.mataKuliah'])
            ->where('mahasiswa_id', $mahasiswa->id)
            ->whereHas('kelasMatkul', fn ($q) => $q->where('semester_id', $semester->id))
            ->whereNotNull('nilai_akhir')
            ->get();
    }

    public function getSemesterList(Mahasiswa $mahasiswa): Collection
    {
        $semesterIds = Nilai::where('mahasiswa_id', $mahasiswa->id)
            ->whereNotNull('nilai_akhir')
            ->whereHas('kelasMatkul')
            ->get()
            ->pluck('kelasMatkul.semester_id')
            ->unique()
            ->values();

        return Semester::whereIn('id', $semesterIds)->orderByDesc('id')->get();
    }

    public function hitungIpSemester(Mahasiswa $mahasiswa, Semester $semester): ?float
    {
        $nilaiList = $this->getKhs($mahasiswa, $semester);

        if ($nilaiList->isEmpty()) {
            return null;
        }

        $totalMutu = 0;
        $totalSks = 0;

        foreach ($nilaiList as $nilai) {
            $sks = $nilai->kelasMatkul->mataKuliah->sks;
            $totalMutu += $nilai->bobotMutu() * $sks;
            $totalSks += $sks;
        }

        return $totalSks > 0 ? round($totalMutu / $totalSks, 2) : null;
    }

    public function hitungIpk(Mahasiswa $mahasiswa): float
    {
        $semesterList = $this->getSemesterList($mahasiswa);

        $totalMutu = 0;
        $totalSks = 0;

        foreach ($semesterList as $semester) {
            $nilaiList = $this->getKhs($mahasiswa, $semester);
            foreach ($nilaiList as $nilai) {
                $sks = $nilai->kelasMatkul->mataKuliah->sks;
                $totalMutu += $nilai->bobotMutu() * $sks;
                $totalSks += $sks;
            }
        }

        return $totalSks > 0 ? round($totalMutu / $totalSks, 2) : 0;
    }
}
