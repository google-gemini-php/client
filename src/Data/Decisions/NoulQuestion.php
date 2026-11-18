<?php

declare(strict_types=1);

namespace Gemini\Data\Decisions;

use Gemini\Contracts\Arrayable;
use Gemini\Enums\DecisionQuestionType;

final class NoulQuestion implements Arrayable
{
    /**
     * @param  array{true_description?: string, false_description?: string}|null  $criteria
     */
    public function __construct(
        public readonly string $instructions,
        public readonly ?array $criteria = null,
    ) {}

    /**
     * @param  array{true_description?: string, false_description?: string}|null  $criteria
     */
    public static function make(string $instructions, ?array $criteria = null): self
    {
        return new self(instructions: $instructions, criteria: $criteria);
    }

    /**
     * @return array{type: string, instructions: string, criteria?: array{true_description?: string, false_description?: string}}
     */
    public function toArray(): array
    {
        return array_filter([
            'type' => DecisionQuestionType::NOUL->value,
            'instructions' => $this->instructions,
            'criteria' => $this->criteria,
        ], static fn ($v): bool => $v !== null);
    }
}
