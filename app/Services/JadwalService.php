<?php

namespace App\Services;

use App\Models\Dosen;
use App\Models\KelasMatkul;
use App\Models\Mahasiswa;
use App\Models\Semester;
use Illuminate\Database\Eloquent\Collection;

class JadwalService
{
    private const URUTAN_HARI = [
        'Senin' => 1,
        'Selasa' => 2,
        'Rabu' => 3,
        'Kamis' => 4,
        'Jumat' => 5,
        'Sabtu' => 6,
        'Minggu' => 7,
    ];

    public function getJadwalDosen(Dosen $dosen, ?Semester $semester = null): Collection
    {
        $semester ??= Semester::aktif();

        return $this->urutkanBerdasarkanHari(
            KelasMatkul::with(['mataKuliah', 'semester'])
                ->where('dosen_id', $dosen->id)
                ->where('semester_id', $semester->id)
                ->whereNotNull('hari')
                ->orderBy('jam_mulai')
                ->get()
        );
    }

    public function getJadwalMahasiswa(Mahasiswa $mahasiswa, ?Semester $semester = null): Collection
    {
        $semester ??= Semester::aktif();

        return $this->urutkanBerdasarkanHari(
            KelasMatkul::with(['mataKuliah', 'dosen', 'semester'])
                ->whereHas('krsDetails.krs', function ($q) use ($mahasiswa, $semester) {
                    $q->where('mahasiswa_id', $mahasiswa->id)
                        ->where('semester_id', $semester->id)
                        ->where('status', 'disetujui');
                })
                ->whereNotNull('hari')
                ->orderBy('jam_mulai')
                ->get()
        );
    }

    public function getSemuaJadwal(?Semester $semester = null, array $filters = []): Collection
    {
        $semester ??= Semester::aktif();

        $query = KelasMatkul::with(['mataKuliah', 'dosen', 'semester'])
            ->where('semester_id', $semester->id)
            ->whereNotNull('hari')
            ->orderBy('jam_mulai');

        if (! empty($filters['dosen_id'])) {
            $query->where('dosen_id', $filters['dosen_id']);
        }

        if (! empty($filters['hari'])) {
            $query->where('hari', $filters['hari']);
        }

        if (! empty($filters['ruangan'])) {
            $query->where('ruangan', 'like', '%'.$filters['ruangan'].'%');
        }

        return $this->urutkanBerdasarkanHari($query->get());
    }

    public function getDaftarHari(): array
    {
        return array_keys(self::URUTAN_HARI);
    }

    private function urutkanBerdasarkanHari(Collection $kelasMatkuls): Collection
    {
        $hariList = self::URUTAN_HARI;

        return $kelasMatkuls->sortBy(function ($item) use ($hariList) {
            return $hariList[$item->hari] ?? 99;
        })->values();
    }
}
