<?php

use Gemini\Data\ContentEmbedding;
use Gemini\Responses\GenerativeModel\EmbedContentResponse;

test('from', function () {
    $response = EmbedContentResponse::from(EmbedContentResponse::fake()->toArray());

    expect($response)
        ->toBeInstanceOf(EmbedContentResponse::class)
        ->embedding->toBeInstanceOf(ContentEmbedding::class)
        ->embedding->values->toBeArray()->toMatchArray([
            0.008624583,
            -0.030451821,
            -0.042496547,
            -0.029230341,
            0.05486475,
            0.006694871,
            0.004025645,
        ]);
});

test('fake', function () {
    $response = EmbedContentResponse::fake();

    expect($response)
        ->toBeInstanceOf(EmbedContentResponse::class)
        ->embedding->toBeInstanceOf(ContentEmbedding::class)
        ->embedding->values->toBeArray()->toMatchArray([
            0.008624583,
            -0.030451821,
            -0.042496547,
            -0.029230341,
            0.05486475,
            0.006694871,
            0.004025645,
        ]);
});

test('to array', function () {
    $attributes = EmbedContentResponse::fake()->toArray();
    $response = EmbedContentResponse::from($attributes);

    expect($response->toArray())
        ->toBeArray()->toBe($attributes);
});

test('fake with override', function () {
    $response = EmbedContentResponse::fake([
        'embedding' => [
            'values' => [
                0,
            ],
        ],
    ]);
    expect($response)
        ->embedding->values->toBeArray()->toMatchArray([
            0,
        ]);
});
