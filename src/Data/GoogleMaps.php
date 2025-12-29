<?php

declare(strict_types=1);

namespace Gemini\Data;

use stdClass;

/**
 * GoogleMaps tool type. Tool to support Google Maps in Model. Powered by Google.
 */
final class GoogleMaps
{
    public function __construct(
        public readonly ?bool $enableWidget = null,
    ) {}

    /**
     * @param  array{ enableWidget?: bool }  $attributes
     */
    public static function from(array $attributes = []): self
    {
        return new self(
            enableWidget: $attributes['enableWidget'] ?? null,
        );
    }

    /**
     * @return array<string, bool>|stdClass
     */
    public function toArray(): array|stdClass
    {
        if ($this->enableWidget === null) {
            return new stdClass;
        }

        return [
            'enableWidget' => $this->enableWidget,
        ];
    }
}
