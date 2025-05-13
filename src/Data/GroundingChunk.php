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
     */
    public function __construct(
        public readonly ?Web $web = null,
    ) {}

    /**
     * @param  array{ web: null|array{ title: ?string, uri: ?string } }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            web: isset($attributes['web']) ? Web::from($attributes['web']) : null,
        );
    }

    public function toArray(): array
    {
        $data = [];

        if ($this->web !== null) {
            $data['web'] = $this->web->toArray();
        }

        return $data;
    }
}
