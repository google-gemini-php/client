<?php

declare(strict_types=1);

namespace Gemini;

use Closure;
use Exception;
use Gemini\Transporters\HttpTransporter;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\RequestOptions;
use Http\Discovery\Psr18Client;
use Http\Discovery\Psr18ClientDiscovery;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

final class Factory
{
    /**
     * The HTTP client for the requests.
     */
    private ?ClientInterface $httpClient = null;

    /**
     * The API key for the requests.
     */
    private ?string $apiKey = null;

    /**
     * The base URI for the requests.
     */
    private string $baseUrl = 'https://generativelanguage.googleapis.com/v1/';

    /**
     * The HTTP headers for the requests.
     *
     * @var array<string, string>
     */
    private array $headers = [
        'Content-Type' => 'application/json',
    ];

    /**
     * The query parameters for the requests.
     *
     * @var array<string, string|int>
     */
    private array $queryParams = [];

    private ?Closure $streamHandler = null;

    /**
     * Sets the API key for the requests.
     */
    public function withApiKey(string $apiKey): self
    {
        $this->apiKey = trim($apiKey);

        return $this;
    }

    /**
     * Sets the base URL for the requests.
     *
     * If no URI is provided the factory will use the default Gemini API URI.
     */
    public function withBaseUrl(string $baseUrl): self
    {
        $this->baseUrl = $baseUrl;

        return $this;
    }

    /**
     * Adds a custom HTTP header to the requests.
     */
    public function withHttpHeader(string $name, string $value): self
    {
        $this->headers[$name] = $value;

        return $this;
    }

    /**
     * Adds a custom query parameter to the request url.
     */
    public function withQueryParam(string $name, string $value): self
    {
        $this->queryParams[$name] = $value;

        return $this;
    }

    /**
     * Sets the HTTP client for the requests.
     * If no client is provided the factory will try to find one using PSR-18 HTTP Client Discovery.
     */
    public function withHttpClient(ClientInterface $client): self
    {
        $this->httpClient = $client;

        return $this;
    }

    /**
     * Sets the stream handler for the requests. Not required when using Guzzle.
     */
    public function withStreamHandler(Closure $streamHandler): self
    {
        $this->streamHandler = $streamHandler;

        return $this;
    }

    public function make(): Client
    {
        $client = $this->httpClient ??= Psr18ClientDiscovery::find();

        if ($this->apiKey !== null) {
            $this->headers['x-goog-api-key'] = trim($this->apiKey);
        }

        $streamHandler = $this->makeStreamHandler($client);

        $transporter = new HttpTransporter(
            client: $client,
            baseUrl: $this->baseUrl,
            headers: $this->headers,
            queryParams: $this->queryParams,
            streamHandler: $streamHandler,
        );

        return new Client(transporter: $transporter);
    }

    /**
     * Creates a new stream handler for "stream" requests.
     */
    private function makeStreamHandler(ClientInterface $client): Closure
    {
        if (! is_null($this->streamHandler)) {
            return $this->streamHandler;
        }

        if ($client instanceof GuzzleClient) {
            return fn (RequestInterface $request): ResponseInterface => $client->send($request, [RequestOptions::STREAM => true]);
        }

        if ($client instanceof Psr18Client) {
            return fn (RequestInterface $request): ResponseInterface => $client->sendRequest($request);
        }

        return function (RequestInterface $req): never {
            throw new Exception('To use stream requests you must provide an stream handler closure via the Gemini factory.');
        };
    }
}
