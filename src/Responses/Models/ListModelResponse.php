<?php

declare(strict_types=1);

namespace Gemini\Responses\Models;

use Gemini\Contracts\ResponseContract;
use Gemini\Data\Model;
use Gemini\Testing\Responses\Concerns\Fakeable;

class ListModelResponse implements ResponseContract
{
    use Fakeable;

    /**
     * @param  array<Model>  $models
     */
    public function __construct(
        public readonly array $models,
    ) {
    }

    /**
     * @param  array{ models: array{ array{ name: string, version: string, displayName: string, description: string, inputTokenLimit: int, outputTokenLimit: int, supportedGenerationMethods: array<string>, baseModelId: ?string, temperature: ?float, topP: ?float, topK: ?int } } }  $attributes
     */
    public static function from(array $attributes): self
    {
        $models = array_map(
            static fn (array $model): Model => Model::from($model),
            $attributes['models'],
        );

        return new self(models: $models);
    }

    public function toArray(): array
    {
        return [
            'models' => array_map(
                static fn (Model $model): array => $model->toArray(),
                $this->models
            ),
        ];
    }
}
