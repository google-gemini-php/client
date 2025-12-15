<?php

declare(strict_types=1);

namespace Gemini\Responses\FileSearchStores\Documents;

use Gemini\Contracts\ResponseContract;
use Gemini\Testing\Responses\Concerns\Fakeable;

/**
 * @link https://ai.google.dev/api/file-search/documents#Document
 */
class DocumentResponse implements ResponseContract
{
    use Fakeable;

    /**
     * @param  array<array{key: string, stringValue: string}>  $customMetadata
     */
    public function __construct(
        public readonly string $name,
        public readonly ?string $displayName = null,
        public readonly array $customMetadata = [],
        public readonly ?string $updateTime = null,
        public readonly ?string $createTime = null,
    ) {}

    /**
     * @param  array{ name: string, displayName?: string, customMetadata?: array<array{key: string, stringValue: string}>, updateTime?: string, createTime?: string }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            name: $attributes['name'],
            displayName: $attributes['displayName'] ?? null,
            customMetadata: $attributes['customMetadata'] ?? [],
            updateTime: $attributes['updateTime'] ?? null,
            createTime: $attributes['createTime'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'displayName' => $this->displayName,
            'customMetadata' => $this->customMetadata,
            'updateTime' => $this->updateTime,
            'createTime' => $this->createTime,
        ];
    }
}
