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
     * @param  array<Model>  $models  The returned Models.
     * @param  string|null  $nextPageToken  A token, which can be sent as pageToken to retrieve the next page.
     */
    public function __construct(
        public readonly array $models,
        public readonly ?string $nextPageToken = null,
    ) {}

    /**
     * @param  array{ models: array{ array{ name: string, version: string, displayName: string, description: string, inputTokenLimit: int, outputTokenLimit: int, supportedGenerationMethods: array<string>, baseModelId: ?string, temperature: ?float, maxTemperature: ?float, topP: ?float, topK: ?int } }, nextPageToken: ?string }  $attributes
     */
    public static function from(array $attributes): self
    {
        $models = array_map(
            static fn (array $model): Model => Model::from($model),
            $attributes['models'],
        );

        return new self(
            models: $models,
            nextPageToken: $attributes['nextPageToken'] ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'models' => array_map(
                static fn (Model $model): array => $model->toArray(),
                $this->models
            ),
            'nextPageToken' => $this->nextPageToken,
        ];
    }
}
