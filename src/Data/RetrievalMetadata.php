<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;

/**
 * Metadata related to retrieval in the grounding flow.
 *
 * https://ai.google.dev/api/generate-content#RetrievalMetadata
 */
final class RetrievalMetadata implements Arrayable
{
    /**
     * @param  float|null  $googleSearchDynamicRetrievalScore  Optional. Score indicating how likely information from google search could help answer the prompt. The score is in the range [0, 1], where 0 is the least likely and 1 is the most likely. This score is only populated when google search grounding and dynamic retrieval is enabled. It will be compared to the threshold to determine whether to trigger google search.
     */
    public function __construct(
        public readonly ?float $googleSearchDynamicRetrievalScore,
    ) {}

    /**
     * @param  array{ googleSearchDynamicRetrievalScore?: float|null }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            googleSearchDynamicRetrievalScore: $attributes['googleSearchDynamicRetrievalScore'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'googleSearchDynamicRetrievalScore' => $this->googleSearchDynamicRetrievalScore,
        ];
    }
}
