<?php

declare(strict_types=1);

namespace Gemini\Contracts;

use Gemini\Exceptions\ErrorException;
use Gemini\Exceptions\TransporterException;
use Gemini\Exceptions\UnserializableResponse;
use Gemini\Foundation\Request;
use Gemini\Transporters\DTOs\ResponseDTO;
use JsonException;
use Psr\Http\Message\ResponseInterface;

interface TransporterContract
{
    /**
     * Sends a content request to a server.
     *
     * @return ResponseDTO<array<array-key, mixed>>
     *
     * @throws ErrorException|JsonException|UnserializableResponse|TransporterException
     */
    public function request(Request $request): ResponseDTO;

    /**
     * Sends a stream request to a server.
     */
    public function requestStream(Request $request): ResponseInterface;
}
