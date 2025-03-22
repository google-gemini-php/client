<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;
use Gemini\Enums\DataType;

/**
 * https://ai.google.dev/api/caching#Schema
 *
 * The Schema object allows the definition of input and output data types.
 */
class Schema implements Arrayable
{
    /**
     * The Schema object allows the definition of input and output data types.
     *
     * @param  DataType  $type  Data type.
     * @param  DataFormat|null  $format  The format of the data. This is used only for primitive datatypes.
     * @param  string|null  $description  A brief description of the parameter.
     * @param  bool|null  $nullable  Indicates if the value may be null.
     * @param  array<string>|null  $enum  Possible values of the element of Type.STRING with enum format.
     * @param  string|null  $maxItems  Maximum number of the elements for Type.ARRAY.
     * @param  string|null  $minItems  Minimum number of the elements for Type.ARRAY.
     * @param  array<string, Schema>|null  $properties  Properties of Type.OBJECT.
     * @param  array<string>|null  $required  Required properties of Type.OBJECT.
     * @param  array<string>|null  $propertyOrdering  PropertyOrdering of Type.OBJECT.
     * @param  Schema|null  $items  Schema of the elements of Type.ARRAY.
     */
    public function __construct(
        public readonly DataType $type,
        public readonly ?DataFormat $format = null,
        public readonly ?string $description = null,
        public readonly ?bool $nullable = null,
        public readonly ?array $enum = null,
        public readonly ?string $maxItems = null,
        public readonly ?string $minItems = null,
        public readonly ?array $properties = null,
        public readonly ?array $required = null,
        public readonly ?array $propertyOrdering = null,
        public readonly ?Schema $items = null
    ) {}

    public function toArray(): array
    {
        return array_filter(
            array: [
                'type' => $this->type->value,
                'format' => $this->format,
                'description' => $this->description,
                'nullable' => $this->nullable,
                'enum' => $this->enum,
                'maxItems' => $this->maxItems,
                'minItems' => $this->minItems,
                'properties' => array_map(fn ($property) => $property->toArray(), $this->properties ?? []),
                'required' => $this->required,
                'propertyOrdering' => $this->propertyOrdering,
                'items' => $this->items?->toArray(),
            ]
        );
    }
}
