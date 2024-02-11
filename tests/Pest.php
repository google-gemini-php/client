<?php

use Gemini\Client;
use Gemini\Contracts\ResponseContract;
use Gemini\Contracts\TransporterContract;
use Gemini\Enums\Method;
use Gemini\Foundation\Request;
use Gemini\Transporters\DTOs\ResponseDTO;
use Psr\Http\Message\ResponseInterface;

function mockClient(Method $method, string $endpoint, ResponseDTO|ResponseContract|ResponseInterface|string $response, array $params = [], int $times = 1, $methodName = 'request', bool $validateParams = false): Client
{
    $transporter = Mockery::mock(TransporterContract::class);

    $response = match (true) {
        $response instanceof ResponseContract => new ResponseDTO(data: $response->toArray()),
        default => $response
    };

    $transporter
        ->shouldReceive($methodName)
        ->times($times)
        ->withArgs(function (Request $request) use ($validateParams, $method, $endpoint, $params) {
            $psrRequest = $request->toRequest(baseUrl: 'https://generativelanguage.googleapis.com/v1/');

            if ($validateParams) {
                if (in_array($method, [Method::GET, Method::DELETE])) {
                    if ($psrRequest->getUri()->getQuery() !== http_build_query($params)) {
                        return false;
                    }
                } else {
                    if ($psrRequest->getBody()->getContents() !== json_encode($params)) {
                        return false;
                    }
                }
            }

            return $psrRequest->getMethod() === $method->value
                && $psrRequest->getUri()->getPath() === "/v1/$endpoint";
        })->andReturn($response);

    return new Client($transporter);
}

function mockStreamClient(Method $method, string $endpoint, ResponseDTO|ResponseContract|ResponseInterface|string $response, array $params = [], bool $validateParams = false): Client
{
    return mockClient(method: $method, endpoint: $endpoint, response: $response, params: $params, methodName: 'requestStream', validateParams: $validateParams);
}
