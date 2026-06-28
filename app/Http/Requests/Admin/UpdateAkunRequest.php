<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAkunRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'identifier' => ['sometimes', 'string', 'max:255', Rule::unique('users')->ignore($this->route('akun'))],
            'name' => ['sometimes', 'string', 'max:255'],
            'password' => ['nullable', 'string', 'min:6'],
            'is_active' => ['sometimes', 'boolean'],
            'role' => ['sometimes', 'string', 'exists:roles,name'],
        ];
    }

    public function attributes(): array
    {
        return [
            'identifier' => 'NIM / Username',
            'name' => 'Nama',
            'password' => 'Kata Sandi',
            'role' => 'Role',
        ];
    }
}
