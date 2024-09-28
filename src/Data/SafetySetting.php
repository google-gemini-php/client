<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;
use Gemini\Enums\HarmBlockThreshold;
use Gemini\Enums\HarmCategory;

/**
 * Safety setting, affecting the safety-blocking behavior.
 *
 * https://ai.google.dev/api/rest/v1/SafetySetting
 */
final class SafetySetting implements Arrayable
{
    /**
     * @param  HarmCategory  $category  The category for this setting.
     * @param  HarmBlockThreshold  $threshold  Controls the probability threshold at which harm is blocked.
     */
    public function __construct(
        public readonly HarmCategory $category,
        public readonly HarmBlockThreshold $threshold,
    ) {}

    public function toArray(): array
    {
        return [
            'category' => $this->category->value,
            'threshold' => $this->threshold->value,
        ];
    }
}
