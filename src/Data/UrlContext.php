<?php

declare(strict_types=1);

namespace Gemini\Data;

use stdClass;

/**
 * This type has no fields.
 * Tool to support URL context retrieval.
 *
 * https://ai.google.dev/api/caching#UrlContext
 */
final class UrlContext
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
