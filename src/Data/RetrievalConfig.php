<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;

/**
 * Configuration for retrieval.
 */
final class RetrievalConfig implements Arrayable
{
    /**
     * @param  float  $latitude  The latitude in degrees. It must be in the range [-90.0, +90.0].
     * @param  float  $longitude  The longitude in degrees. It must be in the range [-180.0, +180.0].
     */
    public function __construct(
        public float $latitude,
        public float $longitude,
    ) {}

    /**
     * @param  array{ latLng: array{ latitude: float, longitude: float } }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            latitude: $attributes['latLng']['latitude'],
            longitude: $attributes['latLng']['longitude'],
        );
    }

    public function toArray(): array
    {
        return [
            'latLng' => [
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
            ],
        ];
    }
}
