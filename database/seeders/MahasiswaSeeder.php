<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MahasiswaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nim' => '220101001', 'nama' => 'Ahmad Fauzi', 'angkatan' => 2022, 'prodi' => 'Sistem Informasi', 'jk' => 'L'],
            ['nim' => '220101002', 'nama' => 'Siti Nurhaliza', 'angkatan' => 2022, 'prodi' => 'Sistem Informasi', 'jk' => 'P'],
            ['nim' => '220201003', 'nama' => 'Budi Santoso', 'angkatan' => 2022, 'prodi' => 'Teknik Informatika', 'jk' => 'L'],
            ['nim' => '220201004', 'nama' => 'Dewi Lestari', 'angkatan' => 2022, 'prodi' => 'Teknik Informatika', 'jk' => 'P'],
            ['nim' => '220301005', 'nama' => 'Rudi Hermawan', 'angkatan' => 2023, 'prodi' => 'Manajemen', 'jk' => 'L'],
        ];

        foreach ($data as $item) {
            DB::transaction(function () use ($item) {
                $user = User::create([
                    'identifier' => $item['nim'],
                    'name' => $item['nama'],
                    'password' => Hash::make('password'),
                    'is_active' => true,
                ]);

                $user->assignRole('mahasiswa');

                Mahasiswa::create([
                    'user_id' => $user->id,
                    'nim' => $item['nim'],
                    'nama_lengkap' => $item['nama'],
                    'angkatan' => $item['angkatan'],
                    'program_studi' => $item['prodi'],
                    'jenis_kelamin' => $item['jk'],
                    'status' => 'aktif',
                ]);
            });
        }
    }
}
