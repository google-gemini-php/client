<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;

/**
 * This type has no fields.
 * GoogleSearch tool type. Tool to support Google Search in Model. Powered by Google.
 *
 * https://ai.google.dev/api/caching#GoogleSearch
 */
final class GoogleSearch implements Arrayable
{
    public function __construct(
    ) {}

    public static function from(): self
    {
        return new self;
    }

    public function toArray(): array
    {
        return [];
    }
}
