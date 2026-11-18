<?php

declare(strict_types=1);

namespace Gemini\Testing\Resources;

use BackedEnum;
use Gemini\Contracts\Resources\DecisionsContract;
use Gemini\Data\Blob;
use Gemini\Data\Content;
use Gemini\Data\Decisions\ChoiceQuestion;
use Gemini\Data\Decisions\NoulQuestion;
use Gemini\Data\Decisions\ScoreQuestion;
use Gemini\Data\UploadedFile;
use Gemini\Resources\Decisions;
use Gemini\Responses\Decisions\DecisionsResponse;
use Gemini\Testing\Resources\Concerns\Testable;

final class DecisionsTestResource implements DecisionsContract
{
    use Testable;

    protected function resource(): string
    {
        return Decisions::class;
    }

    /**
     * @param  string|Blob|UploadedFile|Content|array<mixed>  $input
     * @param  array<string, NoulQuestion|ChoiceQuestion|ScoreQuestion|array<string, mixed>>  $questions
     */
    public function create(
        string|Blob|UploadedFile|Content|array $input,
        array $questions,
        BackedEnum|string $model = 'models/gemini-decision-1',
    ): DecisionsResponse {
        return $this->record(method: __FUNCTION__, args: func_get_args());
    }
}
