<?php

use App\Services\Ai\AiService;
use Illuminate\Support\Facades\Http;

it('returns a fallback message when the OpenRouter API fails', function () {
    config([
        'ai.providers.openrouter.api_key' => 'or-test-key',
        'ai.providers.openrouter.base_url' => 'https://openrouter.ai/api/v1',
        'ai.providers.openrouter.model' => 'meta-llama/llama-3.1-8b-instruct:free',
    ]);

    Http::fake([
        'https://openrouter.ai/api/v1/chat/completions' => Http::response(['error' => 'invalid_request'], 400),
    ]);

    $service = new AiService;
    $response = $service->chat([['role' => 'user', 'content' => 'test']]);

    expect($response)->toBe('Maaf, layanan AI sedang tidak tersedia. Silakan coba lagi nanti.');
});

it('returns the assistant content when OpenRouter responds successfully', function () {
    config([
        'ai.providers.openrouter.api_key' => 'or-test-key',
        'ai.providers.openrouter.base_url' => 'https://openrouter.ai/api/v1',
        'ai.providers.openrouter.model' => 'meta-llama/llama-3.1-8b-instruct:free',
    ]);

    Http::fake([
        'https://openrouter.ai/api/v1/chat/completions' => Http::response([
            'choices' => [
                ['message' => ['content' => 'Analisis nilai kelas: performa stabil.']],
            ],
        ], 200),
    ]);

    $service = new AiService;
    $response = $service->chat([['role' => 'user', 'content' => 'test']]);

    expect($response)->toBe('Analisis nilai kelas: performa stabil.');
});

it('falls back to Groq when OpenRouter key is not set', function () {
    config([
        'ai.providers.openrouter.api_key' => null,
        'ai.providers.groq.api_key' => 'gsk-test-key',
        'ai.providers.groq.base_url' => 'https://api.groq.com/openai/v1',
        'ai.providers.groq.model' => 'llama3-8b-8192',
    ]);

    Http::fake([
        'https://api.groq.com/openai/v1/chat/completions' => Http::response([
            'choices' => [
                ['message' => ['content' => 'Fallback to Groq success.']],
            ],
        ], 200),
    ]);

    $service = new AiService;

    expect($service->getProvider())->toBe('groq');

    $response = $service->chat([['role' => 'user', 'content' => 'test']]);
    expect($response)->toBe('Fallback to Groq success.');
});

it('falls back to Groq when OpenRouter API call fails', function () {
    config([
        'ai.providers.openrouter.api_key' => 'or-test-key',
        'ai.providers.openrouter.base_url' => 'https://openrouter.ai/api/v1',
        'ai.providers.openrouter.model' => 'meta-llama/llama-3.1-8b-instruct:free',
        'ai.providers.groq.api_key' => 'gsk-test-key',
        'ai.providers.groq.base_url' => 'https://api.groq.com/openai/v1',
        'ai.providers.groq.model' => 'llama3-8b-8192',
    ]);

    Http::fake([
        'https://openrouter.ai/api/v1/chat/completions' => Http::response(['error' => 'invalid_request'], 400),
        'https://api.groq.com/openai/v1/chat/completions' => Http::response([
            'choices' => [
                ['message' => ['content' => 'Groq fallback response.']],
            ],
        ], 200),
    ]);

    $service = new AiService;
    $response = $service->chat([['role' => 'user', 'content' => 'test']]);

    expect($response)->toBe('Maaf, layanan AI sedang tidak tersedia. Silakan coba lagi nanti.');
});

it('shows correct OpenRouter headers are sent', function () {
    config([
        'app.url' => 'https://siakad.test',
        'app.name' => 'SIAKAD-MINI',
        'ai.providers.openrouter.api_key' => 'or-test-key',
        'ai.providers.openrouter.base_url' => 'https://openrouter.ai/api/v1',
        'ai.providers.openrouter.model' => 'meta-llama/llama-3.1-8b-instruct:free',
    ]);

    Http::fake(function ($request) {
        expect($request->hasHeader('HTTP-Referer'))->toBeTrue();
        expect($request->header('HTTP-Referer'))->toEqual(['https://siakad.test']);
        expect($request->hasHeader('X-Title'))->toBeTrue();
        expect($request->header('X-Title'))->toEqual(['SIAKAD-MINI']);

        return Http::response([
            'choices' => [
                ['message' => ['content' => 'Header check passed.']],
            ],
        ], 200);
    });

    $service = new AiService;
    $response = $service->chat([['role' => 'user', 'content' => 'test']]);

    expect($response)->toBe('Header check passed.');
});
