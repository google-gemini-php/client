<?php

use Gemini\Enums\ModelType;
use Gemini\Resources\GenerativeModel;
use Gemini\Resources\Models;

it('has models', function () {
    $gemini = Gemini::client(apiKey: 'foo');

    expect($gemini->models())->toBeInstanceOf(Models::class);
});

it('has generative model', function () {
    $gemini = Gemini::client(apiKey: 'foo');

    expect($gemini->generativeModel(model: ModelType::GEMINI_PRO))->toBeInstanceOf(GenerativeModel::class);
});
