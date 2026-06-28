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
            ['mata_kuliah_id' => $matkul->where('kode', 'SI101')->first()?->id, 'dosen_id' => $dosen[0]->id, 'nama_kelas' => 'A', 'kapasitas' => 40, 'hari' => 'Senin', 'jam_mulai' => '08:00', 'jam_selesai' => '09:40', 'ruangan' => 'R.101'],
            ['mata_kuliah_id' => $matkul->where('kode', 'SI101')->first()?->id, 'dosen_id' => $dosen[4]->id, 'nama_kelas' => 'B', 'kapasitas' => 40, 'hari' => 'Selasa', 'jam_mulai' => '10:00', 'jam_selesai' => '11:40', 'ruangan' => 'R.102'],
            ['mata_kuliah_id' => $matkul->where('kode', 'TI102')->first()?->id, 'dosen_id' => $dosen[2]->id, 'nama_kelas' => 'A', 'kapasitas' => 35, 'hari' => 'Rabu', 'jam_mulai' => '08:00', 'jam_selesai' => '10:30', 'ruangan' => 'Lab. Komputer'],
            ['mata_kuliah_id' => $matkul->where('kode', 'MN101')->first()?->id, 'dosen_id' => $dosen[1]->id, 'nama_kelas' => 'A', 'kapasitas' => 50, 'hari' => 'Kamis', 'jam_mulai' => '13:00', 'jam_selesai' => '14:40', 'ruangan' => 'R.201'],
        ];

        foreach ($data as $item) {
            if ($item['mata_kuliah_id'] && $item['dosen_id']) {
                $item['semester_id'] = $semester->id;
                KelasMatkul::create($item);
            }
        }
    }
}
