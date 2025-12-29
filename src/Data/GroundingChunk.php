<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;

/**
 * Grounding chunk.
 *
 * https://ai.google.dev/api/generate-content#GroundingChunk
 */
final class GroundingChunk implements Arrayable
{
    /**
     * @param  Web|null  $web  Grounding chunk from the web.
     * @param  RetrievedContext|null  $retrievedContext  Grounding chunk from the file search tool.
     * @param  Map|null  $map  Grounding chunk from Google Maps.
     */
    public function __construct(
        public readonly ?Web $web = null,
        public readonly ?RetrievedContext $retrievedContext = null,
        public readonly ?Map $map = null,
    ) {}

    /**
     * @param  array{
     *     web: null|array{ title: ?string, uri: ?string },
     *     retrievedContext: null|array{ uri: ?string, title: ?string, text: ?string, fileSearchStore: ?string },
     *     maps: null|array{ uri: ?string, title: ?string, text: ?string, placeId: ?string, placeAnswerSources: ?array{ reviewSnippets: array<array{ title: ?string, googleMapsUri: ?string, reviewId: ?string }> } }
     * }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            web: isset($attributes['web']) ? Web::from($attributes['web']) : null,
            retrievedContext: isset($attributes['retrievedContext']) ? RetrievedContext::from($attributes['retrievedContext']) : null,
            map: isset($attributes['maps']) ? Map::from($attributes['maps']) : null,
        );
    }

    public function toArray(): array
    {
        $data = [];

        if ($this->web !== null) {
            $data['web'] = $this->web->toArray();
        }

        if ($this->retrievedContext !== null) {
            $data['retrievedContext'] = $this->retrievedContext->toArray();
        }

        if ($this->map !== null) {
            $data['maps'] = $this->map->toArray();
        }

        return $data;
    }
}
