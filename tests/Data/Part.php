<?php

use Gemini\Data\Part;
use Gemini\Data\ToolCall;
use Gemini\Data\ToolResponse;
use Gemini\Enums\ToolType;

test('tool call round trip', function () {
    $attributes = [
        'thoughtSignature' => 'c2lnbmF0dXJl',
        'toolCall' => [
            'toolType' => 'GOOGLE_SEARCH_WEB',
            'args' => ['queries' => ['2022 FIFA World Cup winner']],
            'id' => 'tool-call-1',
        ],
    ];

    $part = Part::from($attributes);

    expect($part->toolCall)
        ->toBeInstanceOf(ToolCall::class)
        ->toolType->toBe(ToolType::GOOGLE_SEARCH_WEB)
        ->args->toBe(['queries' => ['2022 FIFA World Cup winner']])
        ->id->toBe('tool-call-1')
        ->and($part->toArray())->toBe($attributes);
});

test('tool response round trip', function () {
    $attributes = [
        'toolResponse' => [
            'toolType' => 'GOOGLE_SEARCH_WEB',
            'response' => ['search_suggestions' => '<div>...</div>'],
            'id' => 'tool-call-1',
        ],
    ];

    $part = Part::from($attributes);

    expect($part->toolResponse)
        ->toBeInstanceOf(ToolResponse::class)
        ->toolType->toBe(ToolType::GOOGLE_SEARCH_WEB)
        ->response->toBe(['search_suggestions' => '<div>...</div>'])
        ->and($part->toArray())->toBe($attributes);
});

test('tool call without args', function () {
    $part = Part::from(['toolCall' => ['toolType' => 'URL_CONTEXT', 'id' => 'tool-call-2']]);

    expect($part->toolCall->args)->toBe([])
        ->and($part->toArray())->toBe(['toolCall' => ['toolType' => 'URL_CONTEXT', 'id' => 'tool-call-2']]);
});

test('tool call with unknown tool type', function () {
    $part = Part::from(['toolCall' => ['toolType' => 'SOME_NEW_TOOL', 'toolName' => 'new_tool']]);

    expect($part->toolCall)
        ->toolType->toBeNull()
        ->toolName->toBe('new_tool')
        ->and($part->toArray())->toBe(['toolCall' => ['toolType' => 'SOME_NEW_TOOL', 'toolName' => 'new_tool']]);
});

test('tool response with unknown tool type', function () {
    $part = Part::from(['toolResponse' => ['toolType' => 'SOME_NEW_TOOL', 'id' => 'call_1']]);

    expect($part->toolResponse->toolType)->toBeNull()
        ->and($part->toArray())->toBe(['toolResponse' => ['toolType' => 'SOME_NEW_TOOL', 'id' => 'call_1']]);
});
