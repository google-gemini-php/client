<?php

declare(strict_types=1);

namespace Gemini\Responses\FileSearchStores\Documents;

use Gemini\Contracts\ResponseContract;
use Gemini\Enums\DocumentState;
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
        public readonly ?string $mimeType = null,
        public readonly int $sizeBytes = 0,
        public readonly ?DocumentState $state = null,
    ) {}

    /**
     * @param  array{ name: string, displayName?: string, customMetadata?: array<array{key: string, stringValue: string}>, updateTime?: string, createTime?: string, mimeType?: string, sizeBytes?: string, state?: string }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            name: $attributes['name'],
            displayName: $attributes['displayName'] ?? null,
            customMetadata: $attributes['customMetadata'] ?? [],
            updateTime: $attributes['updateTime'] ?? null,
            createTime: $attributes['createTime'] ?? null,
            mimeType: $attributes['mimeType'] ?? null,
            sizeBytes: (int) ($attributes['sizeBytes'] ?? 0),
            state: isset($attributes['state']) ? DocumentState::tryFrom($attributes['state']) : null,
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
            'mimeType' => $this->mimeType,
            'sizeBytes' => $this->sizeBytes,
            'state' => $this->state?->value,
        ];
    }
}
