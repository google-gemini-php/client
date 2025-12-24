<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;

/**
 * User review snippet.
 *
 * https://ai.google.dev/api/generate-content#ReviewSnippet
 */
final class ReviewSnippet implements Arrayable
{
    /**
     * @param  ?string  $title  Title of the review.
     * @param  ?string  $googleMapsUri  A link that corresponds to the user review on Google Maps.
     * @param  ?string  $reviewId  The ID of the review snippet.
     */
    public function __construct(
        public readonly ?string $title,
        public readonly ?string $googleMapsUri,
        public readonly ?string $reviewId,
    ) {}

    /**
     * @param  array{ title: ?string, googleMapsUri: ?string, reviewId: ?string }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            title: $attributes['title'] ?? null,
            googleMapsUri: $attributes['googleMapsUri'] ?? null,
            reviewId: $attributes['reviewId'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'googleMapsUri' => $this->googleMapsUri,
            'reviewId' => $this->reviewId,
        ];
    }
}
