<?php

return [
    'providers' => [
        'openrouter' => [
            'api_key' => env('OPENROUTER_API_KEY'),
            'base_url' => env('OPENROUTER_BASE_URL', 'https://openrouter.ai/api/v1'),
            'model' => env('OPENROUTER_MODEL', 'meta-llama/llama-3.1-8b-instruct:free'),
        ],

        'groq' => [
            'api_key' => env('GROQ_API_KEY', env('AI_API_KEY')),
            'base_url' => env('GROQ_BASE_URL', env('AI_BASE_URL', 'https://api.groq.com/openai/v1')),
            'model' => env('GROQ_MODEL', env('AI_MODEL', 'llama3-8b-8192')),
        ],
    ],

    'cache_ttl' => env('AI_CACHE_TTL', 1800),
];
