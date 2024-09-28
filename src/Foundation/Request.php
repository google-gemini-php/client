<?php

declare(strict_types=1);

namespace Gemini\Foundation;

use Gemini\Enums\Method;
use Http\Discovery\Psr17Factory;
use LogicException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;

abstract class Request
{
    /**
     * Define the HTTP method.
     */
    protected Method $method;

    /**
     * Get the method of the request.
     *
     * @throws LogicException
     */
    public function getMethod(): Method
    {
        if (! isset($this->method)) {
            throw new LogicException('Your request is missing a HTTP method. You must add a method property like [protected Method $method = Method::GET]');
        }

        return $this->method;
    }

    /**
     * Default Query Parameters
     *
     * @return array<string, mixed>
     */
    public function defaultQuery(): array
    {
        return [];
    }

    /**
     * Define the endpoint for the request.
     */
    abstract public function resolveEndpoint(): string;

    /**
     * @param  array<string, array<string>|string>  $headers
     * @param  array<string, mixed>  $queryParams
     *
     * @throws \JsonException
     */
    public function toRequest(string $baseUrl, array $headers = [], array $queryParams = []): RequestInterface
    {
        $psr17Factory = new Psr17Factory;

        $uri = $baseUrl.$this->resolveEndpoint();

        $query = $this->defaultQuery();

        if ($this->method === Method::GET) {
            $query = [...$query, $queryParams];
        }

        if ($query !== []) {
            $uri .= '?'.http_build_query($query);
        }

        $body = null;

        if ($this->method === Method::POST) {
            $parameters = match (true) {
                method_exists($this, 'body') => $this->body(),
                default => [],
            };

            $body = $psr17Factory->createStream(json_encode($parameters, JSON_THROW_ON_ERROR));
        }

        $request = $psr17Factory->createRequest($this->method->value, $uri);

        if ($body instanceof StreamInterface) {
            $request = $request->withBody($body);
        }

        foreach ($headers as $name => $value) {
            $request = $request->withHeader($name, $value);
        }

        return $request;
    }
}
