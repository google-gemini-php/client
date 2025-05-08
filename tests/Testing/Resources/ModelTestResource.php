<?php

declare(strict_types=1);

use Gemini\Resources\Models;
use Gemini\Responses\Models\ListModelResponse;
use Gemini\Responses\Models\RetrieveModelResponse;
use Gemini\Testing\ClientFake;

it('records a model retrieve request', function () {
    $fake = new ClientFake([
        RetrieveModelResponse::fake(),
    ]);

    $fake->models()->retrieve(model: 'models/gemini-1.5-pro');

    $fake->assertSent(resource: Models::class, callback: function ($method, $parameters) {
        return $method === 'retrieve' &&
            $parameters[0] === 'models/gemini-1.5-pro';
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
