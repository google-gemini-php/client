<?php

declare(strict_types=1);

namespace Gemini\Responses\FileSearchStores\Documents;

use Gemini\Contracts\ResponseContract;
use Gemini\Testing\Responses\Concerns\Fakeable;

/**
 * @link https://ai.google.dev/api/file-search/documents#method:-fileSearchStores.documents.list
 */
class ListResponse implements ResponseContract
{
    use Fakeable;

    /**
     * @param  array<DocumentResponse>  $documents
     */
    public function __construct(
        public readonly array $documents,
        public readonly ?string $nextPageToken = null,
    ) {}

    /**
     * @param  array{ documents: ?array<array{ name: string, displayName?: string, customMetadata?: array<array{key: string, stringValue: string}>, updateTime?: string, createTime?: string }>, nextPageToken: ?string }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            documents: array_map(
                fn (array $document): DocumentResponse => DocumentResponse::from($document),
                $attributes['documents'] ?? []
            ),
            nextPageToken: $attributes['nextPageToken'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'documents' => array_map(
                fn (DocumentResponse $document): array => $document->toArray(),
                $this->documents
            ),
            'nextPageToken' => $this->nextPageToken,
        ];
    }
}
