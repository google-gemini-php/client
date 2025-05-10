<?php

declare(strict_types=1);

namespace Gemini\Concerns;

use BackedEnum;

trait HasModel
{
    public function parseModel(BackedEnum|string $model): string
    {
        return match (true) {
            $model instanceof BackedEnum => (string) $model->value,
            str_starts_with($model, 'models/') => $model,
            str_starts_with($model, 'tunedModels/') => $model,
            default => "models/$model"
        };
    }
}
