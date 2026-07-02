<?php

use App\Services\Ai\AiService;
use Illuminate\Support\Facades\Http;

it('returns a fallback message when the Groq API fails', function () {
    config(['ai.groq.api_key' => 'test-key', 'ai.groq.base_url' => 'https://api.groq.com/openai/v1', 'ai.groq.model' => 'test-model']);

    Http::fake([
        'https://api.groq.com/openai/v1/chat/completions' => Http::response(['error' => 'invalid_request'], 400),
    ]);

    $service = new AiService;
    $response = $service->chat([['role' => 'user', 'content' => 'test']]);

    expect($response)->toBe('Maaf, layanan AI sedang tidak tersedia. Silakan coba lagi nanti.');
});

it('returns the assistant content when the Groq API responds successfully', function () {
    config(['ai.groq.api_key' => 'test-key', 'ai.groq.base_url' => 'https://api.groq.com/openai/v1', 'ai.groq.model' => 'test-model']);

    Http::fake([
        'https://api.groq.com/openai/v1/chat/completions' => Http::response([
            'choices' => [
                ['message' => ['content' => 'Analisis nilai kelas: performa stabil.']],
            ],
        ], 200),
    ]);

    $service = new AiService;
    $response = $service->chat([['role' => 'user', 'content' => 'test']]);

    expect($response)->toBe('Analisis nilai kelas: performa stabil.');
});
