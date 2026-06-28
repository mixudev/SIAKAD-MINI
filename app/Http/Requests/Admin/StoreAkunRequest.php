<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAkunRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'identifier' => ['required', 'string', 'max:255', Rule::unique('users')],
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:6'],
            'role' => ['required', 'string', 'exists:roles,name'],
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
