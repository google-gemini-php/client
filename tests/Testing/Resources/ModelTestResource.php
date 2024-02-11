<?php

declare(strict_types=1);

use Gemini\Enums\ModelType;
use Gemini\Resources\Models;
use Gemini\Responses\Models\ListModelResponse;
use Gemini\Responses\Models\RetrieveModelResponse;
use Gemini\Testing\ClientFake;

it('records a model retrieve request', function () {
    $fake = new ClientFake([
        RetrieveModelResponse::fake(),
    ]);

    $fake->models()->retrieve(model: ModelType::GEMINI_PRO);

    $fake->assertSent(resource: Models::class, callback: function ($method, $parameters) {
        return $method === 'retrieve' &&
            $parameters[0] === ModelType::GEMINI_PRO;
    });
});

it('records a model list request', function () {
    $fake = new ClientFake([
        ListModelResponse::fake(),
    ]);

    $fake->models()->list();

    $fake->assertSent(resource: Models::class, callback: function ($method) {
        return $method === 'list';
    });
});
