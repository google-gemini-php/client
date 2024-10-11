<?php

use Gemini\Client;
use GuzzleHttp\Client as GuzzleClient;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

it('may create client', function () {
    $gemini = Gemini::client(apiKey: 'foo');

    expect($gemini)->toBeInstanceOf(Client::class);
});

it('may create a client via factory', function () {
    $gemini = Gemini::factory()
        ->withApiKey(apiKey: 'foo')
        ->make();

    expect($gemini)->toBeInstanceOf(Client::class);
});

it('sets a custom client via factory', function () {
    $gemini = Gemini::factory()
        ->withHttpClient(client: new GuzzleClient)
        ->make();

    expect($gemini)->toBeInstanceOf(Client::class);
});

it('sets a custom base url via factory', function () {
    $gemini = Gemini::factory()
        ->withBaseUrl(baseUrl: 'https://gemini.example.com')
        ->make();

    expect($gemini)->toBeInstanceOf(Client::class);
});

it('sets the beta API URL via factory', function () {
    $gemini = Gemini::factory()
        ->useBetaApi()
        ->make();

    expect($gemini)->toBeInstanceOf(Client::class);

    // You might need to use reflection to check the actual base URL
    $reflection = new ReflectionClass($gemini);
    $transporter = $reflection->getProperty('transporter');
    $transporter->setAccessible(true);
    $transporterInstance = $transporter->getValue($gemini);

    $baseUrlProperty = (new ReflectionClass($transporterInstance))->getProperty('baseUrl');
    $baseUrlProperty->setAccessible(true);
    $baseUrl = $baseUrlProperty->getValue($transporterInstance);

    expect($baseUrl)->toBe('https://generativelanguage.googleapis.com/v1beta/');
});

it('sets a custom header via factory', function () {
    $gemini = Gemini::factory()
        ->withHttpHeader(name: 'Custom-Header', value: 'foo')
        ->make();

    expect($gemini)->toBeInstanceOf(Client::class);
});

it('sets a custom query parameter via factory', function () {
    $gemini = Gemini::factory()
        ->withQueryParam(name: 'custom-param', value: 'foo')
        ->make();

    expect($gemini)->toBeInstanceOf(Client::class);
});

it('sets a custom stream handler via factory', function () {
    $gemini = Gemini::factory()
        ->withHttpClient($client = new GuzzleClient)
        ->withStreamHandler(fn (RequestInterface $request): ResponseInterface => $client->send($request, ['stream' => true]))
        ->make();

    expect($gemini)->toBeInstanceOf(Client::class);
});
