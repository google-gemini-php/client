<?php

declare(strict_types=1);

namespace Gemini\Testing\Responses\Fixtures\FileSearchStores\Documents;

final class DocumentResponseFixture
{
    public const ATTRIBUTES = [
        'name' => 'fileSearchStores/123/documents/abc',
        'displayName' => 'My Document',
        'customMetadata' => [],
        'updateTime' => '2024-01-01T00:00:00Z',
        'createTime' => '2024-01-01T00:00:00Z',
        'mimeType' => 'text/plain',
        'sizeBytes' => '1024',
        'state' => 'STATE_ACTIVE',
    ];
}
