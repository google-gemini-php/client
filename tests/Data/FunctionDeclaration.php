<?php

use Gemini\Data\FunctionDeclaration;
use Gemini\Data\Schema;
use Gemini\Enums\DataType;

test('to array', function () {
    $functionDeclaration = new FunctionDeclaration(
        name: 'get_weather',
        description: 'Returns the weather for a city.',
        parameters: new Schema(type: DataType::OBJECT, properties: ['city' => new Schema(type: DataType::STRING)]),
    );

    expect($functionDeclaration->toArray())
        ->toBe([
            'name' => 'get_weather',
            'description' => 'Returns the weather for a city.',
            'parameters' => (new Schema(type: DataType::OBJECT, properties: ['city' => new Schema(type: DataType::STRING)]))->toArray(),
            'response' => null,
        ]);
});

test('to array with json schema', function () {
    $parametersJsonSchema = [
        'type' => 'object',
        'properties' => [
            'city' => ['type' => 'string'],
            'unit' => ['type' => 'string', 'enum' => ['celsius', 'fahrenheit']],
        ],
        'required' => ['city'],
    ];
    $responseJsonSchema = [
        'type' => 'object',
        'properties' => [
            'temperature' => ['type' => 'number'],
        ],
    ];

    $functionDeclaration = new FunctionDeclaration(
        name: 'get_weather',
        description: 'Returns the weather for a city.',
        parametersJsonSchema: $parametersJsonSchema,
        responseJsonSchema: $responseJsonSchema,
    );

    expect($functionDeclaration->toArray())
        ->toBe([
            'name' => 'get_weather',
            'description' => 'Returns the weather for a city.',
            'parameters' => null,
            'response' => null,
            'parametersJsonSchema' => $parametersJsonSchema,
            'responseJsonSchema' => $responseJsonSchema,
        ]);
});
