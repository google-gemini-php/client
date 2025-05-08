<?php

declare(strict_types=1);

namespace Gemini\Testing\Requests;

use BackedEnum;

final class TestRequest
{
    /**
     * @param  array<string, mixed>  $args
     */
    public function __construct(protected string $resource, protected string $method, protected array $args, protected BackedEnum|string|null $model = null) {}

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

    public function model(): BackedEnum|string|null
    {
        return $this->model;
    }
}
