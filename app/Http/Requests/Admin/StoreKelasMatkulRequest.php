<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreKelasMatkulRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'mata_kuliah_id' => ['required', 'exists:mata_kuliahs,id'],
            'dosen_id' => ['required', 'exists:dosens,id'],
            'semester_id' => ['required', 'exists:semesters,id'],
            'nama_kelas' => ['required', 'string', 'max:10'],
            'kapasitas' => ['required', 'integer', 'min:1', 'max:200'],
            'hari' => ['nullable', 'string', 'max:20'],
            'jam_mulai' => ['nullable', 'date_format:H:i'],
            'jam_selesai' => ['nullable', 'date_format:H:i', 'after:jam_mulai'],
            'ruangan' => ['nullable', 'string', 'max:50'],
        ];
    }
}
