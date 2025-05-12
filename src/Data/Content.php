<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;
use Gemini\Enums\Role;

/**
 * The base structured datatype containing multi-part content of a message.
 * A Content includes a role field designating the producer of the Content and a parts
 * field containing multi-part data that contains the content of the message turn.
 *
 * https://ai.google.dev/api/caching#Content
 */
final class Content implements Arrayable
{
    /**
     * @param  array<Part>  $parts  Ordered Parts that constitute a single message. Parts may have different MIME types.
     * @param  Role|null  $role  The producer of the content. Must be either 'user' or 'model'. Useful to set for multi-turn conversations, otherwise can be left blank or unset.
     */
    public function __construct(
        public readonly array $parts,
        public readonly ?Role $role = null,
    ) {}

    /**
     * @param  string|Blob|array<string|Blob|UploadedFile>|Content|UploadedFile  $part
     */
    public static function parse(string|Blob|array|Content|UploadedFile $part, Role $role = Role::USER): self
    {
        return match (true) {
            $part instanceof self => $part,
            $part instanceof Blob => new Content(parts: [new Part(inlineData: $part)], role: $role),
            $part instanceof UploadedFile => new Content(parts: [new Part(fileData: $part)], role: $role),
            is_array($part) => new Content(
                parts: array_map(
                    callback: static fn ($subPart) => match (true) {
                        is_string($subPart) => new Part(text: $subPart),
                        $subPart instanceof Blob => new Part(inlineData: $subPart),
                        $subPart instanceof UploadedFile => new Part(fileData: $subPart),
                    },
                    array: $part,
                ),
                role: $role,
            ),
            is_string($part) => new Content(parts: [new Part(text: $part)], role: $role),
        };
    }

    /**
     * @param  array{ parts?: array{ array{ text: ?string, inlineData: ?array{ mimeType: string, data: string }, fileData: ?array{ fileUri: string, mimeType: string }, functionCall: ?array{ name: string, args: array<string, mixed>|null }, functionResponse: ?array{ name: string, response: array<string, mixed> } } }, role?: string|string }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            parts: array_map(
                static fn (array $candidate): Part => Part::from($candidate),
                $attributes['parts'] ?? [],
            ),
            role: isset($attributes['role']) ? Role::from($attributes['role']) : null
        );
    }

    public function toArray(): array
    {
        return [
            'parts' => array_map(
                static fn (Part $part): array => $part->toArray(),
                $this->parts,
            ),
            'role' => $this->role?->value,
        ];
    }
}
