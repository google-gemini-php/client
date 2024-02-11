<?php

declare(strict_types=1);

namespace Gemini\Testing\Responses\Concerns;

use Gemini\Responses\StreamResponse;
use Http\Discovery\Psr17FactoryDiscovery;

trait FakeableForStreamedResponse
{
    /**
     * @return false|resource
     */
    public static function fakeResource()
    {
        $filename = str_replace(['Gemini\Responses', '\\'], [__DIR__.'/../Fixtures/', '/'], static::class).'Fixture.txt';

        return fopen($filename, 'r');
    }

    /**
     * @param  resource  $resource
     */
    public static function fakeStream($resource = null): StreamResponse
    {
        $resource ??= static::fakeResource();

        $stream = Psr17FactoryDiscovery::findStreamFactory()
            ->createStreamFromResource($resource);

        $response = Psr17FactoryDiscovery::findResponseFactory()
            ->createResponse()
            ->withBody($stream);

        return new StreamResponse(static::class, $response);
    }
}
