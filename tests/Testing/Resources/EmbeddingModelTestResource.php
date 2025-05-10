<?php

declare(strict_types=1);

use Gemini\Responses\GenerativeModel\EmbedContentResponse;
use Gemini\Testing\ClientFake;

it('records a embed content request', function () {
    $fake = new ClientFake([
        EmbedContentResponse::fake(),
    ]);

    $fake->embeddingModel('models/text-embedding-004')->embedContent('Hello');

    $fake->embeddingModel('models/text-embedding-004')->assertSent(function (string $method, array $parameters) {
        return $method === 'embedContent' &&
            $parameters[0] === 'Hello';
    });
});
