<?php

declare(strict_types=1);

use Gemini\Enums\MimeType;
use Gemini\Resources\FileSearchStores;
use Gemini\Responses\FileSearchStores\UploadResponse;
use Gemini\Testing\ClientFake;

it('records a upload request', function () {
    $fake = new ClientFake([
        UploadResponse::fake(),
    ]);

    $fake->fileSearchStores()->upload('store-name', 'filename.pdf', MimeType::APPLICATION_PDF, 'display name', ['key' => 'value']);

    $fake->assertSent(resource: FileSearchStores::class, callback: function ($method, $parameters) {
        return $method === 'upload' &&
            $parameters[0] === 'store-name' &&
            $parameters[1] === 'filename.pdf' &&
            $parameters[2] === MimeType::APPLICATION_PDF &&
            $parameters[3] === 'display name' &&
            $parameters[4] === ['key' => 'value'];
    });
});

it('records an import file request', function () {
    $fake = new ClientFake([
        UploadResponse::fake(),
    ]);

    $fake->fileSearchStores()->importFile('store-name', 'files/abc-123', ['key' => 'value']);

    $fake->assertSent(resource: FileSearchStores::class, callback: function ($method, $parameters) {
        return $method === 'importFile' &&
            $parameters[0] === 'store-name' &&
            $parameters[1] === 'files/abc-123' &&
            $parameters[2] === ['key' => 'value'];
    });
});

it('records a get operation request', function () {
    $fake = new ClientFake([
        UploadResponse::fake(),
    ]);

    $fake->fileSearchStores()->getOperation('fileSearchStores/123/operations/456');

    $fake->assertSent(resource: FileSearchStores::class, callback: function ($method, $parameters) {
        return $method === 'getOperation' &&
            $parameters[0] === 'fileSearchStores/123/operations/456';
    });
});
