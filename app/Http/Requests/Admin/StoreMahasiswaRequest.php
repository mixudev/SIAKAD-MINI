<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMahasiswaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nim' => ['required', 'string', 'max:255', Rule::unique('mahasiswas'), Rule::unique('users', 'identifier')],
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'angkatan' => ['required', 'integer', 'min:2000', 'max:2099'],
            'program_studi' => ['required', 'string', 'max:255'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'status' => ['required', 'in:aktif,cuti,lulus,dropout'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'alamat' => ['nullable', 'string'],
        ];
    }

    public function attributes(): array
    {
        return [
            'nim' => 'NIM',
            'nama_lengkap' => 'Nama Lengkap',
            'angkatan' => 'Angkatan',
            'program_studi' => 'Program Studi',
            'jenis_kelamin' => 'Jenis Kelamin',
            'status' => 'Status',
        ];
    }
}
