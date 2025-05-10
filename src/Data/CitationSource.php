<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;

/**
 * A citation to a source for a portion of a specific response.
 *
 * https://ai.google.dev/api/generate-content#CitationSource
 */
final class CitationSource implements Arrayable
{
    /**
     * @param  int|null  $startIndex  Optional. Start of segment of the response that is attributed to this source. Index indicates the start of the segment, measured in bytes.
     * @param  int|null  $endIndex  Optional. End of the attributed segment, exclusive.
     * @param  string|null  $uri  Optional. URI that is attributed as a source for a portion of the text.
     * @param  string|null  $license  Optional. License for the GitHub project that is attributed as a source for segment.
     *
     * License info is required for code citations.
     */
    public function __construct(
        public readonly ?int $startIndex,
        public readonly ?int $endIndex,
        public readonly ?string $uri,
        public readonly ?string $license,
    ) {}

    /**
     * @param  array{ startIndex: ?int, endIndex: ?int, uri: ?string, license: ?string}  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            startIndex: $attributes['startIndex'] ?? null,
            endIndex: $attributes['endIndex'] ?? null,
            uri: $attributes['uri'] ?? null,
            license: $attributes['license'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'startIndex' => $this->startIndex,
            'endIndex' => $this->endIndex,
            'uri' => $this->uri,
            'license' => $this->license,
        ];
    }
}
