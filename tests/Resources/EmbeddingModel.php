<?php

use Gemini\Data\ContentEmbedding;
use Gemini\Enums\Method;
use Gemini\Enums\ModelType;
use Gemini\Responses\GenerativeModel\EmbedContentResponse;

test('embed content', function () {
    $modelType = ModelType::EMBEDDING;
    $client = mockClient(method: Method::POST, endpoint: "{$modelType->value}:embedContent", response: EmbedContentResponse::fake());

    $result = $client->embeddingModel()->embedContent('Test');

    expect($result)
        ->toBeInstanceOf(EmbedContentResponse::class)
        ->embedding->toBeInstanceOf(ContentEmbedding::class)
        ->embedding->values->toBeArray()->toHaveCount(7);
});
