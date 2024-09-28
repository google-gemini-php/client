<?php

declare(strict_types=1);

namespace Gemini\Responses\GenerativeModel;

use Gemini\Contracts\ResponseContract;
use Gemini\Data\ContentEmbedding;
use Gemini\Testing\Responses\Concerns\Fakeable;

/**
 * https://ai.google.dev/api/rest/v1/models/embedContent#response-body
 */
final class BatchEmbedContentsResponse implements ResponseContract
{
    use Fakeable;

    /**
     * @param  array<ContentEmbedding>  $embeddings
     */
    private function __construct(
        public readonly array $embeddings,
    ) {}

    /**
     * @param  array{ embeddings: array{ array{ values: array<float> } } }  $attributes
     */
    public static function from(array $attributes): self
    {
        $embeddings = array_map(
            static fn (array $embedding): ContentEmbedding => ContentEmbedding::from($embedding),
            $attributes['embeddings'],
        );

        return new self(
            embeddings: $embeddings
        );
    }

    public function toArray(): array
    {
        return [
            'embeddings' => array_map(
                static fn (ContentEmbedding $embedding): array => $embedding->toArray(),
                $this->embeddings
            ),
        ];
    }
}
