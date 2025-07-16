<?php

declare(strict_types=1);

namespace Gemini\Testing\Responses\Fixtures\CachedContents;

final class MetadataResponseFixture
{
    public const ATTRIBUTES = [
        'name' => 'cachedContents/123-456',
        'model' => 'models/gemini-pro',
        'displayName' => 'A17_FlightPlan',
        'usageMetadata' => [
            'promptTokenCount' => 0,
            'totalTokenCount' => 0,
        ],
        'createTime' => '2014-10-02T15:01:23Z',
        'updateTime' => '2014-10-02T16:01:23Z',
        'expireTime' => '2014-10-02T17:01:23Z',
    ];
}
