<?php

declare(strict_types=1);

namespace Gemini\Contracts\Resources;

use BackedEnum;
use Gemini\Data\Blob;
use Gemini\Data\Content;
use Gemini\Data\Decisions\ChoiceQuestion;
use Gemini\Data\Decisions\NoulQuestion;
use Gemini\Data\Decisions\ScoreQuestion;
use Gemini\Data\UploadedFile;
use Gemini\Responses\Decisions\DecisionsResponse;

interface DecisionsContract
{
    /**
     * Evaluates closed-set questions against a shared input state.
     *
     * @param  string|Blob|UploadedFile|Content|array<mixed>  $input
     * @param  array<string, NoulQuestion|ChoiceQuestion|ScoreQuestion|array<string, mixed>>  $questions
     */
    public function create(
        string|Blob|UploadedFile|Content|array $input,
        array $questions,
        BackedEnum|string $model = 'models/gemini-decision-1',
    ): DecisionsResponse;
}
