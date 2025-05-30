<?php

use Gemini\Responses\Files\ListResponse;
use Gemini\Responses\Files\MetadataResponse;

test('from', function () {
    $response = ListResponse::from(ListResponse::fake()->toArray());

    expect($response)
        ->toBeInstanceOf(ListResponse::class)
        ->files->toBeArray()->toHaveCount(1)
        ->files->each->toBeInstanceOf(MetadataResponse::class);
});

test('fake', function () {
    $response = ListResponse::fake();

    expect($response)
        ->files->{0}->name->toBe('files/123-456');
});

test('to array', function () {
    $attributes = ListResponse::fake()->toArray();

    $response = ListResponse::from($attributes);

    expect($response->toArray())
        ->toBeArray()
        ->toBe($attributes);
});

test('fake with override', function () {
    $response = ListResponse::fake([
        'files' => [
            ['name' => 'files/987-654'],
        ],
    ]);

    expect($response)
        ->files->{0}->name->toBe('files/987-654');
});
