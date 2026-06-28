<?php

namespace Database\Seeders;

use App\Models\KelasMatkul;
use App\Models\Krs;
use App\Models\KrsDetail;
use App\Models\Mahasiswa;
use App\Models\Semester;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KrsSeeder extends Seeder
{
    public function run(): void
    {
        $semester = Semester::aktif()->first() ?? Semester::first();
        $km = KelasMatkul::with('mataKuliah')->get()->keyBy('id');

        $data = [
            ['220101001', 'disetujui', ['SI101-A', 'SI102-A', 'SI201-A'], 1, null],
            ['220101002', 'diajukan', ['SI101-B', 'SI102-A'], null, null],
            ['220201003', 'disetujui', ['TI101-A', 'TI102-A'], 1, null],
            ['220201004', 'draft', ['TI102-A'], null, null],
            ['220301005', 'ditolak', ['MN101-A'], 1, 'Mata kuliah tidak sesuai dengan program studi'],
        ];

        foreach ($data as [$nim, $status, $kelasList, $disetujuiOleh, $catatan]) {
            DB::transaction(function () use ($nim, $status, $kelasList, $disetujuiOleh, $catatan, $semester, $km) {
                $mahasiswa = Mahasiswa::where('nim', $nim)->first();
                if (! $mahasiswa) {
                    return;
                }

                $krs = Krs::create([
                    'mahasiswa_id' => $mahasiswa->id,
                    'semester_id' => $semester->id,
                    'total_sks' => 0,
                    'status' => 'draft',
                ]);

                $totalSks = 0;

                foreach ($kelasList as $label) {
                    $matched = $km->first(function ($k) use ($label) {
                        return $k->mataKuliah->kode.'-'.$k->nama_kelas === $label;
                    });

                    if (! $matched) {
                        continue;
                    }

                    KrsDetail::create([
                        'krs_id' => $krs->id,
                        'kelas_matkul_id' => $matched->id,
                        'sks_diambil' => $matched->mataKuliah->sks,
                    ]);

                    $totalSks += $matched->mataKuliah->sks;
                }

                $update = ['total_sks' => $totalSks];

                if ($status === 'diajukan') {
                    $update['status'] = 'diajukan';
                    $update['diajukan_at'] = now()->subDays(2);
                } elseif ($status === 'disetujui') {
                    $update['status'] = 'disetujui';
                    $update['diajukan_at'] = now()->subDays(5);
                    $update['disetujui_at'] = now()->subDays(3);
                    $update['disetujui_oleh'] = $disetujuiOleh;
                } elseif ($status === 'ditolak') {
                    $update['status'] = 'ditolak';
                    $update['diajukan_at'] = now()->subDays(4);
                    $update['disetujui_at'] = now()->subDays(2);
                    $update['disetujui_oleh'] = $disetujuiOleh;
                    $update['catatan'] = $catatan;
                }

                $krs->update($update);
            });
        }
    }
}
