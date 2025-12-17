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
     * @param  int  $thinkingBudget  The number of thoughts tokens that the model should generate.
     * @param  ThinkingLevel|null  $thinkingLevel  Controls reasoning behavior.
     */
    public function __construct(
        public readonly bool $includeThoughts,
        public readonly int $thinkingBudget,
        public readonly ?ThinkingLevel $thinkingLevel = null,
    ) {}

    /**
     * @param  array{ includeThoughts: bool, thinkingBudget: int, thinkingLevel: ?ThinkingLevel}  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            includeThoughts: $attributes['includeThoughts'],
            thinkingBudget: $attributes['thinkingBudget'],
            thinkingLevel: $attributes['thinkingLevel'] ?? null
        );
    }

    public function toArray(): array
    {
        $items = [
            'includeThoughts' => $this->includeThoughts,
            'thinkingBudget' => $this->thinkingBudget,
        ];

        if ($this->thinkingLevel) {
            $items['thinkingLevel'] = $this->thinkingLevel->value;
        }

        return $items;
    }
}
