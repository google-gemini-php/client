<?php

declare(strict_types=1);

use Gemini\Enums\ModelType;
use Gemini\Resources\ChatSession;
use Gemini\Responses\GenerativeModel\GenerateContentResponse;
use Gemini\Testing\ClientFake;

it('records a chat message request', function () {
    $fake = new ClientFake([
        GenerateContentResponse::fake(),
    ]);

    $fake->chat()->sendMessage('Hello');

    $fake->assertSent(resource: ChatSession::class, model: ModelType::GEMINI_PRO, callback: function (string $method, array $parameters) {
        return $method === 'sendMessage' &&
            $parameters[0] === 'Hello';
    });
});
