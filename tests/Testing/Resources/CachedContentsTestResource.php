<?php

use Gemini\Resources\CachedContents;
use Gemini\Responses\CachedContents\ListResponse;
use Gemini\Responses\CachedContents\MetadataResponse;
use Gemini\Testing\ClientFake;

it('records a create request', function () {
    $fake = new ClientFake([
        MetadataResponse::fake(),
    ]);

    $fake->cachedContents()->create('models/gemini-pro');

    $fake->assertSent(resource: CachedContents::class, callback: function ($method) {
        return $method === 'create';
    });
});

it('records a retrieve request', function () {
    $fake = new ClientFake([
        MetadataResponse::fake(),
    ]);

    $fake->cachedContents()->retrieve('cachedContents/123');

    $fake->assertSent(resource: CachedContents::class, callback: function ($method, $parameters) {
        return $method === 'retrieve' && $parameters[0] === 'cachedContents/123';
    });
});

it('records a list request', function () {
    $fake = new ClientFake([
        ListResponse::fake(),
    ]);

    $fake->cachedContents()->list();

    $fake->assertSent(resource: CachedContents::class, callback: function ($method) {
        return $method === 'list';
    });
});

it('records an update request', function () {
    $fake = new ClientFake([
        MetadataResponse::fake(),
    ]);

    $fake->cachedContents()->update('cachedContents/123');

    $fake->assertSent(resource: CachedContents::class, callback: function ($method, $parameters) {
        return $method === 'update' && $parameters[0] === 'cachedContents/123';
    });
});

it('records a delete request', function () {
    $fake = new ClientFake([
        MetadataResponse::fake(),
    ]);

    $fake->cachedContents()->delete('cachedContents/123');

    $fake->assertSent(resource: CachedContents::class, callback: function ($method, $parameters) {
        return $method === 'delete' && $parameters[0] === 'cachedContents/123';
    });
});
