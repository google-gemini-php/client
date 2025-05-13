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
     * @param  array<int>|null  $groundingChunkIndices  A list of indices (into 'grounding_chunk') specifying the citations associated with the claim. For instance [1,3,4] means that grounding_chunk[1], grounding_chunk[3], grounding_chunk[4] are the retrieved content attributed to the claim.
     * @param  array<float>|null  $confidenceScores  Confidence score of the support references. Ranges from 0 to 1. 1 is the most confident. This list must have the same size as the groundingChunkIndices.
     * @param  Segment|null  $segment  Segment of the content this support belongs to.
     */
    public function __construct(
        public readonly ?array $groundingChunkIndices = null,
        public readonly ?array $confidenceScores = null,
        public readonly ?Segment $segment = null,
    ) {}

    /**
     * @param  array{ groundingChunkIndices: array<int>|null, confidenceScores: array<float>|null, segment: ?array{ partIndex: ?int, startIndex: ?int, endIndex: ?int, text: ?string } }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            groundingChunkIndices: $attributes['groundingChunkIndices'] ?? null,
            confidenceScores: $attributes['confidenceScores'] ?? null,
            segment: isset($attributes['segment']) ? Segment::from($attributes['segment']) : null,
        );
    }

    public function toArray(): array
    {
        return [
            'groundingChunkIndices' => $this->groundingChunkIndices,
            'confidenceScores' => $this->confidenceScores,
            'segment' => $this->segment?->toArray(),
        ];
    }
}
