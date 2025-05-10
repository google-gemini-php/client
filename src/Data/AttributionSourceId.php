<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;

/**
 * Identifier for the source contributing to this attribution.
 *
 * https://ai.google.dev/api/generate-content#AttributionSourceId
 */
final class AttributionSourceId implements Arrayable
{
    /**
     * @param  GroundingPassageId|null  $groundingPassage  Identifier for an inline passage.
     * @param  SemanticRetrieverChunk|null  $semanticRetrieverChunk  Identifier for a Chunk fetched via Semantic Retriever.
     */
    public function __construct(
        public readonly ?GroundingPassageId $groundingPassage = null,
        public readonly ?SemanticRetrieverChunk $semanticRetrieverChunk = null,
    ) {}

    /**
     * @param  array{ groundingPassage?: array{ passageId: string, partIndex: int }, semanticRetrieverChunk?: array{ source: string, chunk: string } }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            groundingPassage: isset($attributes['groundingPassage']) ? GroundingPassageId::from($attributes['groundingPassage']) : null,
            semanticRetrieverChunk: isset($attributes['semanticRetrieverChunk']) ? SemanticRetrieverChunk::from($attributes['semanticRetrieverChunk']) : null,
        );
    }

    public function toArray(): array
    {
        $data = [];

        if ($this->groundingPassage !== null) {
            $data['groundingPassage'] = $this->groundingPassage;
        }

        if ($this->semanticRetrieverChunk !== null) {
            $data['semanticRetrieverChunk'] = $this->semanticRetrieverChunk;
        }

        return $data;
    }
}
