<?php

declare(strict_types=1);

namespace Gemini\Responses\CachedContents;

use Gemini\Contracts\ResponseContract;
use Gemini\Data\CachedContent;
use Gemini\Testing\Responses\Concerns\Fakeable;

class ListResponse implements ResponseContract
{
    use Fakeable;

    /**
     * @param  array<CachedContent>  $cachedContents
     */
    public function __construct(public readonly array $cachedContents, public readonly ?string $nextPageToken = null) {}

    /**
     * @param  array{cachedContents:?array<array<string,mixed>>, nextPageToken:?string}  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            cachedContents: array_map(fn (array $c) => CachedContent::from($c), $attributes['cachedContents'] ?? []),
            nextPageToken: $attributes['nextPageToken'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'cachedContents' => array_map(fn (CachedContent $c) => $c->toArray(), $this->cachedContents),
            'nextPageToken' => $this->nextPageToken,
        ];
    }
}
