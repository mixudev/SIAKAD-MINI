<?php

namespace App\Http\Requests\Ai;

use Illuminate\Foundation\Http\FormRequest;

class ChatRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'message' => ['required', 'string', 'max:2000'],
            'conversation_id' => ['sometimes', 'string', 'max:36'],
            'stream' => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'message.required' => 'Pesan tidak boleh kosong.',
            'message.max' => 'Pesan maksimal 2000 karakter.',
        ];
    }
}
