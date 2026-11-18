<?php

declare(strict_types=1);

namespace Gemini\Data\Decisions;

use Gemini\Contracts\Arrayable;
use Gemini\Enums\DecisionQuestionType;

final class ScoreQuestion implements Arrayable
{
    /**
     * @param  array<string|int, string>  $legend  Ordinal level definitions (2 to 255 levels)
     */
    public function __construct(
        public readonly string $instructions,
        public readonly array $legend,
    ) {}

    /**
     * @param  array<string|int, string>  $legend
     */
    public static function make(string $instructions, array $legend): self
    {
        return new self(instructions: $instructions, legend: $legend);
    }

    /**
     * @return array{type: string, instructions: string, legend: array<string|int, string>}
     */
    public function toArray(): array
    {
        return [
            'type' => DecisionQuestionType::SCORE->value,
            'instructions' => $this->instructions,
            'legend' => $this->legend,
        ];
    }
}
