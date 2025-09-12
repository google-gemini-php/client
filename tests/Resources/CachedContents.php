<?php

use Gemini\Enums\Method;
use Gemini\Responses\CachedContents\ListResponse;
use Gemini\Responses\CachedContents\MetadataResponse;

it('create cache', function () {
    $client = mockClient(method: Method::POST, endpoint: 'cachedContents', response: MetadataResponse::fake());

    $result = $client->cachedContents()->create('models/gemini-pro');

    expect($result)->toBeInstanceOf(MetadataResponse::class);
});

it('retrieve cache', function () {
    $client = mockClient(method: Method::GET, endpoint: 'cachedContents/123', response: MetadataResponse::fake());

    $result = $client->cachedContents()->retrieve('cachedContents/123');

    expect($result)->toBeInstanceOf(MetadataResponse::class);
});

it('list caches', function () {
    $client = mockClient(method: Method::GET, endpoint: 'cachedContents', response: ListResponse::fake());

    $result = $client->cachedContents()->list();

    expect($result)->toBeInstanceOf(ListResponse::class);
});

it('update cache', function () {
    $client = mockClient(method: Method::PATCH, endpoint: 'cachedContents/123', response: MetadataResponse::fake());

    $result = $client->cachedContents()->update('cachedContents/123');

    expect($result)->toBeInstanceOf(MetadataResponse::class);
});

it('delete cache', function () {
    $client = mockClient(method: Method::DELETE, endpoint: 'cachedContents/123', response: MetadataResponse::fake());

    $client->cachedContents()->delete('cachedContents/123');

    expect(true)->toBeTrue();
});
