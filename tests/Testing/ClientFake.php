<?php

declare(strict_types=1);

use Gemini\Enums\ModelType;
use Gemini\Exceptions\ErrorException;
use Gemini\Resources\GenerativeModel;
use Gemini\Responses\GenerativeModel\GenerateContentResponse;
use Gemini\Testing\ClientFake;
use PHPUnit\Framework\ExpectationFailedException;

it('returns a fake response', function () {
    $fake = new ClientFake([
        GenerateContentResponse::fake([
            'candidates' => [
                [
                    'content' => [
                        'parts' => [
                            [
                                'text' => 'success',
                            ],
                        ],
                    ],
                ],
            ],
        ]),
    ]);

    $result = $fake->geminiPro()->generateContent('test');

    expect($result->text())->toBe('success');
});

it('throws fake exceptions', function () {
    $fake = new ClientFake([
        new ErrorException([
            'message' => 'The model `gemini-basic` does not exist',
            'status' => 'INVALID_ARGUMENT',
            'code' => 400,
        ]),
    ]);

    $fake->geminiPro()->generateContent('test');
})->expectExceptionMessage('The model `gemini-basic` does not exist');

it('throws an exception if there is no more fake response', function () {
    $fake = new ClientFake([
        GenerateContentResponse::fake(),
    ]);

    $fake->geminiPro()->generateContent('test');

    $fake->geminiPro()->generateContent('test');

})->expectExceptionMessage('No fake responses left');

it('allows to add more responses', function () {
    $fake = new ClientFake([
        GenerateContentResponse::fake([
            'candidates' => [
                [
                    'content' => [
                        'parts' => [
                            [
                                'text' => 'response-1',
                            ],
                        ],
                    ],
                ],
            ],
        ]),
    ]);

    $result = $fake->geminiPro()->generateContent('test');

    expect($result->text())->toBe('response-1');

    $fake->addResponses([
        GenerateContentResponse::fake([
            'candidates' => [
                [
                    'content' => [
                        'parts' => [
                            [
                                'text' => 'response-2',
                            ],
                        ],
                    ],
                ],
            ],
        ]),
    ]);

    $result = $fake->geminiPro()->generateContent('test');

    expect($result->text())->toBe('response-2');
});

it('asserts a request was sent', function () {
    $fake = new ClientFake([
        GenerateContentResponse::fake(),
    ]);

    $fake->geminiPro()->generateContent('test');

    $fake->assertSent(resource: GenerativeModel::class, model: ModelType::GEMINI_PRO, callback: function (string $method, array $parameters) {
        return $method === 'generateContent';
    });
});

it('throws an exception if a request was not sent', function () {
    $fake = new ClientFake([
        GenerateContentResponse::fake(),
    ]);

    $fake->assertSent(resource: GenerativeModel::class, callback: function (string $method, array $parameters) {
        return $method === 'create' &&
            $parameters['model'] === 'gpt-3.5-turbo-instruct' &&
            $parameters['prompt'] === 'PHP is ';
    });
})->expectException(ExpectationFailedException::class);

it('asserts a request was sent on the resource', function () {
    $fake = new ClientFake([
        GenerateContentResponse::fake(),
    ]);

    $fake->geminiPro()->generateContent('test');

    $fake->geminiPro()->assertSent(function (string $method, array $parameters) {
        return
            $method === 'generateContent' &&
            $parameters[0] === 'test';
    });
});

it('asserts a request was sent n times', function () {
    $fake = new ClientFake([
        GenerateContentResponse::fake(),
        GenerateContentResponse::fake(),
    ]);

    $fake->geminiPro()->generateContent('test');

    $fake->geminiPro()->generateContent('test');

    $fake->assertSent(resource: GenerativeModel::class, model: ModelType::GEMINI_PRO, callback: 2);
});

it('throws an exception if a request was not sent n times', function () {
    $fake = new ClientFake([
        GenerateContentResponse::fake(),
        GenerateContentResponse::fake(),
    ]);

    $fake->geminiPro()->generateContent('test');

    $fake->assertSent(resource: GenerativeModel::class, model: ModelType::GEMINI_PRO, callback: 2);
})->expectException(ExpectationFailedException::class);

it('asserts a request was not sent', function () {
    $fake = new ClientFake;

    $fake->assertNotSent(GenerativeModel::class);
});

it('throws an exception if an unexpected request was sent', function () {
    $fake = new ClientFake([
        GenerateContentResponse::fake(),
    ]);

    $fake->geminiPro()->generateContent('test');

    $fake->assertNotSent(GenerativeModel::class);
})->expectException(ExpectationFailedException::class);

it('asserts a request was not sent for a model on the resource', function () {
    $fake = new ClientFake([
        GenerateContentResponse::fake(),
    ]);

    $fake->geminiPro()->generateContent('test');

    $fake->assertNotSent(resource: GenerativeModel::class, model: ModelType::GEMINI_PRO_VISION);
});

it('asserts a request was not sent on the resource', function () {
    $fake = new ClientFake([
        GenerateContentResponse::fake(),
    ]);

    $fake->geminiPro()->assertNotSent();
});

it('asserts no request was sent', function () {
    $fake = new ClientFake;

    $fake->assertNothingSent();
});

it('throws an exception if any request was sent when non was expected', function () {
    $fake = new ClientFake([
        GenerateContentResponse::fake(),
    ]);

    $fake->geminiPro()->generateContent('test');

    $fake->assertNothingSent();
})->expectException(ExpectationFailedException::class);
