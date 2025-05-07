<?php

declare(strict_types = 1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;

/**
 * Metadata related to retrieval in the grounding flow
 *
 * https://ai.google.dev/gemini-api/docs/grounding?configure-search&lang=rest#grounded-response
 */
final class RetrievalMetadata implements Arrayable
{
    /**
     * @param string|null $googleSearchDynamicRetrievalScore Score indicating how likely information from Google Search could help answer the prompt. The score is in the range [0, 1], where 0 is the least likely and 1 is the most likely. This score is only populated when Google Search grounding and dynamic retrieval is enabled. It will be compared to the threshold to determine whether to trigger Google Search
     */
    public function __construct(
        public readonly ?string $googleSearchDynamicRetrievalScore = null,
    ) {
    }

    /**
     * @param array{ googleSearchDynamicRetrievalScore: string } $attributes
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
