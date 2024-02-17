<?php

declare(strict_types=1);

namespace Gemini\Contracts;

use Gemini\Contracts\Resources\ChatSessionContract;
use Gemini\Contracts\Resources\EmbeddingModalContract;
use Gemini\Contracts\Resources\GenerativeModelContract;
use Gemini\Contracts\Resources\ModelContract;
use Gemini\Enums\ModelType;

interface ClientContract
{
    public function models(): ModelContract;

    public function generativeModel(ModelType|string $model): GenerativeModelContract;

    public function geminiPro(): GenerativeModelContract;

    public function geminiProVision(): GenerativeModelContract;

    public function embeddingModel(ModelType|string $model = ModelType::EMBEDDING): EmbeddingModalContract;

    public function chat(ModelType|string $model = ModelType::GEMINI_PRO): ChatSessionContract;
}
