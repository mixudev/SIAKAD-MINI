<?php

namespace App\Services;

use App\Models\Dosen;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DosenService
{
    public function list(array $filters = []): LengthAwarePaginator
    {
        $query = Dosen::with('user');

        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('nidn', 'like', "%{$search}%")
                    ->orWhere('nama_lengkap', 'like', "%{$search}%");
            });
        }

        return $query->latest()->paginate(10);
    }

    public function find(int $id): Dosen
    {
        return Dosen::with('user.roles')->findOrFail($id);
    }

    public function create(array $data): Dosen
    {
        return DB::transaction(function () use ($data) {
            $user = User::create([
                'identifier' => $data['nidn'],
                'name' => $data['nama_lengkap'],
                'password' => Hash::make('password'),
                'is_active' => true,
            ]);

            $user->assignRole('dosen');

            return $user->dosen()->create([
                'nidn' => $data['nidn'],
                'nama_lengkap' => $data['nama_lengkap'],
                'gelar_depan' => $data['gelar_depan'] ?? null,
                'gelar_belakang' => $data['gelar_belakang'] ?? null,
                'jenis_kelamin' => $data['jenis_kelamin'],
                'no_hp' => $data['no_hp'] ?? null,
                'email' => $data['email'] ?? null,
                'alamat' => $data['alamat'] ?? null,
            ]);
        });
    }

    public function update(int $id, array $data): Dosen
    {
        return DB::transaction(function () use ($id, $data) {
            $dosen = $this->find($id);

            $dosen->update([
                'nidn' => $data['nidn'] ?? $dosen->nidn,
                'nama_lengkap' => $data['nama_lengkap'] ?? $dosen->nama_lengkap,
                'gelar_depan' => $data['gelar_depan'] ?? $dosen->gelar_depan,
                'gelar_belakang' => $data['gelar_belakang'] ?? $dosen->gelar_belakang,
                'jenis_kelamin' => $data['jenis_kelamin'] ?? $dosen->jenis_kelamin,
                'no_hp' => $data['no_hp'] ?? $dosen->no_hp,
                'email' => $data['email'] ?? $dosen->email,
                'alamat' => $data['alamat'] ?? $dosen->alamat,
            ]);

            $dosen->user->update([
                'name' => $data['nama_lengkap'] ?? $dosen->user->name,
                'identifier' => $data['nidn'] ?? $dosen->user->identifier,
            ]);

            if (! empty($data['password'])) {
                $dosen->user->update([
                    'password' => Hash::make($data['password']),
                ]);
            }

            return $dosen;
        });
    }

    public function delete(int $id): void
    {
        $dosen = $this->find($id);
        $dosen->user()->delete();
    }
}
