<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;
use Gemini\Enums\PartMediaResolutionLevel;

/**
 * Media resolution for the input media of a single part.
 *
 * https://ai.google.dev/api/caching#MediaResolution
 */
final class PartMediaResolution implements Arrayable
{
    /**
     * @param  PartMediaResolutionLevel|null  $level  The tokenization quality used for the media.
     */
    public function __construct(
        public readonly ?PartMediaResolutionLevel $level = null,
    ) {}

    /**
     * @param  array{ level?: string }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            level: isset($attributes['level']) ? PartMediaResolutionLevel::tryFrom($attributes['level']) : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'level' => $this->level?->value,
        ], fn ($value) => $value !== null);
    }
}
