<?php

use Gemini\Data\ContentEmbedding;
use Gemini\Enums\Method;
use Gemini\Responses\GenerativeModel\BatchEmbedContentsResponse;
use Gemini\Responses\GenerativeModel\EmbedContentResponse;

test('embed content', function () {
    $modelType = 'models/text-embedding-004';
    $client = mockClient(method: Method::POST, endpoint: "{$modelType}:embedContent", response: EmbedContentResponse::fake());

    $result = $client->embeddingModel($modelType)->embedContent('Test');

    expect($result)
        ->toBeInstanceOf(EmbedContentResponse::class)
        ->embedding->toBeInstanceOf(ContentEmbedding::class)
        ->embedding->values->toBeArray()->toHaveCount(7);
});
test('batch embed contents', function () {
    $modelType = 'models/text-embedding-004';
    $client = mockClient(method: Method::POST, endpoint: "{$modelType}:batchEmbedContents", response: BatchEmbedContentsResponse::fake());

    $result = $client->embeddingModel($modelType)->batchEmbedContents('Test', 'Test2');

    expect($result)
        ->toBeInstanceOf(BatchEmbedContentsResponse::class)
        ->embeddings->toBeArray()->toHaveCount(2)
        ->embeddings->each->toBeInstanceOf(ContentEmbedding::class)
        ->embeddings->each(fn ($embeddingModel) => $embeddingModel->values->toBeArray()->toHaveCount(7));
});

test('embed content for custom model', function () {
    $modelType = 'models/gemini-1.0-pro-001';
    $client = mockClient(method: Method::POST, endpoint: "{$modelType}:embedContent", response: EmbedContentResponse::fake());

    $result = $client->embeddingModel(model: $modelType)->embedContent('Test');

    expect($result)
        ->toBeInstanceOf(EmbedContentResponse::class)
        ->embedding->toBeInstanceOf(ContentEmbedding::class)
        ->embedding->values->toBeArray()->toHaveCount(7);
});
