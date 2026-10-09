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
     * @param  string|null  $aspectRatio  Optional. The aspect ratio of the image to generate. Supported aspect ratios: 1:1, 1:4, 4:1, 1:8, 8:1, 2:3, 3:2, 3:4, 4:3, 4:5, 5:4, 9:16, 16:9, 21:9. If not specified, the model will choose a default aspect ratio based on any reference images provided.
     * @param  string|null  $imageSize  Optional. Specifies the size of generated images. Supported values are 512, 1K, 2K, 4K. If not specified, the model will use default value 1K.
     */
    public function __construct(
        public readonly ?string $aspectRatio = null,
        public readonly ?string $imageSize = null,
    ) {}

    /**
     * @param  array{ aspectRatio?: string, imageSize?: string }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            aspectRatio: $attributes['aspectRatio'] ?? null,
            imageSize: $attributes['imageSize'] ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'aspectRatio' => $this->aspectRatio,
            'imageSize' => $this->imageSize,
        ], fn ($value) => $value !== null);
    }
}
