<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;

/**
 * Config for thinking features.
 *
 * https://ai.google.dev/api/generate-content#ThinkingConfig
 */
final class ThinkingConfig implements Arrayable
{
    /**
     * @param  bool  $includeThoughts  Indicates whether to include thoughts in the response. If true, thoughts are returned only when available.
     * @param  int  $thinkingBudget  The number of thoughts tokens that the model should generate.
     */
    public function __construct(
        public readonly bool $includeThoughts,
        public readonly int $thinkingBudget,
    ) {}

    /**
     * @param  array{ includeThoughts: bool, thinkingBudget: int}  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            includeThoughts: $attributes['includeThoughts'],
            thinkingBudget: $attributes['thinkingBudget'],
        );
    }

    public function toArray(): array
    {
        return [
            'includeThoughts' => $this->includeThoughts,
            'thinkingBudget' => $this->thinkingBudget,
        ];
    }
}
