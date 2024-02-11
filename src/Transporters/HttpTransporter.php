<?php

declare(strict_types=1);

namespace Gemini\Transporters;

use Closure;
use Gemini\Contracts\TransporterContract;
use Gemini\Exceptions\ErrorException;
use Gemini\Exceptions\TransporterException;
use Gemini\Exceptions\UnserializableResponse;
use Gemini\Foundation\Request;
use Gemini\Transporters\DTOs\ResponseDTO;
use GuzzleHttp\Exception\ClientException;
use JsonException;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;

final class HttpTransporter implements TransporterContract
{
    /**
     * Creates a new Http Transporter instance.
     *
     * @param  array<string, string>  $headers
     * @param  array<string, string|int>  $queryParams
     */
    public function __construct(
        private readonly ClientInterface $client,
        private readonly string $baseUrl,
        private readonly array $headers,
        private readonly array $queryParams,
        private readonly Closure $streamHandler,
    ) {
        // ..
    }

    /**
     * {@inheritDoc}
     */
    public function request(Request $request): ResponseDTO
    {
        $response = $this->sendRequest(
            fn (): ResponseInterface => $this->client->sendRequest(request: $request->toRequest(baseUrl: $this->baseUrl, headers: $this->headers, queryParams: $this->queryParams))
        );

        $contents = $response->getBody()->getContents();

        $this->throwIfJsonError(response: $response, contents: $contents);

        try {
            /** @var array{error?: array{code: int, message: string, status: string } } $data */
            $data = json_decode(json: $contents, associative: true, flags: JSON_THROW_ON_ERROR);
        } catch (JsonException $jsonException) {
            throw new UnserializableResponse($jsonException);
        }

        return ResponseDTO::from(data: $data);
    }

    /**
     * @throws \Psr\Http\Client\ClientExceptionInterface
     * @throws \Exception
     */
    public function requestStream(Request $request): ResponseInterface
    {
        $response = $this->sendRequest(
            fn (): ResponseInterface => ($this->streamHandler)($request->toRequest(baseUrl: $this->baseUrl, headers: $this->headers, queryParams: $this->queryParams))
        );

        $this->throwIfJsonError(response: $response, contents: $response);

        return $response;
    }

    /**
     * @throws ErrorException
     * @throws UnserializableResponse
     */
    private function sendRequest(Closure $callable): ResponseInterface
    {
        try {
            return $callable();
        } catch (ClientExceptionInterface $clientException) {
            if ($clientException instanceof ClientException) {
                $this->throwIfJsonError($clientException->getResponse(), $clientException->getResponse()->getBody()->getContents());
            }

            throw new TransporterException($clientException);
        }
    }

    /**
     * @throws UnserializableResponse
     * @throws ErrorException
     */
    private function throwIfJsonError(ResponseInterface $response, string|ResponseInterface $contents): void
    {
        if ($response->getStatusCode() < 400) {
            return;
        }

        if ($contents instanceof ResponseInterface) {
            $contents = $contents->getBody()->getContents();
        }

        try {
            /** @var array{error?: array{code: int, message: string, status: string } } $response */
            $response = json_decode(json: $contents, associative: true, flags: JSON_THROW_ON_ERROR);

            if (isset($response['error'])) {
                throw new ErrorException($response['error']);
            }
        } catch (JsonException $jsonException) {
            throw new UnserializableResponse($jsonException);
        }
    }
}
