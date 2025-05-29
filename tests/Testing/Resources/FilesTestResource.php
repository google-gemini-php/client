<?php

declare(strict_types=1);

use Gemini\Enums\MimeType;
use Gemini\Resources\Files;
use Gemini\Responses\Files\ListResponse;
use Gemini\Responses\Files\MetadataResponse;
use Gemini\Testing\ClientFake;

it('records a upload request', function () {
    $fake = new ClientFake([
        MetadataResponse::fake(),
    ]);

    $fake->files()->upload('filename.pdf', MimeType::APPLICATION_PDF, 'display name');

    $fake->assertSent(resource: Files::class, callback: function ($method, $parameters) {
        return $method === 'upload' &&
            $parameters[0] === 'filename.pdf' &&
            $parameters[1] === MimeType::APPLICATION_PDF &&
            $parameters[2] === 'display name';
    });
});

it('records a metadata get request', function () {
    $fake = new ClientFake([
        MetadataResponse::fake(),
    ]);

    $fake->files()->metadataGet('filename.pdf');

    $fake->assertSent(resource: Files::class, callback: function ($method, $parameters) {
        return $method === 'metadataGet' &&
            $parameters[0] === 'filename.pdf';
    });
});

it('records a file list request', function () {
    $fake = new ClientFake([
        ListResponse::fake(),
    ]);

    $fake->files()->list();

    $fake->assertSent(resource: Files::class, callback: function ($method) {
        return $method === 'list';
    });
});

it('records a file delete request', function () {
    $fake = new ClientFake([
        MetadataResponse::fake(), // no actual response
    ]);

    $fake->files()->delete('filename.pdf');

    $fake->assertSent(resource: Files::class, callback: function ($method, $parameters) {
        return $method === 'delete' &&
            $parameters[0] === 'filename.pdf';
    });
});
