<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;

/**
 * Tool details that the model may use to generate response.
 * A Tool is a piece of code that enables the system to interact with external systems to perform an action, or set of actions, outside of knowledge and scope of the model.
 *
 * https://ai.google.dev/api/caching#Tool
 */
final class Tool implements Arrayable
{
    /**
     * @param  array<FunctionDeclaration>|null  $functionDeclarations  Optional. A list of FunctionDeclarations available to the model that can be used for function calling. The model or system does not execute the function. Instead the defined function may be returned as a FunctionCall with arguments to the client side for execution. The model may decide to call a subset of these functions by populating FunctionCall in the response. The next conversation turn may contain a FunctionResponse with the Content.role "function" generation context for the next model turn.
     * @param  GoogleSearchRetrieval|null  $googleSearchRetrieval  Optional. Retrieval tool that is powered by Google search.
     * @param  CodeExecution|null  $codeExecution  Optional. Enables the model to execute code as part of generation.
     * @param  GoogleSearch|null  $googleSearch  Optional. GoogleSearch tool type. Tool to support Google Search in Model. Powered by Google.
     */
    public function __construct(
        public ?array $functionDeclarations = null,
        public ?GoogleSearchRetrieval $googleSearchRetrieval = null,
        public ?CodeExecution $codeExecution = null,
        public ?GoogleSearch $googleSearch = null,
    ) {}

    public function toArray(): array
    {
        $data = [];

        if ($this->functionDeclarations !== null) {
            $data['functionDeclarations'] = array_map(
                static fn (FunctionDeclaration $functionDeclaration) => $functionDeclaration->toArray(),
                $this->functionDeclarations
            );
        }

        if ($this->googleSearchRetrieval !== null) {
            $data['googleSearchRetrieval'] = $this->googleSearchRetrieval->toArray();
        }

        if ($this->codeExecution !== null) {
            $data['codeExecution'] = $this->codeExecution->toArray();
        }

        if ($this->googleSearch !== null) {
            $data['google_search'] = $this->googleSearch->toArray();
        }

        return $data;
    }
}
