<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;

/**
 * Identifier for a part within a GroundingPassage.
 *
 * https://ai.google.dev/api/generate-content#GroundingPassageId
 */
final class GroundingPassageId implements Arrayable
{
    /**
     * @param  string  $passageId  Output only. ID of the passage matching the GenerateAnswerRequest's GroundingPassage.id.
     * @param  int  $partIndex  Output only. Index of the part within the GenerateAnswerRequest's GroundingPassage.content.
     */
    public function __construct(
        public readonly string $passageId,
        public readonly int $partIndex,
    ) {}

    /**
     * @param  array{ passageId: string, partIndex: int }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            passageId: $attributes['passageId'],
            partIndex: $attributes['partIndex'],
        );
    }

    public function toArray(): array
    {
        return [
            'passageId' => $this->passageId,
            'partIndex' => $this->partIndex,
        ];
    }
}
