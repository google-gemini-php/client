<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;

/**
 * Segment of the content.
 *
 * https://ai.google.dev/api/generate-content#Segment
 */
final class Segment implements Arrayable
{
    /**
     * @param  int|null  $partIndex  Output only. The index of a Part object within its parent Content object.
     * @param  int|null  $startIndex  Output only. Start index in the given Part, measured in bytes. Offset from the start of the Part, inclusive, starting at zero.
     * @param  int|null  $endIndex  Output only. Output only. End index in the given Part, measured in bytes. Offset from the start of the Part, exclusive, starting at zero.
     * @param  string|null  $text  Output only. The text corresponding to the segment from the response.
     */
    public function __construct(
        public readonly ?int $partIndex = null,
        public readonly ?int $startIndex = null,
        public readonly ?int $endIndex = null,
        public readonly ?string $text = null,
    ) {}

    /**
     * @param  array{ partIndex: ?int, startIndex: ?int, endIndex: ?int, text: ?string }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            partIndex: $attributes['partIndex'] ?? null,
            startIndex: $attributes['startIndex'] ?? null,
            endIndex: $attributes['endIndex'] ?? null,
            text: $attributes['text'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'partIndex' => $this->partIndex,
            'startIndex' => $this->startIndex,
            'endIndex' => $this->endIndex,
            'text' => $this->text,
        ];
    }
}
