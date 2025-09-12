<?php

use Gemini\Data\CachedContent;
use Gemini\Responses\CachedContents\ListResponse;

it('from', function () {
    $response = ListResponse::from(ListResponse::fake()->toArray());

    expect($response)
        ->toBeInstanceOf(ListResponse::class)
        ->cachedContents->each->toBeInstanceOf(CachedContent::class);
});

it('fake', function () {
    $response = ListResponse::fake();

    expect($response->cachedContents)->toHaveCount(1);
});

it('to array', function () {
    $attributes = ListResponse::fake()->toArray();
    $response = ListResponse::from($attributes);

    expect($response->toArray())
        ->toBeArray()
        ->toBe($attributes);
});

it('fake with override', function () {
    $response = ListResponse::fake([
        'nextPageToken' => 'next',
    ]);

    expect($response->nextPageToken)->toBe('next');
});
