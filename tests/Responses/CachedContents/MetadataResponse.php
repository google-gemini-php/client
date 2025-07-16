<?php

use Gemini\Data\CachedContent;
use Gemini\Responses\CachedContents\MetadataResponse;

it('from', function () {
    $response = MetadataResponse::from(MetadataResponse::fake()->toArray());

    expect($response)
        ->toBeInstanceOf(MetadataResponse::class)
        ->cachedContent->toBeInstanceOf(CachedContent::class);
});

it('fake', function () {
    $response = MetadataResponse::fake();

    expect($response)
        ->cachedContent->name->toBe('cachedContents/123-456');
});

it('to array', function () {
    $attributes = MetadataResponse::fake()->toArray();
    $response = MetadataResponse::from($attributes);

    expect($response->toArray())
        ->toBeArray()
        ->toBe($attributes);
});

it('fake with override', function () {
    $response = MetadataResponse::fake([
        'name' => 'cachedContents/987-654',
    ]);

    expect($response->cachedContent->name)->toBe('cachedContents/987-654');
});
