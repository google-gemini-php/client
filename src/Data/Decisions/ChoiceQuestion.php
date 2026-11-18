<?php

declare(strict_types=1);

namespace Gemini\Data\Decisions;

use Gemini\Contracts\Arrayable;
use Gemini\Enums\DecisionQuestionType;

final class ChoiceQuestion implements Arrayable
{
    /**
     * @param  array<string, string>  $criteria  Key-description pairs of available choices (2 to 255 options)
     */
    public function __construct(
        public readonly string $instructions,
        public readonly array $criteria,
    ) {}

    /**
     * @param  array<string, string>  $criteria
     */
    public static function make(string $instructions, array $criteria): self
    {
        return new self(instructions: $instructions, criteria: $criteria);
    }

    /**
     * @return array{type: string, instructions: string, criteria: array<string, string>}
     */
    public function toArray(): array
    {
        return [
            'type' => DecisionQuestionType::CHOICE->value,
            'instructions' => $this->instructions,
            'criteria' => $this->criteria,
        ];
    }
}
