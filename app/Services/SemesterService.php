<?php

namespace App\Services;

use App\Models\Semester;
use Illuminate\Pagination\LengthAwarePaginator;

class SemesterService
{
    public function list(array $filters = []): LengthAwarePaginator
    {
        $query = Semester::query();

        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('tahun_ajaran', 'like', "%{$search}%");
            });
        }

        return $query->latest()->paginate(10);
    }

    public function find(int $id): Semester
    {
        return Semester::findOrFail($id);
    }

    public function create(array $data): Semester
    {
        return Semester::create($data);
    }

    public function update(int $id, array $data): Semester
    {
        $semester = $this->find($id);
        $semester->update($data);

        return $semester;
    }

    public function delete(int $id): void
    {
        $semester = $this->find($id);

        if ($semester->is_active) {
            throw new \RuntimeException('Tidak dapat menghapus semester yang sedang aktif.');
        }

        $semester->delete();
    }

    public function setActive(int $id): Semester
    {
        Semester::where('is_active', true)->update(['is_active' => false]);

        $semester = $this->find($id);
        $semester->update(['is_active' => true]);

        return $semester;
    }
}
