<?php

use Gemini\Data\ContentEmbedding;
use Gemini\Responses\GenerativeModel\BatchEmbedContentsResponse;

test('from', function () {
    $response = BatchEmbedContentsResponse::from(BatchEmbedContentsResponse::fake()->toArray());

    expect($response)
        ->toBeInstanceOf(BatchEmbedContentsResponse::class)
        ->embeddings->each->toBeInstanceOf(ContentEmbedding::class)
        ->embeddings->each(fn ($embeddingModel) => $embeddingModel->values->toBeArray()->toMatchArray([
            0.008624583,
            -0.030451821,
            -0.042496547,
            -0.029230341,
            0.05486475,
            0.006694871,
            0.004025645,
        ]));
});

test('fake', function () {
    $response = BatchEmbedContentsResponse::fake();

    expect($response)
        ->toBeInstanceOf(BatchEmbedContentsResponse::class)
        ->embeddings->each->toBeInstanceOf(ContentEmbedding::class)
        ->embeddings->each(fn ($embeddingModel) => $embeddingModel->values->toBeArray()->toMatchArray([
            0.008624583,
            -0.030451821,
            -0.042496547,
            -0.029230341,
            0.05486475,
            0.006694871,
            0.004025645,
        ]));
});

test('to array', function () {
    $attributes = BatchEmbedContentsResponse::fake()->toArray();
    $response = BatchEmbedContentsResponse::from($attributes);

    expect($response->toArray())
        ->toBeArray()->toBe($attributes);
});

test('fake with override', function () {
    $response = BatchEmbedContentsResponse::fake([
        'embeddings' => [
            [
                'values' => [
                    0,
                ],
            ],
        ],
    ]);
    expect($response)
        ->embeddings->{0}->values->toBeArray()->toMatchArray([
            0,
        ]);
});
