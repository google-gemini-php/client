<?php

declare(strict_types=1);

namespace Gemini\Contracts;

use BackedEnum;
use Gemini\Contracts\Resources\ChatSessionContract;
use Gemini\Contracts\Resources\EmbeddingModalContract;
use Gemini\Contracts\Resources\GenerativeModelContract;
use Gemini\Contracts\Resources\ModelContract;

interface ClientContract
{
    public function models(): ModelContract;

    public function generativeModel(BackedEnum|string $model): GenerativeModelContract;

    /**
     * @deprecated Use `generativeModel()`
     */
    public function geminiPro(): GenerativeModelContract;

    /**
     * @deprecated Use `generativeModel()`
     */
    public function geminiFlash(): GenerativeModelContract;

    public function embeddingModel(BackedEnum|string $model): EmbeddingModalContract;

    public function chat(BackedEnum|string $model): ChatSessionContract;
}
