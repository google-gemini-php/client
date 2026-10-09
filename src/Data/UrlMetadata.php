<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;
use Gemini\Enums\UrlRetrievalStatus;

/**
 * Context of a single url retrieval.
 *
 * https://ai.google.dev/api/generate-content#UrlMetadata
 */
final class UrlMetadata implements Arrayable
{
    /**
     * @param  string|null  $retrievedUrl  Retrieved url by the tool.
     * @param  UrlRetrievalStatus|null  $urlRetrievalStatus  Status of the url retrieval.
     */
    public function __construct(
        public readonly ?string $retrievedUrl = null,
        public readonly ?UrlRetrievalStatus $urlRetrievalStatus = null,
    ) {}

    /**
     * @param  array{ retrievedUrl?: string, urlRetrievalStatus?: string }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            retrievedUrl: $attributes['retrievedUrl'] ?? null,
            urlRetrievalStatus: isset($attributes['urlRetrievalStatus']) ? UrlRetrievalStatus::tryFrom($attributes['urlRetrievalStatus']) : null,
        );
    }

    public function toArray(): array
    {
        return [
            'retrievedUrl' => $this->retrievedUrl,
            'urlRetrievalStatus' => $this->urlRetrievalStatus?->value,
        ];
    }
}
