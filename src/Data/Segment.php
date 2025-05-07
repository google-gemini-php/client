<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;

/**
 * Segment of the content
 *
 * https://ai.google.dev/gemini-api/docs/grounding?configure-search&lang=rest#grounded-response
 */
final class Segment implements Arrayable
{
    /**
     * @param  int|null  $endIndex  End index in the given Part, measured in bytes. Offset from the start of the Part, exclusive, starting at zero
     * @param  int|null  $partIndex  The index of a Part object within its parent Content object
     * @param  int|null  $startIndex  Start index in the given Part, measured in bytes. Offset from the start of the Part, inclusive, starting at zero
     * @param  string|null  $text  The text corresponding to the segment from the response
     */
    public function __construct(
        public readonly ?int $endIndex = null,
        public readonly ?int $partIndex = null,
        public readonly ?int $startIndex = null,
        public readonly ?string $text = null,
    ) {}

    /**
     * @param  array{ endIndex: ?int, partIndex: ?int, startIndex: ?int, text: ?string }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            endIndex: $attributes['endIndex'] ?? null,
            partIndex: $attributes['partIndex'] ?? null,
            startIndex: $attributes['startIndex'] ?? null,
            text: $attributes['text'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'endIndex' => $this->endIndex,
            'partIndex' => $this->partIndex,
            'startIndex' => $this->startIndex,
            'text' => $this->text,
        ];
    }
}
