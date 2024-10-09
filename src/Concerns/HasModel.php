<?php

declare(strict_types=1);

namespace Gemini\Concerns;

use BackedEnum;
use Gemini\Enums\ModelType;

trait HasModel
{
    public function parseModel(ModelType|string $model): string
    {
        return match (true) {
            $model instanceof BackedEnum => $model->value,
            str_starts_with($model, 'models/') => $model,
            str_starts_with($model, 'tunedModels/') => $model,
            default => "models/$model"
        };
    }
}
