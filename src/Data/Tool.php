<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;

/**
 * Tool details that the model may use to generate response.
 *
 * https://ai.google.dev/api/caching#Tool
 * https://ai.google.dev/gemini-api/docs/grounding?lang=rest
 */
final class Tool implements Arrayable
{
    /**
     * @param  array<array-key, FunctionDeclaration>  $functionDeclarations  A list of FunctionDeclarations available to the model that can be used for function calling.
     * @param  bool  $useGrounding  Allow Grounding with Google Search. Should not be used with another tool. Only available for model >= 2.0
     */
    public function __construct(
        public ?array $functionDeclarations = null,
        public ?bool $useGrounding = false
    ) {}

    public function toArray(): array
    {
        $return = [];
        if ($this->useGrounding) {
            $return['google_search'] = new \stdClass;
        }
        if (! empty($this->functionDeclarations)) {
            $return['functionDeclarations'] = array_map(static fn (FunctionDeclaration $functionDeclaration) => $functionDeclaration->toArray(), $this->functionDeclarations ?? []);
        }

        return $return;
    }
}
