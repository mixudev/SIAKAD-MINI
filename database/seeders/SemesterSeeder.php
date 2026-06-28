<?php

namespace Database\Seeders;

use App\Models\Semester;
use Illuminate\Database\Seeder;

class SemesterSeeder extends Seeder
{
    public function run(): void
    {
        $semester = Semester::create([
            'nama' => 'Semester Ganjil 2024/2025',
            'tahun_ajaran' => '2024/2025',
            'tipe' => 'ganjil',
            'tanggal_mulai' => '2024-08-01',
            'tanggal_selesai' => '2024-12-30',
            'krs_mulai' => '2024-07-15',
            'krs_selesai' => '2024-08-15',
            'is_active' => true,
        ]);
    }
}
