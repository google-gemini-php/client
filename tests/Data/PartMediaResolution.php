<?php

use Gemini\Data\Blob;
use Gemini\Data\Part;
use Gemini\Data\PartMediaResolution;
use Gemini\Enums\MimeType;
use Gemini\Enums\PartMediaResolutionLevel;

test('to array', function () {
    $part = new Part(
        inlineData: new Blob(mimeType: MimeType::IMAGE_PNG, data: 'aGVsbG8='),
        mediaResolution: new PartMediaResolution(level: PartMediaResolutionLevel::MEDIA_RESOLUTION_ULTRA_HIGH),
    );

    expect($part->toArray())
        ->toBe([
            'inlineData' => ['mimeType' => 'image/png', 'data' => 'aGVsbG8='],
            'mediaResolution' => ['level' => 'MEDIA_RESOLUTION_ULTRA_HIGH'],
        ]);
});

test('to array without media resolution', function () {
    $part = new Part(inlineData: new Blob(mimeType: MimeType::IMAGE_PNG, data: 'aGVsbG8='));

    expect($part->toArray())
        ->toBe([
            'inlineData' => ['mimeType' => 'image/png', 'data' => 'aGVsbG8='],
        ]);
});

test('from', function () {
    expect(Part::from(['text' => 'Hello', 'mediaResolution' => ['level' => 'MEDIA_RESOLUTION_LOW']]))
        ->mediaResolution->level->toBe(PartMediaResolutionLevel::MEDIA_RESOLUTION_LOW)
        ->and(Part::from(['text' => 'Hello', 'mediaResolution' => ['level' => 'SOME_NEW_LEVEL']]))
        ->mediaResolution->level->toBeNull()
        ->and(Part::from(['text' => 'Hello']))
        ->mediaResolution->toBeNull();
});
