<?php

declare(strict_types=1);

namespace Gemini\Responses\CachedContents;

use Gemini\Contracts\ResponseContract;
use Gemini\Data\CachedContent;
use Gemini\Testing\Responses\Concerns\Fakeable;

class MetadataResponse implements ResponseContract
{
    use Fakeable;

    public function __construct(public readonly CachedContent $cachedContent) {}

    /**
     * @param  array{name: string, model: string, displayName: ?string, usageMetadata: array<string,mixed>, createTime: string, updateTime: string, expireTime: string}  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(cachedContent: CachedContent::from($attributes));
    }

    public function toArray(): array
    {
        return $this->cachedContent->toArray();
    }
}
