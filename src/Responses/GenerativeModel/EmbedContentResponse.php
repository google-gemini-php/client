<?php

declare(strict_types=1);

namespace Gemini\Responses\GenerativeModel;

use Gemini\Contracts\ResponseContract;
use Gemini\Data\ContentEmbedding;
use Gemini\Testing\Responses\Concerns\Fakeable;

/**
 * https://ai.google.dev/api/rest/v1/models/embedContent#response-body
 */
final class EmbedContentResponse implements ResponseContract
{
    use Fakeable;

    private function __construct(
        public readonly ContentEmbedding $embedding,
    ) {}

    /**
     * @param  array{ embedding: array{ values: array<float> } }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            embedding: ContentEmbedding::from($attributes['embedding']),
        );
    }

    public function toArray(): array
    {
        return [
            'embedding' => $this->embedding->toArray(),
        ];
    }
}
