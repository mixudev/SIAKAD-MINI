<?php

namespace Database\Seeders;

use App\Models\KelasMatkul;
use App\Models\Krs;
use App\Models\Nilai;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NilaiSeeder extends Seeder
{
    public function run(): void
    {
        $km = KelasMatkul::with('mataKuliah')->get()->keyBy('id');

        // Hanya untuk KRS yang sudah disetujui
        $krsDisetujui = Krs::with('mahasiswa')
            ->where('status', 'disetujui')
            ->get();

        $nilaiData = [
            // Ahmad Fauzi (SI) — nim 220101001
            '220101001' => [
                'SI101-A' => ['tugas' => 85, 'uts' => 80, 'uas' => 88],
                'SI102-A' => ['tugas' => 75, 'uts' => 70, 'uas' => 78],
                'SI201-A' => ['tugas' => 90, 'uts' => 88, 'uas' => 92],
            ],
            // Budi Santoso (TI) — nim 220201003
            '220201003' => [
                'TI101-A' => ['tugas' => 70, 'uts' => 65, 'uas' => 72],
                'TI102-A' => ['tugas' => 80, 'uts' => 75, 'uas' => 82],
            ],
        ];

        foreach ($krsDisetujui as $krs) {
            $nim = $krs->mahasiswa->nim;
            $matkulNilai = $nilaiData[$nim] ?? [];

            foreach ($krs->details as $detail) {
                $label = $detail->kelasMatkul->mataKuliah->kode.'-'.$detail->kelasMatkul->nama_kelas;
                $n = $matkulNilai[$label] ?? null;

                if (! $n) {
                    continue;
                }

                DB::transaction(function () use ($detail, $n, $krs) {
                    $nilai = Nilai::create([
                        'mahasiswa_id' => $krs->mahasiswa_id,
                        'kelas_matkul_id' => $detail->kelas_matkul_id,
                        'nilai_tugas' => $n['tugas'],
                        'nilai_uts' => $n['uts'],
                        'nilai_uas' => $n['uas'],
                        'diinput_oleh' => $detail->kelasMatkul->dosen->user_id ?? 1,
                    ]);
                });
            }
        }
    }
}
