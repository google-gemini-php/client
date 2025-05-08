<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;
use Gemini\Enums\DynamicRetrievalMode;

/**
 * Describes the options to customize dynamic retrieval.
 *
 * https://ai.google.dev/api/caching#DynamicRetrievalConfig
 */
final class DynamicRetrievalConfig implements Arrayable
{
    /**
     * @param  DynamicRetrievalMode  $mode  The mode of the predictor to be used in dynamic retrieval.
     * @param  float  $dynamicThreshold  The threshold to be used in dynamic retrieval. If not set, a system default value is used.
     */
    public function __construct(
        public readonly DynamicRetrievalMode $mode,
        public readonly float $dynamicThreshold,
    ) {}

    /**
     * @param  array{ mode: string, dynamicThreshold: float }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            mode: DynamicRetrievalMode::from($attributes['mode']),
            dynamicThreshold: $attributes['dynamicThreshold'],
        );
    }

    public function toArray(): array
    {
        return [
            'mode' => $this->mode->value,
            'dynamicThreshold' => $this->dynamicThreshold,
        ];
    }
}
