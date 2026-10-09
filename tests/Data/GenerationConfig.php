<?php

use Gemini\Data\GenerationConfig;
use Gemini\Enums\ResponseMimeType;

test('to array with response json schema', function () {
    $responseJsonSchema = [
        'type' => 'object',
        'properties' => [
            'name' => ['type' => 'string'],
            'age' => ['type' => 'integer', 'minimum' => 0],
        ],
        'required' => ['name', 'age'],
    ];

    $generationConfig = new GenerationConfig(
        responseMimeType: ResponseMimeType::APPLICATION_JSON,
        responseJsonSchema: $responseJsonSchema,
    );

    expect($generationConfig->toArray())
        ->responseMimeType->toBe('application/json')
        ->responseJsonSchema->toBe($responseJsonSchema)
        ->not->toHaveKey('responseSchema');
});

test('to array without response json schema', function () {
    expect((new GenerationConfig)->toArray())
        ->not->toHaveKey('responseJsonSchema');
});
