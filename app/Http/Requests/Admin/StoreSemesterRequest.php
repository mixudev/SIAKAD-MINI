<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreSemesterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:255'],
            'tahun_ajaran' => ['required', 'string', 'max:20'],
            'tipe' => ['required', 'in:ganjil,genap'],
            'tanggal_mulai' => ['required', 'date'],
            'tanggal_selesai' => ['required', 'date', 'after_or_equal:tanggal_mulai'],
            'krs_mulai' => ['nullable', 'date'],
            'krs_selesai' => ['nullable', 'date', 'after_or_equal:krs_mulai'],
            'is_active' => ['boolean'],
        ];
    }
}
