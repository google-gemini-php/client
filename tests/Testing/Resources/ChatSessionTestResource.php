<?php

declare(strict_types=1);

use Gemini\Data\UploadedFile;
use Gemini\Enums\MimeType;
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

it('records a chat message request with an uploaded file', function () {
    $fake = new ClientFake([
        GenerateContentResponse::fake(),
    ]);

    $fake->chat()->sendMessage(['Hello', $file = new UploadedFile('123-456', MimeType::TEXT_PLAIN)]);

    $fake->assertSent(resource: ChatSession::class, model: ModelType::GEMINI_PRO, callback: function (string $method, array $parameters) use ($file) {
        return $method === 'sendMessage' &&
            $parameters[0][0] === 'Hello' &&
            $parameters[0][1] === $file;
    });
});
