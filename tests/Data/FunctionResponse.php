<?php

use Gemini\Data\Blob;
use Gemini\Data\FunctionResponse;
use Gemini\Data\FunctionResponsePart;
use Gemini\Data\Part;
use Gemini\Enums\FunctionResponseScheduling;
use Gemini\Enums\MimeType;

test('to array', function () {
    $functionResponse = new FunctionResponse(
        name: 'get_weather',
        response: ['temperature' => 21],
        id: 'call-1',
    );

    expect($functionResponse->toArray())
        ->toBe([
            'name' => 'get_weather',
            'response' => ['temperature' => 21],
            'id' => 'call-1',
        ]);
});

test('to array with parts', function () {
    $functionResponse = new FunctionResponse(
        name: 'get_image',
        response: ['image' => ['$ref' => 'chart.png']],
        parts: [
            new FunctionResponsePart(inlineData: new Blob(mimeType: MimeType::IMAGE_PNG, data: 'aGVsbG8=')),
        ],
        willContinue: false,
        scheduling: FunctionResponseScheduling::WHEN_IDLE,
    );

    expect($functionResponse->toArray())
        ->toBe([
            'name' => 'get_image',
            'response' => ['image' => ['$ref' => 'chart.png']],
            'id' => null,
            'parts' => [
                ['inlineData' => ['mimeType' => 'image/png', 'data' => 'aGVsbG8=']],
            ],
            'willContinue' => false,
            'scheduling' => 'WHEN_IDLE',
        ]);
});

test('from', function () {
    $functionResponse = FunctionResponse::from([
        'name' => 'get_image',
        'response' => ['status' => 'ok'],
        'parts' => [
            ['inlineData' => ['mimeType' => 'image/jpeg', 'data' => 'aGVsbG8=']],
        ],
        'willContinue' => true,
        'scheduling' => 'SILENT',
    ]);

    expect($functionResponse)
        ->name->toBe('get_image')
        ->parts->toHaveCount(1)
        ->parts->{0}->inlineData->mimeType->toBe(MimeType::IMAGE_JPEG)
        ->parts->{0}->inlineData->data->toBe('aGVsbG8=')
        ->willContinue->toBeTrue()
        ->scheduling->toBe(FunctionResponseScheduling::SILENT);
});

test('from without optional fields', function () {
    $functionResponse = FunctionResponse::from([
        'name' => 'get_weather',
        'response' => ['temperature' => 21],
        'scheduling' => 'SOME_NEW_SCHEDULING',
    ]);

    expect($functionResponse)
        ->id->toBeNull()
        ->parts->toBeNull()
        ->willContinue->toBeNull()
        ->scheduling->toBeNull();
});

test('part round trip', function () {
    $part = new Part(functionResponse: new FunctionResponse(
        name: 'get_image',
        response: ['status' => 'ok'],
        parts: [
            new FunctionResponsePart(inlineData: new Blob(mimeType: MimeType::IMAGE_PNG, data: 'aGVsbG8=')),
        ],
    ));

    expect(Part::from($part->toArray())->toArray())->toBe($part->toArray());
});
