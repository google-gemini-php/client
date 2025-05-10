<?php

declare(strict_types=1);

namespace Gemini\Contracts\Resources;

use BackedEnum;
use Gemini\Responses\Models\ListModelResponse;
use Gemini\Responses\Models\RetrieveModelResponse;

interface ModelContract
{
    public function list(?int $pageSize = null, ?string $nextPageToken = null): ListModelResponse;

    public function retrieve(BackedEnum|string $model): RetrieveModelResponse;
}
