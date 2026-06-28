<?php

namespace App\Services;

use App\Models\MataKuliah;
use Illuminate\Pagination\LengthAwarePaginator;

class MataKuliahService
{
    public function list(array $filters = []): LengthAwarePaginator
    {
        $query = MataKuliah::query();

        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('kode', 'like', "%{$search}%")
                    ->orWhere('nama', 'like', "%{$search}%");
            });
        }

        return $query->latest()->paginate(10);
    }

    public function find(int $id): MataKuliah
    {
        return MataKuliah::findOrFail($id);
    }

    public function create(array $data): MataKuliah
    {
        return MataKuliah::create($data);
    }

    public function update(int $id, array $data): MataKuliah
    {
        $matkul = $this->find($id);
        $matkul->update($data);

        return $matkul;
    }

    public function delete(int $id): void
    {
        $matkul = $this->find($id);
        $matkul->delete();
    }
}
