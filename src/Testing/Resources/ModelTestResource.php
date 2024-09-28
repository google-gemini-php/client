<?php

declare(strict_types=1);

namespace Gemini\Testing\Resources;

use Gemini\Contracts\Resources\ModelContract;
use Gemini\Enums\ModelType;
use Gemini\Resources\Models;
use Gemini\Responses\Models\ListModelResponse;
use Gemini\Responses\Models\RetrieveModelResponse;
use Gemini\Testing\Resources\Concerns\Testable;

final class ModelTestResource implements ModelContract
{
    use Testable;

    protected function resource(): string
    {
        return Models::class;
    }

    public function list(?int $pageSize = null, ?string $nextPageToken = null): ListModelResponse
    {
        return $this->record(method: __FUNCTION__, args: func_get_args());
    }

    public function retrieve(ModelType|string $model): RetrieveModelResponse
    {
        return $this->record(method: __FUNCTION__, args: func_get_args());
    }
}
