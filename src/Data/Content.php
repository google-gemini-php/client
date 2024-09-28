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
 * https://ai.google.dev/api/rest/v1/Content
 */
final class Content implements Arrayable
{
    /**
     * @param  array<Part>  $parts  Ordered Parts that constitute a single message. Parts may have different MIME types.
     * @param  Role  $role  The producer of the content. Must be either 'user' or 'model'. Useful to set for multi-turn conversations, otherwise can be left blank or unset.
     */
    public function __construct(
        public readonly array $parts,
        public readonly Role $role,
    ) {}

    /**
     * @param  string|Blob|array<string|Blob>|Content  $part
     */
    public static function parse(string|Blob|array|Content $part, Role $role = Role::USER): self
    {
        return match (true) {
            $part instanceof self => $part,
            $part instanceof Blob => new Content(parts: [new Part(inlineData: $part)], role: $role),
            is_array($part) => new Content(
                parts: array_map(
                    callback: static fn ($subPart) => match (true) {
                        is_string($subPart) => new Part(text: $subPart),
                        $subPart instanceof Blob => new Part(inlineData: $subPart),
                    },
                    array: $part,
                ),
                role: $role,
            ),
            is_string($part) => new Content(parts: [new Part(text: $part)], role: $role),
        };
    }

    /**
     * @param  array{ parts: array{ array{ text: ?string, inlineData: array{ mimeType: string, data: string } } }, role: string }  $attributes
     */
    public static function from(array $attributes): self
    {
        $parts = array_map(
            static fn (array $candidate): Part => Part::from($candidate),
            $attributes['parts'],
        );

        return new self(
            parts: $parts,
            role: Role::from($attributes['role'])
        );
    }

    public function toArray(): array
    {
        return [
            'parts' => array_map(
                static fn (Part $part): array => $part->toArray(),
                $this->parts,
            ),
            'role' => $this->role->value,
        ];
    }
}
