<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;

/**
 * FileSearch tool type. Tool to support File Search in Model.
 */
final class FileSearch implements Arrayable
{
    /**
     * @param  array<string>  $fileSearchStoreNames  Required. The file search store names.
     * @param  string|null  $metadataFilter  Optional. A filter for metadata.
     */
    public function __construct(
        public readonly array $fileSearchStoreNames,
        public readonly ?string $metadataFilter = null,
    ) {}

    /**
     * @param  array{ fileSearchStoreNames: array<string>, metadataFilter?: string }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            fileSearchStoreNames: $attributes['fileSearchStoreNames'],
            metadataFilter: $attributes['metadataFilter'] ?? null,
        );
    }

    public function toArray(): array
    {
        $data = [
            'fileSearchStoreNames' => $this->fileSearchStoreNames,
        ];

        if ($this->metadataFilter !== null) {
            $data['metadataFilter'] = $this->metadataFilter;
        }

        return $data;
    }
}
