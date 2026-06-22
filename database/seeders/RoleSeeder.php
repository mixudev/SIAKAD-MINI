<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Buat role dasar: admin, dosen, mahasiswa.
     *
     * Permission belum di-detailkan granular dulu (sesuai fondasi awal),
     * untuk sekarang akses dibedakan via role saja di route/middleware.
     * Permission per-fitur (misal "kelola-nilai", "approve-krs") bisa
     * ditambahkan belakangan begitu modul terkait mulai dibangun.
     */
    public function run(): void
    {
        $roles = ['admin', 'dosen', 'mahasiswa'];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role, 'guard_name' => 'web']);
        }
    }
}
