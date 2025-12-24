<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;

/**
 * Sources that provide answers about the features of a given place in Google Maps.
 *
 * https://ai.google.dev/api/generate-content#PlaceAnswerSources
 */
final class PlaceAnswerSources implements Arrayable
{
    /**
     * @param  array<ReviewSnippet>  $reviewSnippets  These are snippets of reviews used to generate answers about the features of a given place in Google Maps.
     */
    public function __construct(
        public readonly array $reviewSnippets,
    ) {}

    /**
     * @param  array{ reviewSnippets: array<array{ title: ?string, googleMapsUri: ?string, reviewId: ?string }> }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            reviewSnippets: array_map(
                static fn (array $snippet): ReviewSnippet => ReviewSnippet::from($snippet),
                $attributes['reviewSnippets'],
            ),
        );
    }

    public function toArray(): array
    {
        return [
            'reviewSnippets' => array_map(
                static fn (ReviewSnippet $snippet): array => $snippet->toArray(),
                $this->reviewSnippets,
            ),
        ];
    }
}
