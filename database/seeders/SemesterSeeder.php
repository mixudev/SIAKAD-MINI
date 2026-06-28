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
            'krs_mulai' => now()->subDays(30)->format('Y-m-d'),
            'krs_selesai' => now()->addDays(30)->format('Y-m-d'),
            'is_active' => true,
        ]);
    }
}
