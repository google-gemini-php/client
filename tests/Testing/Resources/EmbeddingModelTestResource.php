<?php

declare(strict_types=1);

use Gemini\Responses\GenerativeModel\EmbedContentResponse;
use Gemini\Testing\ClientFake;

it('records a embed content request', function () {
    $fake = new ClientFake([
        EmbedContentResponse::fake(),
    ]);

    $fake->embeddingModel()->embedContent('Hello');

    $fake->embeddingModel()->assertSent(function (string $method, array $parameters) {
        return $method === 'embedContent' &&
            $parameters[0] === 'Hello';
    });
});
