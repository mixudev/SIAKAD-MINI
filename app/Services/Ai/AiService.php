<?php

namespace App\Services\Ai;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiService
{
    protected string $apiKey;

    protected string $baseUrl;

    protected string $model;

    public function __construct()
    {
        $this->apiKey = config('ai.groq.api_key');
        $this->baseUrl = config('ai.groq.base_url');
        $this->model = config('ai.groq.model');
    }

    protected function client(): PendingRequest
    {
        return Http::withToken($this->apiKey)
            ->withoutVerifying()
            ->withOptions(['verify' => false])
            ->timeout(60)
            ->connectTimeout(10)
            ->retry(2, 1000)
            ->withHeader('Content-Type', 'application/json');
    }

    public function chat(array $messages, array $options = []): string
    {
        $payload = array_merge([
            'model' => $this->model,
            'messages' => $messages,
            'temperature' => 0.7,
            'max_tokens' => 300,
        ], $options);

        try {
            $response = $this->client()->post("{$this->baseUrl}/chat/completions", $payload);
        } catch (ConnectionException $e) {
            Log::error('Groq API connection error', ['error' => $e->getMessage()]);

            return 'Maaf, layanan AI sedang tidak tersedia. Silakan coba lagi nanti.';
        }

        if ($response->failed()) {
            Log::error('Groq API error', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return 'Maaf, layanan AI sedang tidak tersedia. Silakan coba lagi nanti.';
        }

        $data = $response->json();
        $content = $data['choices'][0]['message']['content'] ?? '';

        if (trim($content) === '') {
            Log::warning('Groq API returned no assistant content', ['response' => $data]);

            return 'Maaf, layanan AI sedang tidak tersedia. Silakan coba lagi nanti.';
        }

        return $content;
    }

    public function chatStream(array $messages, callable $callback, array $options = []): void
    {
        $payload = array_merge([
            'model' => $this->model,
            'messages' => $messages,
            'temperature' => 0.7,
            'max_tokens' => 300,
            'stream' => true,
        ], $options);

        try {
            $response = $this->client()
                ->withOptions(['stream' => true])
                ->post("{$this->baseUrl}/chat/completions", $payload);
        } catch (ConnectionException $e) {
            Log::error('Groq API streaming connection error', ['error' => $e->getMessage()]);
            $callback('Maaf, layanan AI sedang tidak tersedia.');

            return;
        }

        if ($response->failed()) {
            Log::error('Groq API streaming error', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            $callback('Maaf, layanan AI sedang tidak tersedia.');

            return;
        }

        $body = $response->getBody();

        while (! $body->eof()) {
            $line = $body->read(4096);
            $lines = explode("\n", $line);

            foreach ($lines as $line) {
                $line = trim($line);
                if ($line === '') {
                    continue;
                }

                if ($line === 'data: [DONE]') {
                    break 2;
                }

                if (str_starts_with($line, 'data: ')) {
                    $json = substr($line, 6);
                    $data = json_decode($json, true);

                    if (isset($data['choices'][0]['delta']['content'])) {
                        $callback($data['choices'][0]['delta']['content']);
                    }
                }
            }
        }
    }
}
