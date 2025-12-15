<?php

declare(strict_types=1);

namespace Gemini\Testing\Responses\Fixtures\FileSearchStores\Documents;

final class ListResponseFixture
{
    public const ATTRIBUTES = [
        'documents' => [
            DocumentResponseFixture::ATTRIBUTES,
        ],
        'nextPageToken' => 'next-page-token',
    ];
}
