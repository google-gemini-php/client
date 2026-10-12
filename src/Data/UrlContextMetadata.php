<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;

/**
 * Metadata related to url context retrieval tool.
 *
 * https://ai.google.dev/api/generate-content#UrlContextMetadata
 */
final class UrlContextMetadata implements Arrayable
{
    /**
     * @param  array<UrlMetadata>  $urlMetadata  List of url context.
     */
    public function __construct(
        public readonly array $urlMetadata = [],
    ) {}

    /**
     * @param  array{ urlMetadata?: array<array{ retrievedUrl?: string, urlRetrievalStatus?: string }> }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            urlMetadata: array_map(
                static fn (array $urlMetadata): UrlMetadata => UrlMetadata::from($urlMetadata),
                $attributes['urlMetadata'] ?? [],
            ),
        );
    }

    public function toArray(): array
    {
        return [
            'urlMetadata' => array_map(
                static fn (UrlMetadata $urlMetadata): array => $urlMetadata->toArray(),
                $this->urlMetadata,
            ),
        ];
    }
}
