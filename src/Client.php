<?php

declare(strict_types=1);

namespace Gemini;

use Gemini\Contracts\ClientContract;
use Gemini\Contracts\TransporterContract;
use Gemini\Data\Model;
use Gemini\Enums\ModelType;
use Gemini\Resources\ChatSession;
use Gemini\Resources\EmbeddingModel;
use Gemini\Resources\GenerativeModel;
use Gemini\Resources\Models;

final class Client implements ClientContract
{
    /**
     * Creates an instance with the given Transporter
     */
    public function __construct(private readonly TransporterContract $transporter)
    {
    }

    /**
     *  Lists available models.
     */
    public function models(): Models
    {
        return new Models(transporter: $this->transporter);
    }

    public function generativeModel(ModelType|string $model): GenerativeModel
    {
        return new GenerativeModel(transporter: $this->transporter, model: $model);
    }

    public function geminiPro(): GenerativeModel
    {
        return $this->generativeModel(model: ModelType::GEMINI_PRO);
    }

    public function geminiProVision(): GenerativeModel
    {
        return $this->generativeModel(model: ModelType::GEMINI_PRO_VISION);
    }

    public function geminiPro1_0(): GenerativeModel
    {
        return $this->generativeModel(model: ModelType::GEMINI_PRO_1_0);
    }

    public function geminiProLatest1_0(): GenerativeModel
    {
        return $this->generativeModel(model: ModelType::GEMINI_PRO_1_0_LATEST);
    }

    public function geminiPro1_5(): GenerativeModel
    {
        return $this->generativeModel(model: ModelType::GEMINI_PRO_1_5);
    }

    public function geminiProFlash1_5(): GenerativeModel
    {
        return $this->generativeModel(model: ModelType::GEMINI_PRO_1_5_FLASH);
    }

    public function embeddingModel(ModelType|string $model = ModelType::EMBEDDING): EmbeddingModel
    {
        return new EmbeddingModel(transporter: $this->transporter, model: $model);
    }

    /**
     * Contains an ongoing conversation with the model.
     */
    public function chat(ModelType|string $model = ModelType::GEMINI_PRO): ChatSession
    {
        return new ChatSession(model: $this->generativeModel(model: $model));
    }
}
