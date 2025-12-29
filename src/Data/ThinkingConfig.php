<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;
use Gemini\Enums\ThinkingLevel;

/**
 * Config for thinking features.
 *
 * https://ai.google.dev/api/generate-content#ThinkingConfig
 */
final class ThinkingConfig implements Arrayable
{
    /**
     * @param  bool  $includeThoughts  Indicates whether to include thoughts in the response. If true, thoughts are returned only when available.
     * @param  int|null  $thinkingBudget  The number of thoughts tokens that the model should generate.
     * @param  ThinkingLevel|null  $thinkingLevel  Controls reasoning behavior.
     */
    public function __construct(
        public readonly bool $includeThoughts,
        public readonly ?int $thinkingBudget = null,
        public readonly ?ThinkingLevel $thinkingLevel = null,
    ) {}

    /**
     * @param  array{ includeThoughts: bool, thinkingBudget?: int, thinkingLevel?: ?ThinkingLevel}  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            includeThoughts: $attributes['includeThoughts'],
            thinkingBudget: $attributes['thinkingBudget'] ?? null,
            thinkingLevel: $attributes['thinkingLevel'] ?? null
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'includeThoughts' => $this->includeThoughts,
            'thinkingBudget' => $this->thinkingBudget,
            'thinkingLevel' => $this->thinkingLevel?->value,
        ], fn ($value) => $value !== null);
    }
}
