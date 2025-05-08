<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;

/**
 * Grounding support.
 *
 * https://ai.google.dev/api/generate-content#GroundingSupport
 */
final class GroundingSupport implements Arrayable
{
    /**
     * @param  array<int>  $groundingChunkIndices  A list of indices (into 'grounding_chunk') specifying the citations associated with the claim. For instance [1,3,4] means that grounding_chunk[1], grounding_chunk[3], grounding_chunk[4] are the retrieved content attributed to the claim.
     * @param  array<float>  $confidenceScores  Confidence score of the support references. Ranges from 0 to 1. 1 is the most confident. This list must have the same size as the groundingChunkIndices.
     * @param  Segment  $segment  Segment of the content this support belongs to.
     */
    public function __construct(
        public readonly array $groundingChunkIndices,
        public readonly array $confidenceScores,
        public readonly Segment $segment,
    ) {}

    /**
     * @param  array{ groundingChunkIndices: array<int>, confidenceScores: array<float>, segment: array{ partIndex: int, startIndex: int, endIndex: int, text: string } }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            groundingChunkIndices: $attributes['groundingChunkIndices'],
            confidenceScores: $attributes['confidenceScores'],
            segment: Segment::from($attributes['segment']),
        );
    }

    public function toArray(): array
    {
        return [
            'groundingChunkIndices' => $this->groundingChunkIndices,
            'confidenceScores' => $this->confidenceScores,
            'segment' => $this->segment->toArray(),
        ];
    }
}
