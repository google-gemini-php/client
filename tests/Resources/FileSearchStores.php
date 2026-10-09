<?php

use Gemini\Enums\Method;
use Gemini\Enums\MimeType;
use Gemini\Requests\FileSearchStores\UploadRequest;
use Gemini\Responses\FileSearchStores\Documents\DocumentResponse;
use Gemini\Responses\FileSearchStores\Documents\ListResponse as DocumentListResponse;
use Gemini\Responses\FileSearchStores\FileSearchStoreResponse;
use Gemini\Responses\FileSearchStores\ListResponse;
use Gemini\Responses\FileSearchStores\UploadResponse;
use Gemini\Transporters\DTOs\ResponseDTO;

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
        response: new ResponseDTO([])
    );

    $client->fileSearchStores()->delete('fileSearchStores/123-456');

    // If no exception, it passed.
    expect(true)->toBeTrue();
});

test('delete with force', function () {
    $client = mockClient(
        method: Method::DELETE,
        endpoint: 'fileSearchStores/123-456',
        response: new ResponseDTO([]),
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

    test('upload request body contains custom metadata', function () {
        $request = new UploadRequest('fileSearchStores/123', $this->tmpFilepath, 'Display', MimeType::TEXT_PLAIN, [
            'key_string' => 'value',
            'key_int' => 123,
            'key_float' => 1.5,
            'key_list' => ['a', 2],
        ]);

        $body = (string) $request->toRequest(baseUrl: 'https://generativelanguage.googleapis.com/v1beta/')->getBody();

        expect($body)->toContain(json_encode([
            'displayName' => 'Display',
            'mimeType' => 'text/plain',
            'customMetadata' => [
                ['key' => 'key_string', 'stringValue' => 'value'],
                ['key' => 'key_int', 'numericValue' => 123],
                ['key' => 'key_float', 'numericValue' => 1.5],
                ['key' => 'key_list', 'stringListValue' => ['values' => ['a', '2']]],
            ],
        ]));
    });
});

test('import file', function () {
    $client = mockClient(
        method: Method::POST,
        endpoint: 'fileSearchStores/123:importFile',
        response: UploadResponse::fake(),
        params: [
            'fileName' => 'files/abc-123',
            'customMetadata' => [
                ['key' => 'author', 'stringValue' => 'Jane'],
                ['key' => 'year', 'numericValue' => 2026],
            ],
        ],
        validateParams: true
    );

    $result = $client->fileSearchStores()->importFile('fileSearchStores/123', 'files/abc-123', ['author' => 'Jane', 'year' => 2026]);

    expect($result)
        ->toBeInstanceOf(UploadResponse::class)
        ->name->toBe('operations/123-456');
});

test('import file without custom metadata', function () {
    $client = mockClient(
        method: Method::POST,
        endpoint: 'fileSearchStores/123:importFile',
        response: UploadResponse::fake(),
        params: ['fileName' => 'files/abc-123'],
        validateParams: true
    );

    expect($client->fileSearchStores()->importFile('fileSearchStores/123', 'files/abc-123'))
        ->toBeInstanceOf(UploadResponse::class);
});

test('get operation', function () {
    $client = mockClient(
        method: Method::GET,
        endpoint: 'fileSearchStores/123/upload/operations/456',
        response: new ResponseDTO([
            'name' => 'fileSearchStores/123/upload/operations/456',
            'done' => true,
            'response' => ['documentName' => 'fileSearchStores/123/documents/789'],
        ]),
    );

    expect($client->fileSearchStores()->getOperation('fileSearchStores/123/upload/operations/456'))
        ->toBeInstanceOf(UploadResponse::class)
        ->name->toBe('fileSearchStores/123/upload/operations/456')
        ->done->toBeTrue()
        ->response->toBe(['documentName' => 'fileSearchStores/123/documents/789']);
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
        response: new ResponseDTO([])
    );

    $client->fileSearchStores()->deleteDocument('fileSearchStores/123/documents/abc');

    expect(true)->toBeTrue();
});

test('delete document with force', function () {
    $client = mockClient(
        method: Method::DELETE,
        endpoint: 'fileSearchStores/123/documents/abc',
        response: new ResponseDTO([]),
        params: ['force' => 'true'],
        validateParams: true
    );

    $client->fileSearchStores()->deleteDocument('fileSearchStores/123/documents/abc', true);

    expect(true)->toBeTrue();
});
