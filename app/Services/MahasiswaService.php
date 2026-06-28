<?php

namespace App\Services;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MahasiswaService
{
    public function list(array $filters = []): LengthAwarePaginator
    {
        $query = Mahasiswa::with('user');

        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('nim', 'like', "%{$search}%")
                    ->orWhere('nama_lengkap', 'like', "%{$search}%");
            });
        }

        return $query->latest()->paginate(10);
    }

    public function find(int $id): Mahasiswa
    {
        return Mahasiswa::with('user.roles')->findOrFail($id);
    }

    public function create(array $data): Mahasiswa
    {
        return DB::transaction(function () use ($data) {
            $user = User::create([
                'identifier' => $data['nim'],
                'name' => $data['nama_lengkap'],
                'password' => Hash::make('password'),
                'is_active' => true,
            ]);

            $user->assignRole('mahasiswa');

            return $user->mahasiswa()->create([
                'nim' => $data['nim'],
                'nama_lengkap' => $data['nama_lengkap'],
                'angkatan' => $data['angkatan'],
                'program_studi' => $data['program_studi'],
                'jenis_kelamin' => $data['jenis_kelamin'],
                'status' => $data['status'] ?? 'aktif',
                'no_hp' => $data['no_hp'] ?? null,
                'email' => $data['email'] ?? null,
                'alamat' => $data['alamat'] ?? null,
            ]);
        });
    }

    public function update(int $id, array $data): Mahasiswa
    {
        return DB::transaction(function () use ($id, $data) {
            $mahasiswa = $this->find($id);

            $mahasiswa->update([
                'nim' => $data['nim'] ?? $mahasiswa->nim,
                'nama_lengkap' => $data['nama_lengkap'] ?? $mahasiswa->nama_lengkap,
                'angkatan' => $data['angkatan'] ?? $mahasiswa->angkatan,
                'program_studi' => $data['program_studi'] ?? $mahasiswa->program_studi,
                'jenis_kelamin' => $data['jenis_kelamin'] ?? $mahasiswa->jenis_kelamin,
                'status' => $data['status'] ?? $mahasiswa->status,
                'no_hp' => $data['no_hp'] ?? $mahasiswa->no_hp,
                'email' => $data['email'] ?? $mahasiswa->email,
                'alamat' => $data['alamat'] ?? $mahasiswa->alamat,
            ]);

            $mahasiswa->user->update([
                'name' => $data['nama_lengkap'] ?? $mahasiswa->user->name,
                'identifier' => $data['nim'] ?? $mahasiswa->user->identifier,
            ]);

            if (! empty($data['password'])) {
                $mahasiswa->user->update([
                    'password' => Hash::make($data['password']),
                ]);
            }

            return $mahasiswa;
        });
    }

    public function delete(int $id): void
    {
        $mahasiswa = $this->find($id);
        $mahasiswa->user()->delete();
    }
}
