<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;

/**
 * A collection of source attributions for a piece of content.
 *
 * https://ai.google.dev/api/rest/v1/GenerateContentResponse#citationmetadata
 */
final class CitationMetadata implements Arrayable
{
    /**
     * @param  array<CitationSource>  $citationSources  Citations to sources for a specific response.
     */
    public function __construct(
        public readonly ?array $citationSources = null,
    ) {}

    /**
     * @param  array{ citationSources: array{ array{ startIndex: int, endIndex: int, uri: ?string, license: ?string } } }  $attributes
     */
    public static function from(array $attributes): self
    {
        $citationSources = array_map(
            static fn (array $source): CitationSource => CitationSource::from($source),
            $attributes['citationSources'],
        );

        return new self(
            citationSources: $citationSources
        );
    }

    public function toArray(): array
    {
        return [
            'citationSources' => array_map(
                static fn (CitationSource $source): array => $source->toArray(),
                $this->citationSources ?? []
            ),
        ];
    }
}
