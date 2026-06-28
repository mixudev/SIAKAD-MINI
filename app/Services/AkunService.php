<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

class AkunService
{
    public function list(array $filters = []): LengthAwarePaginator
    {
        $query = User::with('roles');

        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('identifier', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%");
            });
        }

        return $query->latest()->paginate(10);
    }

    public function find(int $id): User
    {
        return User::with('roles')->findOrFail($id);
    }

    public function create(array $data): User
    {
        $user = User::create([
            'identifier' => $data['identifier'],
            'name' => $data['name'],
            'password' => Hash::make($data['password']),
            'is_active' => $data['is_active'] ?? true,
        ]);

        if (! empty($data['role'])) {
            $user->assignRole($data['role']);
        }

        return $user->load('roles');
    }

    public function update(int $id, array $data): User
    {
        $user = $this->find($id);

        $updateData = array_filter([
            'identifier' => $data['identifier'] ?? null,
            'name' => $data['name'] ?? null,
            'is_active' => $data['is_active'] ?? null,
        ], fn ($v) => ! is_null($v));

        if (! empty($data['password'])) {
            $updateData['password'] = Hash::make($data['password']);
        }

        $user->update($updateData);

        if (! empty($data['role'])) {
            $user->syncRoles([$data['role']]);
        }

        return $user->load('roles');
    }

    public function delete(int $id): void
    {
        $user = $this->find($id);
        $user->delete();
    }

    public function toggleActive(int $id): User
    {
        $user = $this->find($id);
        $user->update(['is_active' => ! $user->is_active]);

        return $user->load('roles');
    }
}
