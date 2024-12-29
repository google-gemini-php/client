<?php

declare(strict_types=1);

namespace Gemini\Concerns;

use Gemini\Data\Blob;
use Gemini\Data\Content;
use Gemini\Data\UploadedFile;
use InvalidArgumentException;

trait HasContents
{
    /**
     * @param  string|Blob|array<string|Blob|UploadedFile>|Content|UploadedFile  ...$parts
     * @return array<Content>
     *
     * @throws InvalidArgumentException
     */
    public function partsToContents(string|Blob|array|Content|UploadedFile ...$parts): array
    {
        return array_map(
            callback: static fn ($part) => Content::parse($part),
            array: $parts,
        );
    }
}
