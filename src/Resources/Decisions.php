<?php

declare(strict_types=1);

namespace Gemini\Resources;

use BackedEnum;
use Gemini\Concerns\HasModel;
use Gemini\Contracts\Resources\DecisionsContract;
use Gemini\Contracts\TransporterContract;
use Gemini\Data\Blob;
use Gemini\Data\Content;
use Gemini\Data\Decisions\ChoiceQuestion;
use Gemini\Data\Decisions\NoulQuestion;
use Gemini\Data\Decisions\ScoreQuestion;
use Gemini\Data\UploadedFile;
use Gemini\Requests\Decisions\CreateRequest;
use Gemini\Responses\Decisions\DecisionsResponse;
use Gemini\Transporters\DTOs\ResponseDTO;

final class Decisions implements DecisionsContract
{
    use HasModel;

    public function __construct(private readonly TransporterContract $transporter) {}

    /**
     * @param  string|Blob|UploadedFile|Content|array<mixed>  $input
     * @param  array<string, NoulQuestion|ChoiceQuestion|ScoreQuestion|array<string, mixed>>  $questions
     */
    public function create(
        string|Blob|UploadedFile|Content|array $input,
        array $questions,
        BackedEnum|string $model = 'models/gemini-decision-1',
    ): DecisionsResponse {
        /** @var ResponseDTO<array{answers?: array<string, array<string, mixed>>, usage?: array<string, mixed>, usageMetadata?: array<string, mixed>}> $response */
        $response = $this->transporter->request(new CreateRequest(
            model: $this->parseModel($model),
            input: $input,
            questions: $questions,
        ));

        return DecisionsResponse::from($response->data());
    }
}
