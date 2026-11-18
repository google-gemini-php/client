<?php

declare(strict_types=1);

namespace Gemini\Data\Decisions;

use Gemini\Contracts\Arrayable;
use Gemini\Enums\DecisionQuestionType;

final class DecisionAnswer implements Arrayable
{
    /**
     * @param  array<string, float>|null  $probabilities
     * @param  array<string|int, string>|null  $legend
     */
    public function __construct(
        public readonly DecisionQuestionType $type,
        public readonly float $confidence,
        public readonly ?float $noul = null,
        public readonly ?string $choice = null,
        public readonly ?float $score = null,
        public readonly ?array $probabilities = null,
        public readonly ?array $legend = null,
    ) {}

    /**
     * @param  array{type: string, confidence: float|int, noul?: float|int|null, choice?: string|null, score?: float|int|null, probabilities?: array<string, float|int>|null, legend?: array<string|int, string>|null}  $attributes
     */
    public static function from(array $attributes): self
    {
        /** @var array<string, float>|null $probabilities */
        $probabilities = isset($attributes['probabilities'])
            ? array_map(static fn ($p): float => (float) $p, $attributes['probabilities'])
            : null;

        return new self(
            type: DecisionQuestionType::from($attributes['type']),
            confidence: (float) $attributes['confidence'],
            noul: isset($attributes['noul']) ? (float) $attributes['noul'] : null,
            choice: $attributes['choice'] ?? null,
            score: isset($attributes['score']) ? (float) $attributes['score'] : null,
            probabilities: $probabilities,
            legend: $attributes['legend'] ?? null,
        );
    }

    public function isYes(float $threshold = 0.5): bool
    {
        return ($this->noul ?? 0.0) >= $threshold;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_filter([
            'type' => $this->type->value,
            'confidence' => $this->confidence,
            'noul' => $this->noul,
            'choice' => $this->choice,
            'score' => $this->score,
            'probabilities' => $this->probabilities,
            'legend' => $this->legend,
        ], static fn ($v): bool => $v !== null);
    }
}
