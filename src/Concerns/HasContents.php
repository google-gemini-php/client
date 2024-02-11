<?php

declare(strict_types=1);

namespace Gemini\Concerns;

use Gemini\Data\Blob;
use Gemini\Data\Content;
use InvalidArgumentException;

trait HasContents
{
    /**
     * @param  string|Blob|array<string|Blob>|Content  ...$parts
     * @return array<Content>
     *
     * @throws InvalidArgumentException
     */
    public function partsToContents(string|Blob|array|Content ...$parts): array
    {
        return array_map(
            callback: static fn ($part) => Content::parse($part),
            array: $parts,
        );
    }
}
