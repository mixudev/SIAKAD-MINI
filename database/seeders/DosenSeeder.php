<?php

namespace Database\Seeders;

use App\Models\Dosen;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DosenSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nidn' => '0510017801', 'nama' => 'Dr. Andi Pratama', 'gelar_depan' => 'Dr.', 'gelar_belakang' => 'S.Kom., M.Kom.', 'jk' => 'L'],
            ['nidn' => '0510027902', 'nama' => 'Rina Wijaya', 'gelar_depan' => null, 'gelar_belakang' => 'S.E., M.M.', 'jk' => 'P'],
            ['nidn' => '0510038003', 'nama' => 'Prof. Bambang Susilo', 'gelar_depan' => 'Prof.', 'gelar_belakang' => 'S.T., M.T., Ph.D.', 'jk' => 'L'],
            ['nidn' => '0510048104', 'nama' => 'Fitri Handayani', 'gelar_depan' => null, 'gelar_belakang' => 'S.Si., M.Si.', 'jk' => 'P'],
            ['nidn' => '0510058205', 'nama' => 'Doni Kusuma', 'gelar_depan' => null, 'gelar_belakang' => 'S.Kom., M.Kom.', 'jk' => 'L'],
        ];

        foreach ($data as $item) {
            DB::transaction(function () use ($item) {
                $user = User::create([
                    'identifier' => $item['nidn'],
                    'name' => $item['nama'],
                    'password' => Hash::make('password'),
                    'is_active' => true,
                ]);

                $user->assignRole('dosen');

                Dosen::create([
                    'user_id' => $user->id,
                    'nidn' => $item['nidn'],
                    'nama_lengkap' => $item['nama'],
                    'gelar_depan' => $item['gelar_depan'],
                    'gelar_belakang' => $item['gelar_belakang'],
                    'jenis_kelamin' => $item['jk'],
                ]);
            });
        }
    }
}
