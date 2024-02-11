<?php

declare(strict_types=1);

namespace Gemini\Responses;

use Gemini\Testing\Responses\Concerns\Fakeable;
use Generator;
use IteratorAggregate;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

/**
 * @template T
 *
 * @implements  IteratorAggregate<int, T>
 */
final class StreamResponse implements IteratorAggregate
{
    use Fakeable;

    /**
     * Creates a new Stream ResponseDTO instance.
     */
    public function __construct(
        private readonly string $responseClass,
        private readonly ResponseInterface $response,
    ) {
        //
    }

    public function getIterator(): Generator
    {
        while (! $this->response->getBody()->eof()) {
            $line = $this->readLine($this->response->getBody());

            if (($response = json_decode($line, true)) === null) {
                continue;
            }

            yield $this->responseClass::from($response);
        }
    }

    /**
     * Read a line from the stream.
     */
    private function readLine(StreamInterface $stream): string
    {
        $buffer = '';

        while (! $stream->eof()) {
            $buffer .= $stream->read(1);

            if (strlen($buffer) === 1 && $buffer !== '{') {
                $buffer = '';
            }

            if (json_decode($buffer) !== null) {
                return $buffer;
            }
        }

        return rtrim($buffer, ']');
    }
}
