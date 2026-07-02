<?php

return [
    'groq' => [
        'api_key' => env('AI_API_KEY'),
        'base_url' => env('AI_BASE_URL', 'https://api.groq.com/openai/v1'),
        'model' => env('AI_MODEL', 'llama3-8b-8192'),
    ],

    'cache_ttl' => env('AI_CACHE_TTL', 1800),
];
