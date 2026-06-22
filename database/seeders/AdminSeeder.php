<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Buat satu akun admin default supaya bisa langsung login pertama kali.
     * Ganti password ini setelah deploy ke production!
     */
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['identifier' => 'admin'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'is_active' => true,
            ]
        );

        if (! $admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }
    }
}
