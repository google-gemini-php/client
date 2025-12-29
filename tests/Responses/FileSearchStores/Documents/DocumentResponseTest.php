<?php

use Gemini\Enums\DocumentState;
use Gemini\Responses\FileSearchStores\Documents\DocumentResponse;

test('from', function () {
    $attributes = [
        'name' => 'fileSearchStores/123/documents/abc',
        'displayName' => 'My Document',
        'customMetadata' => [],
        'updateTime' => '2024-01-01T00:00:00Z',
        'createTime' => '2024-01-01T00:00:00Z',
        'mimeType' => 'text/plain',
        'sizeBytes' => '1024',
        'state' => 'STATE_ACTIVE',
    ];

    $response = DocumentResponse::from($attributes);

    expect($response)
        ->toBeInstanceOf(DocumentResponse::class)
        ->name->toBe('fileSearchStores/123/documents/abc')
        ->displayName->toBe('My Document')
        ->customMetadata->toBe([])
        ->updateTime->toBe('2024-01-01T00:00:00Z')
        ->createTime->toBe('2024-01-01T00:00:00Z')
        ->mimeType->toBe('text/plain')
        ->sizeBytes->toBe(1024)
        ->state->toBe(DocumentState::Active);
});

test('from with missing fields', function () {
    $attributes = [
        'name' => 'fileSearchStores/123/documents/abc',
    ];

    $response = DocumentResponse::from($attributes);

    expect($response)
        ->toBeInstanceOf(DocumentResponse::class)
        ->name->toBe('fileSearchStores/123/documents/abc')
        ->displayName->toBeNull()
        ->customMetadata->toBe([])
        ->updateTime->toBeNull()
        ->createTime->toBeNull()
        ->mimeType->toBeNull()
        ->sizeBytes->toBe(0)
        ->state->toBeNull();
});

test('to array', function () {
    $response = new DocumentResponse(
        name: 'fileSearchStores/123/documents/abc',
        displayName: 'My Document',
        customMetadata: [],
        updateTime: '2024-01-01T00:00:00Z',
        createTime: '2024-01-01T00:00:00Z',
        mimeType: 'text/plain',
        sizeBytes: 1024,
        state: DocumentState::Active,
    );

    expect($response->toArray())
        ->toBe([
            'name' => 'fileSearchStores/123/documents/abc',
            'displayName' => 'My Document',
            'customMetadata' => [],
            'updateTime' => '2024-01-01T00:00:00Z',
            'createTime' => '2024-01-01T00:00:00Z',
            'mimeType' => 'text/plain',
            'sizeBytes' => 1024,
            'state' => 'STATE_ACTIVE',
        ]);
});

test('fake', function () {
    $response = DocumentResponse::fake();

    expect($response)
        ->toBeInstanceOf(DocumentResponse::class)
        ->name->toBe('fileSearchStores/123/documents/abc')
        ->state->toBe(DocumentState::Active);
});
