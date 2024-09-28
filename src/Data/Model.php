<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;

/**
 * Information about a Generative Language Model.
 *
 * https://ai.google.dev/api/rest/v1/models#resource:-model
 */
final class Model implements Arrayable
{
    /**
     * @param  string  $name  The resource name of the Model.
     * @param  string  $version  The version number of the model.
     * @param  string  $displayName  The human-readable name of the model. E.g. "ChatSession Bison".
     * @param  string  $description  A short description of the model.
     * @param  int  $inputTokenLimit  Maximum number of input tokens allowed for this model.
     * @param  int  $outputTokenLimit  Maximum number of output tokens available for this model.
     * @param  array<string>  $supportedGenerationMethods  The model's supported generation methods.
     * @param  ?string  $baseModelId  The name of the base model, pass this to the generation request.
     * @param  float|null  $temperature  Controls the randomness of the output.
     * @param  float|null  $maxTemperature  The maximum temperature this model can use.
     * @param  float|null  $topP  For Nucleus sampling.
     * @param  int|null  $topK  For Top-k sampling.
     */
    public function __construct(
        public readonly string $name,
        public readonly string $version,
        public readonly string $displayName,
        public readonly string $description,
        public readonly int $inputTokenLimit,
        public readonly int $outputTokenLimit,
        public readonly array $supportedGenerationMethods,
        public readonly ?string $baseModelId = null,
        public readonly ?float $temperature = null,
        public readonly ?float $maxTemperature = null,
        public readonly ?float $topP = null,
        public readonly ?int $topK = null,
    ) {}

    /**
     * @param  array{ name: string, version: string, displayName: string, description: string, inputTokenLimit: int, outputTokenLimit: int, supportedGenerationMethods: array<string>, baseModelId: ?string, temperature: ?float, maxTemperature: ?float, topP: ?float, topK: ?int }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            name: $attributes['name'],
            version: $attributes['version'],
            displayName: $attributes['displayName'],
            description: $attributes['description'],
            inputTokenLimit: $attributes['inputTokenLimit'],
            outputTokenLimit: $attributes['outputTokenLimit'],
            supportedGenerationMethods: $attributes['supportedGenerationMethods'],
            baseModelId: $attributes['baseModelId'] ?? null,
            temperature: $attributes['temperature'] ?? null,
            maxTemperature: $attributes['maxTemperature'] ?? null,
            topP: $attributes['topP'] ?? null,
            topK: $attributes['topK'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'version' => $this->version,
            'displayName' => $this->displayName,
            'description' => $this->description,
            'inputTokenLimit' => $this->inputTokenLimit,
            'outputTokenLimit' => $this->outputTokenLimit,
            'supportedGenerationMethods' => $this->supportedGenerationMethods,
            'baseModelId' => $this->baseModelId,
            'temperature' => $this->temperature,
            'maxTemperature' => $this->maxTemperature,
            'topP' => $this->topP,
            'topK' => $this->topK,
        ];
    }
}
