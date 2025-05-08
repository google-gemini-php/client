<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;

/**
 * Context of the single url retrieval.
 *
 * https://ai.google.dev/api/generate-content#UrlRetrievalContext
 */
final class UrlRetrievalContext implements Arrayable
{
    /**
     * @param  string  $retrievedUrl  Retrieved url by the tool.
     */
    public function __construct(
        public readonly string $retrievedUrl,
    ) {}

    /**
     * @param  array{ retrievedUrl: string }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            retrievedUrl: $attributes['retrievedUrl'],
        );
    }

    public function toArray(): array
    {
        return [
            'retrievedUrl' => $this->retrievedUrl,
        ];
    }
}
