<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;

/**
 * Video-specific metadata from a video file upload.
 */
final class VideoMetadata implements Arrayable
{
    public function __construct(
        public readonly string $videoDuration,
    ) {}

    /**
     * @param  array{ videoDuration: string }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            videoDuration: $attributes['videoDuration'],
        );
    }

    public function toArray(): array
    {
        return [
            'videoDuration' => $this->videoDuration,
        ];
    }
}
