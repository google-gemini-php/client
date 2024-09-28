<?php

use Gemini\Enums\ModelType;
use Gemini\Exceptions\ErrorException;
use Gemini\Exceptions\TransporterException;
use Gemini\Exceptions\UnserializableResponse;
use Gemini\Requests\GenerativeModel\GenerateContentRequest;
use Gemini\Requests\GenerativeModel\StreamGenerateContentRequest;
use Gemini\Requests\Model\ListModelRequest;
use Gemini\Responses\Models\ListModelResponse;
use Gemini\Transporters\HttpTransporter;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Psr7\Request as Psr7Request;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

beforeEach(function () {
    $this->client = Mockery::mock(ClientInterface::class);

    $this->http = new HttpTransporter(
        client: $this->client,
        baseUrl: 'https://generativelanguage.googleapis.com/v1/',
        headers: [
            'x-goog-api-key' => 'foo',
        ],
        queryParams: [
            'foo' => 'bar',
        ],
        streamHandler: fn (RequestInterface $request): ResponseInterface => $this->client->sendAsyncRequest($request, ['stream' => true]),

    );
});

test('request', function () {
    $request = new ListModelRequest;

    $response = new Response(200, ['Content-Type' => 'application/json; charset=utf-8'], json_encode([
        'test',
    ]));

    $this->client
        ->shouldReceive('sendRequest')
        ->once()
        ->withArgs(function (Psr7Request $request) {
            expect($request->getMethod())->toBe('GET')
                ->and($request->getUri())
                ->getHost()->toBe('generativelanguage.googleapis.com')
                ->getScheme()->toBe('https')
                ->getPath()->toBe('/v1/models');

            return true;
        })->andReturn($response);

    $this->http->request($request);
});

test('request response', function () {
    $request = new ListModelRequest;

    $data = ListModelResponse::fake()->toArray();
    $response = new Response(200, ['Content-Type' => 'application/json; charset=utf-8'], json_encode($data, JSON_PRESERVE_ZERO_FRACTION));

    $this->client
        ->shouldReceive('sendRequest')
        ->once()
        ->andReturn($response);

    $response = $this->http->request($request);

    expect($response->data())->toBe($data);
});

test('request server user errors', function () {
    $request = new ListModelRequest;

    $response = new Response(400, ['Content-Type' => 'application/json; charset=utf-8'], json_encode([
        'error' => [
            'code' => 400,
            'message' => 'API key not valid. Please pass a valid API key.',
            'status' => 'INVALID_ARGUMENT',
            'details' => [],
        ],
    ]));

    $this->client
        ->shouldReceive('sendRequest')
        ->once()
        ->andReturn($response);

    expect(fn () => $this->http->request($request))
        ->toThrow(function (ErrorException $e) {
            expect($e->getMessage())->toBe('API key not valid. Please pass a valid API key.')
                ->and($e->getErrorMessage())->toBe('API key not valid. Please pass a valid API key.')
                ->and($e->getErrorCode())->toBe(400)
                ->and($e->getErrorStatus())->toBe('INVALID_ARGUMENT');
        });
});

test('request server errors', function () {
    $request = new GenerateContentRequest(
        model: ModelType::GEMINI_PRO->value,
        parts: ['Test']
    );
    $response = new Response(400, ['Content-Type' => 'application/json'], json_encode([
        'error' => [
            'message' => 'Invalid JSON payload received. Unknown name \"contents2\": Cannot find field.',
            'status' => 'INVALID_ARGUMENT',
            'code' => 400,
            'details' => [],
        ],
    ]));

    $this->client
        ->shouldReceive('sendRequest')
        ->once()
        ->andReturn($response);

    expect(fn () => $this->http->request($request))
        ->toThrow(function (ErrorException $e) {
            expect($e->getMessage())->toBe('Invalid JSON payload received. Unknown name \"contents2\": Cannot find field.')
                ->and($e->getErrorMessage())->toBe('Invalid JSON payload received. Unknown name \"contents2\": Cannot find field.')
                ->and($e->getErrorCode())->toBe(400)
                ->and($e->getErrorStatus())->toBe('INVALID_ARGUMENT');
        });
});

test('request client errors', function () {
    $request = new ListModelRequest;

    $this->client
        ->shouldReceive('sendRequest')
        ->once()
        ->andThrow(new ConnectException('Could not resolve host.', $request->toRequest(baseUrl: 'generativelanguage.googleapis.com')));

    expect(fn () => $this->http->request($request))->toThrow(function (TransporterException $e) {
        expect($e->getMessage())->toBe('Could not resolve host.')
            ->and($e->getCode())->toBe(0)
            ->and($e->getPrevious())->toBeInstanceOf(ConnectException::class);
    });
});

test('request serialization errors', function () {
    $request = new ListModelRequest;

    $response = new Response(200, ['Content-Type' => 'application/json; charset=utf-8'], 'err');

    $this->client
        ->shouldReceive('sendRequest')
        ->once()
        ->andReturn($response);

    $this->http->request($request);

})->throws(UnserializableResponse::class, 'Syntax error', 0);

test('request stream', function () {
    $request = new StreamGenerateContentRequest(
        model: ModelType::GEMINI_PRO->value,
        parts: ['Test']
    );

    $response = new Response(200, [], json_encode([
        'qdwq',
    ]));

    $this->client
        ->shouldReceive('sendAsyncRequest')
        ->once()
        ->withArgs(function (Psr7Request $request) {
            expect($request->getMethod())->toBe('POST')
                ->and($request->getUri())
                ->getHost()->toBe('generativelanguage.googleapis.com')
                ->getScheme()->toBe('https')
                ->getPath()->toBe('/v1/models/gemini-pro:streamGenerateContent');

            return true;
        })->andReturn($response);

    $response = $this->http->requestStream($request);

    expect($response->getBody()->eof())
        ->toBeFalse();
});

test('request stream server errors', function () {
    $request = new StreamGenerateContentRequest(
        model: ModelType::GEMINI_PRO->value,
        parts: ['Test']
    );

    $response = new Response(400, ['Content-Type' => 'application/json; charset=utf-8'], json_encode([
        'error' => [
            'code' => 400,
            'message' => 'API key not valid. Please pass a valid API key.',
            'status' => 'INVALID_ARGUMENT',
            'details' => [],
        ],
    ]));

    $this->client
        ->shouldReceive('sendAsyncRequest')
        ->once()
        ->andReturn($response);

    expect(fn () => $this->http->requestStream($request))
        ->toThrow(function (ErrorException $e) {
            expect($e->getMessage())->toBe('API key not valid. Please pass a valid API key.')
                ->and($e->getErrorMessage())->toBe('API key not valid. Please pass a valid API key.')
                ->and($e->getErrorCode())->toBe(400)
                ->and($e->getErrorStatus())->toBe('INVALID_ARGUMENT');
        });
});
