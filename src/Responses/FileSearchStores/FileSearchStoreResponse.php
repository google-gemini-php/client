<?php

declare(strict_types=1);

namespace Gemini\Responses\FileSearchStores;

use Gemini\Contracts\ResponseContract;
use Gemini\Testing\Responses\Concerns\Fakeable;

/**
 * @link https://ai.google.dev/api/file-search/file-search-stores#FileSearchStore
 */
class FileSearchStoreResponse implements ResponseContract
{
    use Fakeable;

    public function __construct(
        public readonly string $name,
        public readonly ?string $displayName = null,
    ) {}

    /**
     * @param  array{ name: string, displayName?: string }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            name: $attributes['name'],
            displayName: $attributes['displayName'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'displayName' => $this->displayName,
        ];
    }
}
