<?php

namespace App\Http\Requests\Admin;

use App\Models\Mahasiswa;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMahasiswaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $mahasiswa = $this->route('mahasiswa');
        $userId = $mahasiswa instanceof Mahasiswa ? $mahasiswa->user_id : $mahasiswa;

        return [
            'nim' => ['sometimes', 'string', 'max:255', Rule::unique('mahasiswas')->ignore($mahasiswa), Rule::unique('users', 'identifier')->ignore($userId)],
            'nama_lengkap' => ['sometimes', 'string', 'max:255'],
            'angkatan' => ['sometimes', 'integer', 'min:2000', 'max:2099'],
            'program_studi' => ['sometimes', 'string', 'max:255'],
            'jenis_kelamin' => ['sometimes', 'in:L,P'],
            'status' => ['sometimes', 'in:aktif,cuti,lulus,dropout'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'alamat' => ['nullable', 'string'],
            'password' => ['nullable', 'string', 'min:6'],
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
