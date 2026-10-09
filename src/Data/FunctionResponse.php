<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;
use Gemini\Enums\FunctionResponseScheduling;

/**
 * The result output from a FunctionCall that contains a string representing the FunctionDeclaration.name and a structured JSON object containing any output from the function is used as context to the model. This should contain the result of aFunctionCall made based on model prediction.
 *
 * https://ai.google.dev/api/caching#FunctionResponse
 */
final class FunctionResponse implements Arrayable
{
    /**
     * @param  string  $name  The name of the function to call. Must be a-z, A-Z, 0-9, or contain underscores and dashes, with a maximum length of 63.
     * @param  array<string, mixed>  $response  The function response in JSON object format.
     * @param  string|null  $id  Optional. The id of the function call this response is for. Populated by the client to match the corresponding function call id.
     * @param  array<FunctionResponsePart>|null  $parts  Optional. Ordered parts that constitute a function response. Parts may have different IANA MIME types.
     * @param  bool|null  $willContinue  Optional. Signals that function call continues, and more responses will be returned, turning the function call into a generator. Is only applicable to NON_BLOCKING function calls.
     * @param  FunctionResponseScheduling|null  $scheduling  Optional. Specifies how the response should be scheduled in the conversation. Only applicable to NON_BLOCKING function calls.
     */
    public function __construct(
        public string $name,
        public array $response,
        public ?string $id = null,
        public ?array $parts = null,
        public ?bool $willContinue = null,
        public ?FunctionResponseScheduling $scheduling = null,
    ) {}

    /**
     * @param  array{ name: string, response: array<string, mixed>, id?: string, parts?: array<array{ inlineData?: array{ mimeType: string, data: string } }>, willContinue?: bool, scheduling?: string }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            name: $attributes['name'],
            response: $attributes['response'],
            id: $attributes['id'] ?? null,
            parts: isset($attributes['parts']) ? array_map(
                static fn (array $part): FunctionResponsePart => FunctionResponsePart::from($part),
                $attributes['parts'],
            ) : null,
            willContinue: $attributes['willContinue'] ?? null,
            scheduling: isset($attributes['scheduling']) ? FunctionResponseScheduling::tryFrom($attributes['scheduling']) : null,
        );
    }

    public function toArray(): array
    {
        $data = [
            'name' => $this->name,
            'response' => $this->response,
            'id' => $this->id,
        ];

        if ($this->parts !== null) {
            $data['parts'] = array_map(
                static fn (FunctionResponsePart $part): array => $part->toArray(),
                $this->parts,
            );
        }

        if ($this->willContinue !== null) {
            $data['willContinue'] = $this->willContinue;
        }

        if ($this->scheduling !== null) {
            $data['scheduling'] = $this->scheduling->value;
        }

        return $data;
    }
}
