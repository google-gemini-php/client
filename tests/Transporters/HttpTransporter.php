<?php

use Gemini\Exceptions\ErrorException;
use Gemini\Exceptions\TransporterException;
use Gemini\Exceptions\UnserializableResponse;
use Gemini\Requests\GenerativeModel\GenerateContentRequest;
use Gemini\Requests\GenerativeModel\StreamGenerateContentRequest;
use Gemini\Requests\Model\ListModelRequest;
use Gemini\Responses\Models\ListModelResponse;
use Gemini\Transporters\HttpTransporter;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Psr7\Request as Psr7Request;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

beforeEach(function () {
    $this->client = Mockery::mock(ClientInterface::class);

    $this->http = new HttpTransporter(
        client: $this->client,
        baseUrl: 'https://generativelanguage.googleapis.com/v1beta/',
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
                ->getPath()->toBe('/v1beta/models');

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
        model: 'models/gemini-1.5-pro',
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
        model: 'models/gemini-1.5-pro',
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
                ->getPath()->toBe('/v1beta/models/gemini-1.5-pro:streamGenerateContent');

            return true;
        })->andReturn($response);

    $response = $this->http->requestStream($request);

    expect($response->getBody()->eof())
        ->toBeFalse();
});

test('request stream server errors', function () {
    $request = new StreamGenerateContentRequest(
        model: 'models/gemini-1.5-pro',
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

test('request server errors wrapped in a list', function () {
    $request = new ListModelRequest;

    $response = new Response(429, ['Content-Type' => 'application/json; charset=utf-8'], json_encode([
        [
            'error' => [
                'code' => 429,
                'message' => 'Your prepayment credits are depleted.',
                'status' => 'RESOURCE_EXHAUSTED',
            ],
        ],
    ]));

    $this->client
        ->shouldReceive('sendRequest')
        ->once()
        ->andReturn($response);

    expect(fn () => $this->http->request($request))
        ->toThrow(function (ErrorException $e) {
            expect($e->getMessage())->toBe('Your prepayment credits are depleted.')
                ->and($e->getErrorCode())->toBe(429)
                ->and($e->getErrorStatus())->toBe('RESOURCE_EXHAUSTED');
        });
});

test('request client exception errors wrapped in a list', function () {
    $request = new ListModelRequest;

    $response = new Response(429, ['Content-Type' => 'application/json; charset=utf-8'], json_encode([
        [
            'error' => [
                'code' => 429,
                'message' => 'Your prepayment credits are depleted.',
                'status' => 'RESOURCE_EXHAUSTED',
            ],
        ],
    ]));

    $this->client
        ->shouldReceive('sendRequest')
        ->once()
        ->andThrow(new ClientException('Too Many Requests', $request->toRequest(baseUrl: 'generativelanguage.googleapis.com'), $response));

    expect(fn () => $this->http->request($request))
        ->toThrow(function (ErrorException $e) {
            expect($e->getMessage())->toBe('Your prepayment credits are depleted.')
                ->and($e->getErrorCode())->toBe(429)
                ->and($e->getErrorStatus())->toBe('RESOURCE_EXHAUSTED');
        });
});

test('request client exception keeps the response body readable', function () {
    $request = new ListModelRequest;

    $response = new Response(429, ['Content-Type' => 'application/json; charset=utf-8'], json_encode([
        'unexpected' => 'shape',
    ]));

    $this->client
        ->shouldReceive('sendRequest')
        ->once()
        ->andThrow(new ClientException('Too Many Requests', $request->toRequest(baseUrl: 'generativelanguage.googleapis.com'), $response));

    expect(fn () => $this->http->request($request))
        ->toThrow(function (TransporterException $e) {
            expect($e->getPrevious())->toBeInstanceOf(ClientException::class)
                ->and($e->getPrevious()->getResponse()->getBody()->getContents())->toBe('{"unexpected":"shape"}');
        });
});

test('request stream client exception errors wrapped in a list', function () {
    $request = new StreamGenerateContentRequest(
        model: 'models/gemini-1.5-pro',
        parts: ['Test']
    );

    $response = new Response(429, ['Content-Type' => 'application/json; charset=utf-8'], json_encode([
        [
            'error' => [
                'code' => 429,
                'message' => 'Your prepayment credits are depleted.',
                'status' => 'RESOURCE_EXHAUSTED',
            ],
        ],
    ]));

    $this->client
        ->shouldReceive('sendAsyncRequest')
        ->once()
        ->andThrow(new ClientException('Too Many Requests', $request->toRequest(baseUrl: 'generativelanguage.googleapis.com'), $response));

    expect(fn () => $this->http->requestStream($request))
        ->toThrow(function (ErrorException $e) {
            expect($e->getMessage())->toBe('Your prepayment credits are depleted.')
                ->and($e->getErrorCode())->toBe(429)
                ->and($e->getErrorStatus())->toBe('RESOURCE_EXHAUSTED');
        });
});

test('request server errors with a 5xx status', function () {
    $request = new ListModelRequest;

    $response = new Response(503, ['Content-Type' => 'application/json; charset=utf-8'], json_encode([
        'error' => [
            'code' => 503,
            'message' => 'The model is overloaded. Please try again later.',
            'status' => 'UNAVAILABLE',
        ],
    ]));

    $this->client
        ->shouldReceive('sendRequest')
        ->once()
        ->andReturn($response);

    expect(fn () => $this->http->request($request))
        ->toThrow(function (ErrorException $e) {
            expect($e->getMessage())->toBe('The model is overloaded. Please try again later.')
                ->and($e->getErrorCode())->toBe(503)
                ->and($e->getErrorStatus())->toBe('UNAVAILABLE');
        });
});

test('request stream server exception errors', function () {
    $request = new StreamGenerateContentRequest(
        model: 'models/gemini-1.5-pro',
        parts: ['Test']
    );

    $response = new Response(503, ['Content-Type' => 'application/json; charset=utf-8'], json_encode([
        [
            'error' => [
                'code' => 503,
                'message' => 'The model is overloaded. Please try again later.',
                'status' => 'UNAVAILABLE',
            ],
        ],
    ]));

    $this->client
        ->shouldReceive('sendAsyncRequest')
        ->once()
        ->andThrow(new ServerException('Service Unavailable', $request->toRequest(baseUrl: 'generativelanguage.googleapis.com'), $response));

    expect(fn () => $this->http->requestStream($request))
        ->toThrow(function (ErrorException $e) {
            expect($e->getMessage())->toBe('The model is overloaded. Please try again later.')
                ->and($e->getErrorCode())->toBe(503)
                ->and($e->getErrorStatus())->toBe('UNAVAILABLE');
        });
});
