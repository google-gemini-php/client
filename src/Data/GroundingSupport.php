<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;

/**
 * Grounding support
 *
 * https://ai.google.dev/gemini-api/docs/grounding?configure-search&lang=rest#grounded-response
 */
final class GroundingSupport implements Arrayable
{
    /**
     * @param  array<int>  $confidenceScores  Confidence score of the support references. Ranges from 0 to 1. 1 is the most confident. This list must have the same size as the grounding_chunk_indices.
     * @param  array<int>  $groundingChunkIndices  A list of indices (into 'grounding_chunk') specifying the citations associated with the claim. For instance [1,3,4] means that grounding_chunk[1], grounding_chunk[3], grounding_chunk[4] are the retrieved content attributed to the claim.
     * @param  null|Segment  $segment  Segment of the content this support belongs to
     */
    public function __construct(
        public readonly ?array $confidenceScores = null,
        public readonly ?array $groundingChunkIndices = null,
        public readonly ?Segment $segment = null,
    ) {}

    /**
     * @param  array{ confidenceScores: null|array<int>, groundingChunkIndices: null|array<int>, segment: null|array{ endIndex: ?int, partIndex: ?int, startIndex: ?int, text: ?string } }  $attributes
     */
    public static function from(array $attributes): self
    {
        $segment = match (true) {
            isset($attributes['segment']) => Segment::from($attributes['segment']),
            default => null,
        };

        return new self(
            confidenceScores: $attributes['confidenceScores'] ?? null,
            groundingChunkIndices: $attributes['groundingChunkIndices'] ?? null,
            segment: $segment,
        );
    }

    public function toArray(): array
    {
        return [
            'confidenceScores' => $this->confidenceScores,
            'groundingChunkIndices' => $this->groundingChunkIndices,
            'segment' => $this->segment?->toArray(),
        ];
    }
}
