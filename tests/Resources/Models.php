<?php

use Gemini\Data\Model;
use Gemini\Enums\Method;
use Gemini\Enums\ModelType;
use Gemini\Responses\Models\ListModelResponse;
use Gemini\Responses\Models\RetrieveModelResponse;

test('list', function () {
    $client = mockClient(method: Method::GET, endpoint: 'models', response: ListModelResponse::fake());

    $result = $client->models()->list();

    expect($result)
        ->toBeInstanceOf(ListModelResponse::class)
        ->models->toBeArray()->toHaveCount(3)
        ->models->each->toBeInstanceOf(Model::class)
        ->and($result)
        ->models->{0}->name->toBe('models/gemini-pro');
});

test('list with page size', function () {
    $client = mockClient(method: Method::GET, endpoint: 'models', response: ListModelResponse::fake([
        'nextPageToken' => 'next',
    ]));

    $result = $client->models()->list(pageSize: 1);

    expect($result)
        ->toBeInstanceOf(ListModelResponse::class)
        ->models->toBeArray()->toHaveCount(3)
        ->models->each->toBeInstanceOf(Model::class)
        ->and($result)
        ->models->{0}->name->toBe('models/gemini-pro')
        ->nextPageToken->toBe('next');

});

test('retrieve', function () {
    $modelType = ModelType::GEMINI_PRO;
    $client = mockClient(method: Method::GET, endpoint: $modelType->value, response: RetrieveModelResponse::fake());

    $result = $client->models()->retrieve(model: $modelType);

    expect($result)
        ->toBeInstanceOf(RetrieveModelResponse::class)
        ->model->name->toBe($modelType->value)
        ->model->version->toBe('001');
});

test('retrieve for custom model', function () {
    $modelType = 'models/gemini-1.0-pro-001';
    $client = mockClient(method: Method::GET, endpoint: $modelType, response: RetrieveModelResponse::fake([
        'name' => $modelType,
    ]));

    $result = $client->models()->retrieve(model: $modelType);

    expect($result)
        ->toBeInstanceOf(RetrieveModelResponse::class)
        ->model->name->toBe($modelType)
        ->model->version->toBe('001');
});
