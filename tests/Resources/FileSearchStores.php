<?php

use Gemini\Enums\Method;
use Gemini\Enums\MimeType;
use Gemini\Responses\FileSearchStores\Documents\DocumentResponse;
use Gemini\Responses\FileSearchStores\Documents\ListResponse as DocumentListResponse;
use Gemini\Responses\FileSearchStores\FileSearchStoreResponse;
use Gemini\Responses\FileSearchStores\ListResponse;
use Gemini\Responses\FileSearchStores\UploadResponse;

test('create', function () {
    $client = mockClient(
        method: Method::POST,
        endpoint: 'fileSearchStores',
        response: FileSearchStoreResponse::fake(),
        params: ['displayName' => 'My Store'],
        validateParams: true
    );

    $result = $client->fileSearchStores()->create('My Store');

    expect($result)
        ->toBeInstanceOf(FileSearchStoreResponse::class)
        ->name->toBe('fileSearchStores/123-456')
        ->displayName->toBe('My Store');
});

test('get', function () {
    $client = mockClient(
        method: Method::GET,
        endpoint: 'fileSearchStores/123-456',
        response: FileSearchStoreResponse::fake()
    );

    $result = $client->fileSearchStores()->get('fileSearchStores/123-456');

    expect($result)
        ->toBeInstanceOf(FileSearchStoreResponse::class)
        ->name->toBe('fileSearchStores/123-456');
});

test('list', function () {
    $client = mockClient(
        method: Method::GET,
        endpoint: 'fileSearchStores',
        response: ListResponse::fake()
    );

    $result = $client->fileSearchStores()->list();

    expect($result)
        ->toBeInstanceOf(ListResponse::class)
        ->fileSearchStores->toHaveCount(1)
        ->fileSearchStores->each->toBeInstanceOf(FileSearchStoreResponse::class);
});

test('delete', function () {
    $client = mockClient(
        method: Method::DELETE,
        endpoint: 'fileSearchStores/123-456',
        response: new \Gemini\Transporters\DTOs\ResponseDTO([])
    );

    $client->fileSearchStores()->delete('fileSearchStores/123-456');

    // If no exception, it passed.
    expect(true)->toBeTrue();
});

test('delete with force', function () {
    $client = mockClient(
        method: Method::DELETE,
        endpoint: 'fileSearchStores/123-456',
        response: new \Gemini\Transporters\DTOs\ResponseDTO([]),
        params: ['force' => 'true'],
        validateParams: true
    );

    $client->fileSearchStores()->delete('fileSearchStores/123-456', true);

    expect(true)->toBeTrue();
});

describe('upload', function () {
    beforeEach(function () {
        $this->tmpFile = tmpfile();
        $this->tmpFilepath = stream_get_meta_data($this->tmpFile)['uri'];
    });
    afterEach(function () {
        fclose($this->tmpFile);
    });

    test('upload', function () {
        $client = mockClient(
            method: Method::POST,
            endpoint: 'fileSearchStores/123:uploadToFileSearchStore',
            response: UploadResponse::fake(),
            rootPath: '/upload/v1beta/'
        );

        $result = $client->fileSearchStores()->upload('fileSearchStores/123', $this->tmpFilepath, MimeType::TEXT_PLAIN, 'Display');

        expect($result)
            ->toBeInstanceOf(UploadResponse::class)
            ->name->toBe('operations/123-456');
    });

    test('upload with custom metadata', function () {
        $client = mockClient(
            method: Method::POST,
            endpoint: 'fileSearchStores/123:uploadToFileSearchStore',
            response: UploadResponse::fake(),
            rootPath: '/upload/v1beta/'
        );

        $result = $client->fileSearchStores()->upload(
            'fileSearchStores/123',
            $this->tmpFilepath,
            MimeType::TEXT_PLAIN,
            'Display',
            [
                'key_string' => 'value',
                'key_int' => 123,
                'key_list' => ['a', 'b'],
            ]
        );

        expect($result)
            ->toBeInstanceOf(UploadResponse::class)
            ->name->toBe('operations/123-456');
    });
});

test('list documents', function () {
    $client = mockClient(
        method: Method::GET,
        endpoint: 'fileSearchStores/123/documents',
        response: DocumentListResponse::fake()
    );

    $result = $client->fileSearchStores()->listDocuments('fileSearchStores/123');

    expect($result)
        ->toBeInstanceOf(DocumentListResponse::class)
        ->documents->toHaveCount(1)
        ->documents->each->toBeInstanceOf(DocumentResponse::class);
});

test('get document', function () {
    $client = mockClient(
        method: Method::GET,
        endpoint: 'fileSearchStores/123/documents/abc',
        response: DocumentResponse::fake()
    );

    $result = $client->fileSearchStores()->getDocument('fileSearchStores/123/documents/abc');

    expect($result)
        ->toBeInstanceOf(DocumentResponse::class)
        ->name->toBe('fileSearchStores/123/documents/abc');
});

test('delete document', function () {
    $client = mockClient(
        method: Method::DELETE,
        endpoint: 'fileSearchStores/123/documents/abc',
        response: new \Gemini\Transporters\DTOs\ResponseDTO([])
    );

    $client->fileSearchStores()->deleteDocument('fileSearchStores/123/documents/abc');

    expect(true)->toBeTrue();
});

test('delete document with force', function () {
    $client = mockClient(
        method: Method::DELETE,
        endpoint: 'fileSearchStores/123/documents/abc',
        response: new \Gemini\Transporters\DTOs\ResponseDTO([]),
        params: ['force' => 'true'],
        validateParams: true
    );

    $client->fileSearchStores()->deleteDocument('fileSearchStores/123/documents/abc', true);

    expect(true)->toBeTrue();
});
