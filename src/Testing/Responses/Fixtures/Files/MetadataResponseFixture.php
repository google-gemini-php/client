<?php

declare(strict_types=1);

namespace Gemini\Testing\Responses\Fixtures\Files;

final class MetadataResponseFixture
{
    public const ATTRIBUTES = [
        'name' => 'files/123-456',
        'displayName' => 'Display',
        'mimeType' => 'text/plain',
        'sizeBytes' => '321',
        'createTime' => '2014-10-02T15:01:23.045123456Z',
        'updateTime' => '2014-10-02T15:01:23.045234567Z',
        'expirationTime' => '2014-10-04T15:01:23.045123456Z',
        'sha256Hash' => 'OTVmMTI2MGFiMGQ5MTRmNGZlNWNkZWMxN2Y2YWE1MDI5YmNiOTc3ZjdiZWIzZjQ2YjkzNWI4NGRkNjk4MjViNA==',
        'uri' => 'https://generativelanguage.googleapis.com/v1beta/files/c8d2psijx17p',
        'state' => 'PROCESSING',
        'videoMetadata' => ['videoDuration' => '13s'],
    ];
}
