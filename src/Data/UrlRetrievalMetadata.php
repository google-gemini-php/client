<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;

/**
 * Metadata related to url context retrieval tool.
 *
 * https://ai.google.dev/api/generate-content#UrlRetrievalMetadata
 */
final class UrlRetrievalMetadata implements Arrayable
{
    /**
     * @param  array<UrlRetrievalContext>  $urlRetrievalContexts  List of url retrieval contexts.
     */
    public function __construct(
        public readonly array $urlRetrievalContexts,
    ) {}

    /**
     * @param  array{ urlRetrievalContexts: array<array{ retrievedUrl: string }> }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            urlRetrievalContexts: array_map(
                static fn (array $urlRetrievalContext): UrlRetrievalContext => UrlRetrievalContext::from($urlRetrievalContext),
                $attributes['urlRetrievalContexts'],
            ),
        );
    }

    public function toArray(): array
    {
        return [
            'urlRetrievalContexts' => array_map(
                static fn (UrlRetrievalContext $urlRetrievalContext): array => $urlRetrievalContext->toArray(),
                $this->urlRetrievalContexts,
            ),
        ];
    }
}
