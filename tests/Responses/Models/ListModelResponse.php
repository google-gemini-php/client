<?php

use Gemini\Data\Model;
use Gemini\Responses\Models\ListModelResponse;

test('from', function () {
    $response = ListModelResponse::from(ListModelResponse::fake()->toArray());

    expect($response)
        ->toBeInstanceOf(ListModelResponse::class)
        ->models->toBeArray()->toHaveCount(3)
        ->models->each->toBeInstanceOf(Model::class);
});

test('fake', function () {
    $response = ListModelResponse::fake();

    expect($response)
        ->models->{0}->name->toBe('models/gemini-pro');
});

test('to array', function () {
    $attributes = ListModelResponse::fake()->toArray();

    $response = ListModelResponse::from($attributes);

    expect($response->toArray())
        ->toBeArray()
        ->toBe($attributes);
});

test('fake with override', function () {
    $response = ListModelResponse::fake([
        'models' => [
            ['name' => 'models/test'],
        ],
    ]);

    expect($response)
        ->models->{0}->name->toBe('models/test');
});
