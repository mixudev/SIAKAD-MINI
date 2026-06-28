<?php

namespace App\Services;

use App\Models\KelasMatkul;
use App\Models\Krs;
use App\Models\KrsDetail;
use App\Models\Mahasiswa;
use App\Models\Semester;
use Illuminate\Support\Collection;

class KrsService
{
    public function buatAtauAmbilKrs(Mahasiswa $mahasiswa, Semester $semester): Krs
    {
        return $mahasiswa->krs()->firstOrCreate(
            ['semester_id' => $semester->id],
            [
                'total_sks' => 0,
                'status' => 'draft',
            ]
        );
    }

    public function daftarKelasTersedia(Mahasiswa $mahasiswa, Semester $semester): Collection
    {
        $diambilIds = KrsDetail::whereHas('krs', function ($q) use ($mahasiswa, $semester) {
            $q->where('mahasiswa_id', $mahasiswa->id)
                ->where('semester_id', $semester->id);
        })->pluck('kelas_matkul_id');

        return KelasMatkul::with(['mataKuliah', 'dosen'])
            ->where('semester_id', $semester->id)
            ->whereNotIn('id', $diambilIds)
            ->get();
    }

    public function tambahKelasMatkul(Krs $krs, KelasMatkul $kelasMatkul): KrsDetail
    {
        if ($krs->status !== 'draft') {
            throw new \RuntimeException('KRS sudah diajukan, tidak dapat diubah.');
        }

        $sks = $kelasMatkul->mataKuliah->sks;

        if ($krs->sisaSks() < $sks) {
            throw new \RuntimeException('Total SKS melebihi batas maksimal '.Krs::MAX_SKS.'.');
        }

        if (! $kelasMatkul->masihAdaKuota()) {
            throw new \RuntimeException('Kelas sudah penuh.');
        }

        $exists = $krs->details()->where('kelas_matkul_id', $kelasMatkul->id)->exists();
        if ($exists) {
            throw new \RuntimeException('Kelas sudah ditambahkan.');
        }

        if ($kelasMatkul->hari && $kelasMatkul->jam_mulai) {
            $tabrakan = $krs->details()->whereHas('kelasMatkul', function ($q) use ($kelasMatkul) {
                $q->where('hari', $kelasMatkul->hari)
                    ->where(function ($qq) use ($kelasMatkul) {
                        $qq->whereBetween('jam_mulai', [$kelasMatkul->jam_mulai, $kelasMatkul->jam_selesai])
                            ->orWhereBetween('jam_selesai', [$kelasMatkul->jam_mulai, $kelasMatkul->jam_selesai]);
                    });
            })->exists();

            if ($tabrakan) {
                throw new \RuntimeException('Jadwal bertabrakan dengan kelas lain.');
            }
        }

        $detail = $krs->details()->create([
            'kelas_matkul_id' => $kelasMatkul->id,
            'sks_diambil' => $sks,
        ]);

        $krs->recalculateTotalSks();

        return $detail;
    }

    public function hapusKelasMatkul(KrsDetail $detail): void
    {
        $krs = $detail->krs;

        if ($krs->status !== 'draft') {
            throw new \RuntimeException('KRS sudah diajukan, tidak dapat diubah.');
        }

        $detail->delete();
        $krs->recalculateTotalSks();
    }

    public function ajukanKrs(Krs $krs): void
    {
        if ($krs->status !== 'draft') {
            throw new \RuntimeException('KRS sudah diajukan sebelumnya.');
        }

        $semester = $krs->semester;
        if ($semester && ! $semester->krs_sedang_dibuka) {
            throw new \RuntimeException('Periode pengisian KRS sudah berakhir atau belum dimulai.');
        }

        if ($krs->details()->count() === 0) {
            throw new \RuntimeException('Belum ada mata kuliah yang dipilih.');
        }

        $krs->update([
            'status' => 'diajukan',
            'diajukan_at' => now(),
        ]);
    }

    public function approveKrs(Krs $krs, int $userId): void
    {
        if ($krs->status !== 'diajukan') {
            throw new \RuntimeException('KRS sudah diproses sebelumnya.');
        }

        $krs->update([
            'status' => 'disetujui',
            'disetujui_oleh' => $userId,
            'disetujui_at' => now(),
        ]);
    }

    public function tolakKrs(Krs $krs, ?string $catatan = null): void
    {
        if ($krs->status !== 'diajukan') {
            throw new \RuntimeException('KRS sudah diproses sebelumnya.');
        }

        $krs->update([
            'status' => 'ditolak',
            'catatan' => $catatan,
        ]);
    }

    public function daftarKrsUntukApproval(?int $semesterId = null, ?string $status = null): Collection
    {
        return Krs::with(['mahasiswa.user', 'semester', 'details.kelasMatkul.mataKuliah', 'details.kelasMatkul.dosen'])
            ->when($semesterId, fn ($q) => $q->where('semester_id', $semesterId))
            ->when($status, fn ($q) => $q->where('status', $status))
            ->latest('diajukan_at')
            ->get();
    }
}
