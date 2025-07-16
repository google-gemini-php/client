<?php

declare(strict_types=1);

namespace Gemini\Testing\Responses\Fixtures\CachedContents;

final class ListResponseFixture
{
    public const ATTRIBUTES = [
        'cachedContents' => [
            MetadataResponseFixture::ATTRIBUTES,
        ],
        'nextPageToken' => null,
    ];
}
