<?php

declare(strict_types=1);

namespace Gemini\Requests\Decisions;

use Gemini\Contracts\Arrayable;
use Gemini\Data\Blob;
use Gemini\Data\Content;
use Gemini\Data\Decisions\ChoiceQuestion;
use Gemini\Data\Decisions\NoulQuestion;
use Gemini\Data\Decisions\ScoreQuestion;
use Gemini\Data\UploadedFile;
use Gemini\Enums\Method;
use Gemini\Foundation\Request;
use Gemini\Requests\Concerns\HasJsonBody;

final class CreateRequest extends Request
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  string|Blob|UploadedFile|Content|array<mixed>  $input
     * @param  array<string, NoulQuestion|ChoiceQuestion|ScoreQuestion|array<string, mixed>>  $questions
     */
    public function __construct(
        protected readonly string $model,
        protected readonly string|Blob|UploadedFile|Content|array $input,
        protected readonly array $questions,
    ) {}

    public function resolveEndpoint(): string
    {
        return 'decisions';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        $parsedInput = match (true) {
            is_string($this->input) => $this->input,
            $this->input instanceof Arrayable => $this->input->toArray(),
            is_array($this->input) => array_map(
                static fn ($item) => $item instanceof Arrayable ? $item->toArray() : $item,
                $this->input
            ),
        };

        $questions = [];
        foreach ($this->questions as $key => $question) {
            $questions[$key] = $question instanceof Arrayable ? $question->toArray() : $question;
        }

        return [
            'model' => $this->model,
            'input' => $parsedInput,
            'questions' => $questions,
        ];
    }
}
