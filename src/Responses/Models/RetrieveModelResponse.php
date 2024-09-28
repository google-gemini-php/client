<?php

declare(strict_types=1);

namespace Gemini\Responses\Models;

use Gemini\Contracts\ResponseContract;
use Gemini\Data\Model;
use Gemini\Testing\Responses\Concerns\Fakeable;

class RetrieveModelResponse implements ResponseContract
{
    use Fakeable;

    public function __construct(
        public readonly Model $model,
    ) {}

    /**
     * @param  array{ name: string, version: string, displayName: string, description: string, inputTokenLimit: int, outputTokenLimit: int, supportedGenerationMethods: array<string>, baseModelId: ?string, temperature: ?float, maxTemperature: ?float, topP: ?float, topK: ?int }  $attributes
     */
    public static function from(array $attributes): self
    {
        $model = Model::from($attributes);

        return new self(model: $model);
    }

    public function toArray(): array
    {
        return $this->model->toArray();
    }
}
