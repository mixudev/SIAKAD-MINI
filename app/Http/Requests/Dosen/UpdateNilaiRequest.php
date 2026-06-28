<?php

namespace App\Http\Requests\Dosen;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNilaiRequest extends FormRequest
{
    public function authorize(): bool
    {
        $kelasMatkul = $this->route('kelasMatkul');

        return $kelasMatkul && $kelasMatkul->dosen_id === auth()->user()->dosen?->id;
    }

    public function rules(): array
    {
        return [
            'nilai' => ['required', 'array'],
            'nilai.*.nilai_tugas' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'nilai.*.nilai_uts' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'nilai.*.nilai_uas' => ['nullable', 'numeric', 'min:0', 'max:100'],
        ];
    }
}
