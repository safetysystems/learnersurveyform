<?php

return [
    /*
    |--------------------------------------------------------------------------
    | OpenAI API Key
    |--------------------------------------------------------------------------
    |
    | Your OpenAI API key. This should be set in your .env file as
    | OPENAI_API_KEY=sk-...
    |
    */
    'api_key' => env('OPENAI_API_KEY'),

    /*
    |--------------------------------------------------------------------------
    | OpenAI Organization (optional)
    |--------------------------------------------------------------------------
    */
    'organization' => env('OPENAI_ORGANIZATION'),

    /*
    |--------------------------------------------------------------------------
    | Base URI
    |--------------------------------------------------------------------------
    |
    | You can override the base URI if needed (for example, when using a
    | proxy or a compatible API endpoint).
    |
    */
    'base_uri' => env('OPENAI_BASE_URI', 'https://api.openai.com/v1'),
];

