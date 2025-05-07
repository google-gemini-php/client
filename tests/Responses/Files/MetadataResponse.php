<?php

use Gemini\Data\VideoMetadata;
use Gemini\Responses\Files\MetadataResponse;

test('from', function () {
    $response = MetadataResponse::from(MetadataResponse::fake()->toArray());

    expect($response)
        ->toBeInstanceOf(MetadataResponse::class)
        ->videoMetadata->toBeInstanceOf(VideoMetadata::class);
});

test('fake', function () {
    $response = MetadataResponse::fake();

    expect($response)
        ->name->toBe('files/123-456');
});

test('to array', function () {
    $attributes = MetadataResponse::fake()->toArray();

    $response = MetadataResponse::from($attributes);

    expect($response->toArray())
        ->toBeArray()
        ->toBe($attributes);
});

test('fake with override', function () {
    $response = MetadataResponse::fake([
        'name' => 'files/987-654',
    ]);

    expect($response)
        ->name->toBe('files/987-654');
});
