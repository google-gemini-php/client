<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;
use Gemini\Enums\ModelStage;

/**
 * The status of the underlying model. This is used to indicate the stage of the underlying model and the retirement time if applicable.
 *
 * https://ai.google.dev/api/generate-content#ModelStatus
 */
final class ModelStatus implements Arrayable
{
    /**
     * @param  ModelStage|null  $modelStage  The stage of the underlying model.
     * @param  string|null  $retirementTime  The time at which the model will be retired.
     * @param  string|null  $message  A message explaining the model status.
     */
    public function __construct(
        public readonly ?ModelStage $modelStage = null,
        public readonly ?string $retirementTime = null,
        public readonly ?string $message = null,
    ) {}

    /**
     * @param  array{ modelStage?: string, retirementTime?: string, message?: string }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            modelStage: isset($attributes['modelStage']) ? ModelStage::tryFrom($attributes['modelStage']) : null,
            retirementTime: $attributes['retirementTime'] ?? null,
            message: $attributes['message'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'modelStage' => $this->modelStage?->value,
            'retirementTime' => $this->retirementTime,
            'message' => $this->message,
        ];
    }
}
