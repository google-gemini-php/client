<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;

/**
 * Google search entry point.
 *
 * https://ai.google.dev/api/generate-content#SearchEntryPoint
 */
final class SearchEntryPoint implements Arrayable
{
    /**
     * @param  string|null  $renderedContent  Optional. Web content snippet that can be embedded in a web page or an app webview.
     * @param  string|null  $sdkBlob  Optional. Base64 encoded JSON representing array of <search term, search url> tuple. A base64-encoded string.
     */
    public function __construct(
        public readonly ?string $renderedContent,
        public readonly ?string $sdkBlob,
    ) {}

    /**
     * @param  array{ renderedContent?: string|null, sdkBlob?: string|null }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            renderedContent: $attributes['renderedContent'] ?? null,
            sdkBlob: $attributes['sdkBlob'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'renderedContent' => $this->renderedContent,
            'sdkBlob' => $this->sdkBlob,
        ];
    }
}
