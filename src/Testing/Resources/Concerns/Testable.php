<?php

declare(strict_types=1);

namespace Gemini\Testing\Resources\Concerns;

use Gemini\Contracts\ResponseContract;
use Gemini\Enums\ModelType;
use Gemini\Responses\StreamResponse;
use Gemini\Testing\ClientFake;
use Gemini\Testing\FunctionCalls\TestFunctionCall;
use Gemini\Testing\Requests\TestRequest;

trait Testable
{
    public function __construct(protected ClientFake $fake, protected ModelType|string|null $model = null) {}

    abstract protected function resource(): string;

    protected function record(string $method, array $args = [], ModelType|string|null $model = null): ResponseContract|StreamResponse
    {
        return $this->fake->record(new TestRequest(resource: $this->resource(), method: $method, args: $args, model: $model));
    }

    public function assertSent(callable|int|null $callback = null): void
    {
        $this->fake->assertSent(resource: $this->resource(), model: $this->model, callback: $callback);
    }

    public function assertNotSent(callable|int|null $callback = null): void
    {
        $this->fake->assertNotSent(resource: $this->resource(), model: $this->model, callback: $callback);
    }

    public function recordFunctionCall(string $method, array $args = [], ModelType|string|null $model = null): void
    {
        $this->fake->recordFunctionCall(new TestFunctionCall(resource: $this->resource(), method: $method, args: $args, model: $model));
    }

    public function assertFunctionCalled(callable|int|null $callback = null): void
    {
        $this->fake->assertFunctionCalled(resource: $this->resource(), model: $this->model, callback: $callback);
    }

    public function assertFunctionNotCalled(callable|int|null $callback = null): void
    {
        $this->fake->assertFunctionNotCalled(resource: $this->resource(), model: $this->model, callback: $callback);
    }
}
