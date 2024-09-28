<?php

declare(strict_types=1);

namespace Gemini\Contracts\Resources;

use Gemini\Enums\ModelType;
use Gemini\Responses\Models\ListModelResponse;
use Gemini\Responses\Models\RetrieveModelResponse;

interface ModelContract
{
    public function list(?int $pageSize = null, ?string $nextPageToken = null): ListModelResponse;

    public function retrieve(ModelType|string $model): RetrieveModelResponse;
}
