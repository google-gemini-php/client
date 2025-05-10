<?php

use Gemini\Resources\Files;
use Gemini\Resources\GenerativeModel;
use Gemini\Resources\Models;

it('has models', function () {
    $gemini = Gemini::client(apiKey: 'foo');

    expect($gemini->models())->toBeInstanceOf(Models::class);
});

it('has generative model', function () {
    $gemini = Gemini::client(apiKey: 'foo');

    expect($gemini->generativeModel(model: 'models/gemini-1.5-flash'))->toBeInstanceOf(GenerativeModel::class);
});

it('has files', function () {
    $gemini = Gemini::client(apiKey: 'foo');

    expect($gemini->files())->toBeInstanceOf(Files::class);
});
