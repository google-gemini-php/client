<?php

declare(strict_types=1);

namespace Gemini\Testing\Transporters;

use Gemini\Contracts\TransporterContract;
use Gemini\Data\Content;
use Gemini\Foundation\Request;
use Gemini\Requests\GenerativeModel\CountTokensRequest;
use Gemini\Requests\GenerativeModel\GenerateContentRequest;
use Gemini\Requests\GenerativeModel\StreamGenerateContentRequest;
use Gemini\Responses\GenerativeModel\GenerateContentResponse;
use Gemini\Testing\Resources\GenerativeModelTestResource;
use Gemini\Transporters\DTOs\ResponseDTO;
use Http\Discovery\Psr17FactoryDiscovery;
use LogicException;
use Psr\Http\Message\ResponseInterface;

/**
 * Lets a real GenerativeModel run on ClientFake, so objects that need one, like ChatSession, can be faked.
 * Requests are recorded on the fake exactly like GenerativeModelTestResource records them.
 */
final class TestTransporter implements TransporterContract
{
    public function __construct(
        private readonly GenerativeModelTestResource $model,
    ) {}

    public function request(Request $request): ResponseDTO
    {
        $response = match (true) {
            $request instanceof GenerateContentRequest => $this->model->generateContent(...$this->contents($request)),
            $request instanceof CountTokensRequest => $this->model->countTokens(...$this->contents($request)),
            default => throw new LogicException('The test transporter does not support '.$request::class.'.'),
        };

        return new ResponseDTO($response->toArray());
    }

    public function requestStream(Request $request): ResponseInterface
    {
        if ($request instanceof StreamGenerateContentRequest === false) {
            throw new LogicException('The test transporter does not support '.$request::class.'.');
        }

        $chunks = [];

        foreach ($this->model->streamGenerateContent(...$this->contents($request)) as $chunk) {
            /** @var GenerateContentResponse $chunk */
            $chunks[] = $chunk->toArray();
        }

        return Psr17FactoryDiscovery::findResponseFactory()
            ->createResponse()
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream(json_encode($chunks, JSON_THROW_ON_ERROR)));
    }

    /**
     * @return array<Content>
     */
    private function contents(GenerateContentRequest|StreamGenerateContentRequest|CountTokensRequest $request): array
    {
        /** @var array{ contents: array<array{ parts?: array{ array{ text: ?string, inlineData: ?array{ mimeType: string, data: string }, fileData: ?array{ fileUri: string, mimeType: string }, functionCall: ?array{ name: string, args: array<string, mixed>|null }, functionResponse: ?array{ name: string, response: array<string, mixed> } } }, role?: string }> } $body */
        $body = $request->body();

        return array_map(static fn (array $content): Content => Content::from($content), $body['contents']);
    }
}
