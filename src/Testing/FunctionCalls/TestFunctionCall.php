<?php

declare(strict_types=1);

namespace Gemini\Testing\FunctionCalls;

use Gemini\Enums\ModelType;

final class TestFunctionCall
{
    /**
     * @param  array<string, mixed>  $args
     */
    public function __construct(protected string $resource, protected string $method, protected array $args, protected ModelType|string|null $model = null) {}

    public function resource(): string
    {
        return $this->resource;
    }

    public function method(): string
    {
        return $this->method;
    }

    /**
     * @return array<string, mixed>
     */
    public function args(): array
    {
        return $this->args;
    }

    public function model(): ModelType|string|null
    {
        return $this->model;
    }
}
