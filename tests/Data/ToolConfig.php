<?php

use Gemini\Data\FunctionCallingConfig;
use Gemini\Data\RetrievalConfig;
use Gemini\Data\ToolConfig;
use Gemini\Enums\Mode;

test('to array', function () {
    $toolConfig = new ToolConfig(
        functionCallingConfig: new FunctionCallingConfig(mode: Mode::AUTO),
        retrievalConfig: new RetrievalConfig(
            latitude: 40.758896,
            longitude: -73.985130
        )
    );

    expect($toolConfig->toArray())
        ->toBe([
            'functionCallingConfig' => [
                'mode' => 'AUTO',
                'allowedFunctionNames' => null,
            ],
            'retrievalConfig' => [
                'latLng' => [
                    'latitude' => 40.758896,
                    'longitude' => -73.985130,
                ],
            ],
        ]);
});

test('to array with only function calling config', function () {
    $toolConfig = new ToolConfig(
        functionCallingConfig: new FunctionCallingConfig(mode: Mode::AUTO),
        retrievalConfig: null,
    );

    expect($toolConfig->toArray())
        ->toBe([
            'functionCallingConfig' => [
                'mode' => 'AUTO',
                'allowedFunctionNames' => null,
            ],
        ]);
});

test('to array with only retrieval config', function () {
    $toolConfig = new ToolConfig(
        functionCallingConfig: null,
        retrievalConfig: new RetrievalConfig(
            latitude: 40.758896,
            longitude: -73.985130
        )
    );

    expect($toolConfig->toArray())
        ->toBe([
            'retrievalConfig' => [
                'latLng' => [
                    'latitude' => 40.758896,
                    'longitude' => -73.985130,
                ],
            ],
        ]);
});

test('to array with no config', function () {
    $toolConfig = new ToolConfig(
        functionCallingConfig: null,
        retrievalConfig: null,
    );

    expect($toolConfig->toArray())
        ->toBe([]);
});
