<?php

declare(strict_types=1);

namespace Gemini\Data;

use stdClass;

/**
 * This type has no fields.
 * GoogleSearch tool type. Tool to support Google Search in Model. Powered by Google.
 *
 * https://ai.google.dev/api/caching#GoogleSearch
 */
final class GoogleSearch
{
    public function __construct(
    ) {}

    public static function from(): self
    {
        return new self;
    }

    public function toArray(): stdClass
    {
        return new stdClass;
    }
}
