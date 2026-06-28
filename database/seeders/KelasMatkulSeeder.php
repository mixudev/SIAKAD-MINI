<?php

namespace Database\Seeders;

use App\Models\Dosen;
use App\Models\KelasMatkul;
use App\Models\MataKuliah;
use App\Models\Semester;
use Illuminate\Database\Seeder;

class KelasMatkulSeeder extends Seeder
{
    public function run(): void
    {
        $semester = Semester::aktif()->first() ?? Semester::first();
        $dosen = Dosen::all();
        $matkul = MataKuliah::all();

        $data = [
            // Existing
            ['mk' => 'SI101', 'dosen_idx' => 0, 'kelas' => 'A', 'kap' => 40, 'hari' => 'Senin', 'mulai' => '08:00', 'selesai' => '09:40', 'ruang' => 'R.101'],
            ['mk' => 'SI101', 'dosen_idx' => 4, 'kelas' => 'B', 'kap' => 40, 'hari' => 'Selasa', 'mulai' => '10:00', 'selesai' => '11:40', 'ruang' => 'R.102'],
            ['mk' => 'TI102', 'dosen_idx' => 2, 'kelas' => 'A', 'kap' => 35, 'hari' => 'Rabu', 'mulai' => '08:00', 'selesai' => '10:30', 'ruang' => 'Lab. Komputer'],
            ['mk' => 'MN101', 'dosen_idx' => 1, 'kelas' => 'A', 'kap' => 50, 'hari' => 'Kamis', 'mulai' => '13:00', 'selesai' => '14:40', 'ruang' => 'R.201'],
            // New — tambah kelas supaya setiap matkul punya kelas
            ['mk' => 'SI102', 'dosen_idx' => 3, 'kelas' => 'A', 'kap' => 40, 'hari' => 'Rabu', 'mulai' => '10:00', 'selesai' => '11:40', 'ruang' => 'R.103'],
            ['mk' => 'SI201', 'dosen_idx' => 0, 'kelas' => 'A', 'kap' => 40, 'hari' => 'Kamis', 'mulai' => '08:00', 'selesai' => '09:40', 'ruang' => 'R.104'],
            ['mk' => 'TI101', 'dosen_idx' => 4, 'kelas' => 'A', 'kap' => 35, 'hari' => 'Senin', 'mulai' => '10:00', 'selesai' => '11:40', 'ruang' => 'R.105'],
        ];

        foreach ($data as $item) {
            $mk = $matkul->where('kode', $item['mk'])->first();
            $d = $dosen[$item['dosen_idx']] ?? null;

            if ($mk && $d) {
                KelasMatkul::create([
                    'mata_kuliah_id' => $mk->id,
                    'dosen_id' => $d->id,
                    'semester_id' => $semester->id,
                    'nama_kelas' => $item['kelas'],
                    'kapasitas' => $item['kap'],
                    'hari' => $item['hari'],
                    'jam_mulai' => $item['mulai'],
                    'jam_selesai' => $item['selesai'],
                    'ruangan' => $item['ruang'],
                ]);
            }
        }
    }
}
