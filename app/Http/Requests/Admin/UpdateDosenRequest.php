<?php

namespace App\Http\Requests\Admin;

use App\Models\Dosen;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDosenRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $dosen = $this->route('dosen');
        $userId = $dosen instanceof Dosen ? $dosen->user_id : $dosen;

        return [
            'nidn' => ['sometimes', 'string', 'max:255', Rule::unique('dosens')->ignore($dosen), Rule::unique('users', 'identifier')->ignore($userId)],
            'nama_lengkap' => ['sometimes', 'string', 'max:255'],
            'gelar_depan' => ['nullable', 'string', 'max:50'],
            'gelar_belakang' => ['nullable', 'string', 'max:100'],
            'jenis_kelamin' => ['sometimes', 'in:L,P'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'alamat' => ['nullable', 'string'],
            'password' => ['nullable', 'string', 'min:6'],
        ];
    }

    public function attributes(): array
    {
        return [
            'nidn' => 'NIDN',
            'nama_lengkap' => 'Nama Lengkap',
            'gelar_depan' => 'Gelar Depan',
            'gelar_belakang' => 'Gelar Belakang',
            'jenis_kelamin' => 'Jenis Kelamin',
        ];
    }
}
