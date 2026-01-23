<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;

/**
 * Config for image generation features.
 *
 * https://ai.google.dev/api/generate-content#ImageConfig
 */
final class ImageConfig implements Arrayable
{
    /**
     * @param  string  $aspectRatio  The aspect ratio of the image to generate. Supported aspect ratios: 1:1, 2:3, 3:2, 3:4, 4:3, 9:16, 16:9, 21:9. If not specified, the model will choose a default aspect ratio based on any reference images provided.
     * @param  string  $imageSize  Specifies the size of generated images. Supported values are 1K, 2K, 4K. If not specified, the model will use default value 1K.
     */
    public function __construct(
        public readonly string $aspectRatio,
        public readonly string $imageSize,
    ) {}

    /**
     * @param  array{ aspectRatio: string, imageSize: string }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            aspectRatio: $attributes['aspectRatio'],
            imageSize: $attributes['imageSize'],
        );
    }

    public function toArray(): array
    {
        return [
            'aspectRatio' => $this->aspectRatio,
            'imageSize' => $this->imageSize,
        ];
    }
}
