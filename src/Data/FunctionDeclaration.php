<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;

/**
 * Structured representation of a function declaration as defined by the OpenAPI 3.03 specification. Included in this declaration are the function name and parameters. This FunctionDeclaration is a representation of a block of code that can be used as a Tool by the model and executed by the client.
 *
 * https://ai.google.dev/api/caching#FunctionDeclaration
 */
final class FunctionDeclaration implements Arrayable
{
    /**
     * @param  string  $name  Required. The name of the function. Must be a-z, A-Z, 0-9, or contain underscores and dashes, with a maximum length of 63.
     * @param  string  $description  Required. A brief description of the function.
     * @param  Schema|null  $parameters  Optional. Describes the parameters to this function. Reflects the Open API 3.03 Parameter Object string Key: the name of the parameter. Parameter names are case sensitive. Schema Value: the Schema defining the type used for the parameter.
     * @param  Schema|null  $response  Optional. Describes the output from this function in JSON Schema format. Reflects the Open API 3.03 Response Object. The Schema defines the type used for the response value of the function.
     */
    public function __construct(
        public string $name,
        public string $description,
        public ?Schema $parameters = null,
        public ?Schema $response = null,
    ) {}

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'parameters' => $this->parameters?->toArray(),
            'response' => $this->response?->toArray(),
        ];
    }
}
