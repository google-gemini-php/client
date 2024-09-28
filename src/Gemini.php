<?php

declare(strict_types=1);

use Gemini\Client;
use Gemini\Factory;

final class Gemini
{
    /**
     * Creates a new Gemini Client with the given API token
     */
    public static function client(string $apiKey): Client
    {
        return self::factory()
            ->withApiKey($apiKey)
            ->make();
    }

    /**
     * Creates a new factory instance to configure a custom Gemini Client
     */
    public static function factory(): Factory
    {
        return new Factory;
    }
}
