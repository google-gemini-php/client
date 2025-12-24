<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;

/**
 * Grounding chunk from Google Maps.
 *
 * https://ai.google.dev/api/generate-content#Maps
 */
final class Map implements Arrayable
{
    /**
     * @param  ?string  $uri  URI reference of the place.
     * @param  ?string  $title  Title of the place.
     * @param  ?string  $text  Text description of the place answer.
     * @param  ?string  $placeId  The ID of the place, in places/{placeId} format.
     * @param  ?PlaceAnswerSources  $placeAnswerSources  Sources that provide answers about the features of a given place in Google Maps.
     */
    public function __construct(
        public readonly ?string $uri,
        public readonly ?string $title,
        public readonly ?string $text,
        public readonly ?string $placeId,
        public readonly ?PlaceAnswerSources $placeAnswerSources,
    ) {}

    /**
     * @param  array{ uri: ?string, title: ?string, text: ?string, placeId: ?string, placeAnswerSources: ?array{ reviewSnippets: array<array{ title: ?string, googleMapsUri: ?string, reviewId: ?string }> } }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            uri: $attributes['uri'] ?? null,
            title: $attributes['title'] ?? null,
            text: $attributes['text'] ?? null,
            placeId: $attributes['placeId'] ?? null,
            placeAnswerSources: isset($attributes['placeAnswerSources']) ? PlaceAnswerSources::from($attributes['placeAnswerSources']) : null,
        );
    }

    public function toArray(): array
    {
        return [
            'uri' => $this->uri,
            'title' => $this->title,
            'text' => $this->text,
            'placeId' => $this->placeId,
            'placeAnswerSources' => $this->placeAnswerSources?->toArray(),
        ];
    }
}
