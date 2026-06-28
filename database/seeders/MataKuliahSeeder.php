<?php

namespace Database\Seeders;

use App\Models\MataKuliah;
use Illuminate\Database\Seeder;

class MataKuliahSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['kode' => 'SI101', 'nama' => 'Dasar Pemrograman', 'sks' => 3, 'semester_ke' => 1, 'program_studi' => 'Sistem Informasi'],
            ['kode' => 'SI102', 'nama' => 'Struktur Data', 'sks' => 3, 'semester_ke' => 2, 'program_studi' => 'Sistem Informasi'],
            ['kode' => 'SI201', 'nama' => 'Basis Data', 'sks' => 3, 'semester_ke' => 3, 'program_studi' => 'Sistem Informasi'],
            ['kode' => 'TI101', 'nama' => 'Matematika Diskrit', 'sks' => 3, 'semester_ke' => 1, 'program_studi' => 'Teknik Informatika'],
            ['kode' => 'TI102', 'nama' => 'Algoritma dan Pemrograman', 'sks' => 4, 'semester_ke' => 1, 'program_studi' => 'Teknik Informatika'],
            ['kode' => 'MN101', 'nama' => 'Pengantar Manajemen', 'sks' => 3, 'semester_ke' => 1, 'program_studi' => 'Manajemen'],
        ];

        foreach ($data as $item) {
            MataKuliah::create($item);
        }
    }
}
