<?php

use Gemini\Data\Model;
use Gemini\Responses\Models\RetrieveModelResponse;

test('from', function () {
    $response = RetrieveModelResponse::from(RetrieveModelResponse::fake()->toArray());

    expect($response)
        ->toBeInstanceOf(RetrieveModelResponse::class)
        ->model->toBeInstanceOf(Model::class);
});

test('fake', function () {
    $response = RetrieveModelResponse::fake();

    expect($response)
        ->model->name->toBe('models/gemini-pro');
});

test('to array', function () {
    $attributes = RetrieveModelResponse::fake()->toArray();

    $response = RetrieveModelResponse::from($attributes);

    expect($response->toArray())
        ->toBeArray()
        ->toBe($attributes);
});

test('fake with override', function () {
    $response = RetrieveModelResponse::fake([
        'name' => 'models/test',
    ]);

    expect($response)
        ->model->name->toBe('models/test');
});
