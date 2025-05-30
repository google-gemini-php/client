<?php

use Gemini\Enums\Method;
use Gemini\Enums\MimeType;
use Gemini\Responses\Files\ListResponse;
use Gemini\Responses\Files\MetadataResponse;
use Gemini\Responses\Files\UploadResponse;

describe('file upload', function () {
    beforeEach(function () {
        $this->tmpFile = tmpfile();
        $this->tmpFilepath = stream_get_meta_data($this->tmpFile)['uri'];
    });
    afterEach(function () {
        fclose($this->tmpFile);
    });

    test('request', function () {
        $client = mockClient(method: Method::POST, endpoint: 'files', response: UploadResponse::fake(), rootPath: '/upload/v1beta/');

        $result = $client->files()->upload($this->tmpFilepath, MimeType::TEXT_PLAIN, 'Display');

        expect($result)
            ->toBeInstanceOf(MetadataResponse::class);
    });
});

test('metadata get', function () {
    $client = mockClient(method: Method::GET, endpoint: 'files/123-456', response: MetadataResponse::fake());

    $result = $client->files()->metadataGet('123-456');

    expect($result)
        ->toBeInstanceOf(MetadataResponse::class);
});

test('files list', function () {
    $client = mockClient(method: Method::GET, endpoint: 'files', response: ListResponse::fake());

    $result = $client->files()->list();

    expect($result)
        ->toBeInstanceOf(ListResponse::class);
});
