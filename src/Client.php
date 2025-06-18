<?php

declare(strict_types=1);

namespace Gemini;

use BackedEnum;
use Gemini\Contracts\ClientContract;
use Gemini\Contracts\Resources\FilesContract;
use Gemini\Contracts\Resources\GenerativeModelContract;
use Gemini\Contracts\TransporterContract;
use Gemini\Enums\ModelType;
use Gemini\Resources\ChatSession;
use Gemini\Resources\EmbeddingModel;
use Gemini\Resources\Files;
use Gemini\Resources\GenerativeModel;
use Gemini\Resources\Models;

final class Client implements ClientContract
{
    /**
     * Creates an instance with the given Transporter
     */
    public function __construct(private readonly TransporterContract $transporter) {}

    /**
     *  Lists available models.
     */
    public function models(): Models
    {
        return new Models(transporter: $this->transporter);
    }

    public function generativeModel(BackedEnum|string $model): GenerativeModel
    {
        return new GenerativeModel(transporter: $this->transporter, model: $model);
    }

    /**
     * @deprecated Use `generativeModel()`
     */
    public function geminiPro(): GenerativeModel
    {
        return $this->generativeModel(model: ModelType::GEMINI_PRO);
    }

    /**
     * @deprecated Use `generativeModel()`
     */
    public function geminiFlash(): GenerativeModelContract
    {
        return $this->generativeModel(model: ModelType::GEMINI_FLASH);
    }

    public function embeddingModel(BackedEnum|string $model): EmbeddingModel
    {
        return new EmbeddingModel(transporter: $this->transporter, model: $model);
    }

    /**
     * Contains an ongoing conversation with the model.
     */
    public function chat(BackedEnum|string $model): ChatSession
    {
        return new ChatSession(model: $this->generativeModel(model: $model));
    }

    /**
     * Resource to manage media file uploads to be reused across multiple requests and prompts.
     *
     * @link https://ai.google.dev/api/files
     */
    public function files(): FilesContract
    {
        return new Files($this->transporter);
    }
}
