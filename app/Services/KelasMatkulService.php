<?php

namespace App\Services;

use App\Models\KelasMatkul;
use Illuminate\Pagination\LengthAwarePaginator;

class KelasMatkulService
{
    public function list(array $filters = []): LengthAwarePaginator
    {
        $query = KelasMatkul::with(['mataKuliah', 'dosen', 'semester']);

        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->whereHas('mataKuliah', fn ($qq) => $qq->where('nama', 'like', "%{$search}%"))
                    ->orWhereHas('dosen', fn ($qq) => $qq->where('nama_lengkap', 'like', "%{$search}%"))
                    ->orWhere('nama_kelas', 'like', "%{$search}%");
            });
        }

        return $query->latest()->paginate(10);
    }

    public function find(int $id): KelasMatkul
    {
        return KelasMatkul::with(['mataKuliah', 'dosen', 'semester'])->findOrFail($id);
    }

    public function create(array $data): KelasMatkul
    {
        return KelasMatkul::create($data);
    }

    public function update(int $id, array $data): KelasMatkul
    {
        $kelasMatkul = $this->find($id);
        $kelasMatkul->update($data);

        return $kelasMatkul->load(['mataKuliah', 'dosen', 'semester']);
    }

    public function delete(int $id): void
    {
        $kelasMatkul = $this->find($id);
        $kelasMatkul->delete();
    }
}
