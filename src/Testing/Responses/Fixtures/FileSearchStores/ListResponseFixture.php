<?php

declare(strict_types=1);

namespace Gemini\Testing\Responses\Fixtures\FileSearchStores;

final class ListResponseFixture
{
    public const ATTRIBUTES = [
        'fileSearchStores' => [
            FileSearchStoreResponseFixture::ATTRIBUTES,
        ],
        'nextPageToken' => 'next-page-token',
    ];
}
