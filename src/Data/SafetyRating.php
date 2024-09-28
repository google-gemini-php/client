<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;
use Gemini\Enums\HarmCategory;
use Gemini\Enums\HarmProbability;

/**
 * Safety rating for a piece of content.
 *
 * The safety rating contains the category of harm and the harm probability level in that category
 * for a piece of content. Content is classified for safety across a number of harm categories
 * and the probability of the harm classification is included here.
 *
 * https://ai.google.dev/api/rest/v1/GenerateContentResponse#safetyrating
 */
final class SafetyRating implements Arrayable
{
    /**
     * @param  HarmCategory  $category  The category for this rating.
     * @param  HarmProbability  $probability  The probability of harm for this content.
     * @param  ?bool  $blocked  Was this content blocked because of this rating?
     */
    public function __construct(
        public readonly HarmCategory $category,
        public readonly HarmProbability $probability,
        public readonly ?bool $blocked,
    ) {}

    /**
     * @param  array{ category: string, probability: string, blocked: ?bool }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            category: HarmCategory::from($attributes['category']),
            probability: HarmProbability::from($attributes['probability']),
            blocked: $attributes['blocked'] ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'category' => $this->category->value,
            'probability' => $this->probability->value,
            'blocked' => $this->blocked,
        ];
    }
}
