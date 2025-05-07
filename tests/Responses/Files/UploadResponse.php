<?php

use Gemini\Responses\Files\MetadataResponse;
use Gemini\Responses\Files\UploadResponse;

test('from', function () {
    $response = UploadResponse::from(UploadResponse::fake()->toArray());

    expect($response)
        ->toBeInstanceOf(UploadResponse::class)
        ->file->toBeInstanceOf(MetadataResponse::class);
});

test('fake', function () {
    $response = UploadResponse::fake();

    expect($response)
        ->file->name->toBe('files/123-456');
});

test('to array', function () {
    $attributes = UploadResponse::fake()->toArray();

    $response = UploadResponse::from($attributes);

    expect($response->toArray())
        ->toBeArray()
        ->toBe($attributes);
});

test('fake with override', function () {
    $response = UploadResponse::fake([
        'file' => [
            'name' => 'files/987-654',
        ],
    ]);

    expect($response)
        ->file->name->toBe('files/987-654');
});
