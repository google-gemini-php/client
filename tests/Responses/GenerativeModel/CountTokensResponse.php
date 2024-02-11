<?php

use Gemini\Responses\GenerativeModel\CountTokensResponse;

test('from', function () {
    $response = CountTokensResponse::from(CountTokensResponse::fake()->toArray());

    expect($response)
        ->toBeInstanceOf(CountTokensResponse::class)
        ->totalTokens->toBe(8);
});

test('fake', function () {
    $response = CountTokensResponse::fake();

    expect($response)
        ->totalTokens->toBe(8);
});

test('to array', function () {
    $attributes = CountTokensResponse::fake()->toArray();
    $response = CountTokensResponse::from($attributes);

    expect($response->toArray())
        ->toBeArray()
        ->toBe($attributes);
});

test('fake with override', function () {
    $response = CountTokensResponse::fake([
        'totalTokens' => 10,
    ]);

    expect($response)
        ->totalTokens->toBe(10);
});
