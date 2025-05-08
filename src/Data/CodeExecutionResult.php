<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;
use Gemini\Enums\Outcome;

/**
 * Result of executing the ExecutableCode.
 * Only generated when using the CodeExecution, and always follows a part containing the ExecutableCode.
 *
 * https://ai.google.dev/api/caching#CodeExecutionResult
 */
final class CodeExecutionResult implements Arrayable
{
    /**
     * @param  Outcome  $outcome  Required. Outcome of the code execution.
     * @param  string  $output  Optional. Contains stdout when code execution is successful, stderr or other description otherwise.
     */
    public function __construct(
        public readonly Outcome $outcome,
        public readonly string $output,
    ) {}

    /**
     * @param  array{ outcome: string, output: string }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            outcome: Outcome::from($attributes['outcome']),
            output: $attributes['output'],
        );
    }

    public function toArray(): array
    {
        return [
            'outcome' => $this->outcome->value,
            'output' => $this->output,
        ];
    }
}
