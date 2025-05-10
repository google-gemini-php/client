<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;
use Gemini\Enums\DataType;

/**
 * The Schema object allows the definition of input and output data types. These types can be objects, but also primitives and arrays. Represents a select subset of an OpenAPI 3.0 schema object.
 *
 * https://ai.google.dev/api/caching#Schema
 */
class Schema implements Arrayable
{
    /**
     * The Schema object allows the definition of input and output data types.
     *
     * @param  DataType  $type  Required. Data type.
     * @param  DataFormat|null  $format  Optional. The format of the data. This is used only for primitive datatypes. Supported formats: for NUMBER type: float, double for INTEGER type: int32, int64 for STRING type: enum, date-time
     * @param  string|null  $description  Optional. A brief description of the parameter. This could contain examples of use. Parameter description may be formatted as Markdown.
     * @param  bool|null  $nullable  Optional. Indicates if the value may be null.
     * @param  array<string>|null  $enum  Optional. Possible values of the element of Type.STRING with enum format.
     * @param  string|null  $maxItems  Optional. Maximum number of the elements for Type.ARRAY.
     * @param  string|null  $minItems  Optional. Minimum number of the elements for Type.ARRAY.
     * @param  array<string, Schema>|null  $properties  Optional. Properties of Type.OBJECT. An object containing a list of "key": value pairs.
     * @param  array<string>|null  $required  Optional. Required properties of Type.OBJECT.
     * @param  array<string>|null  $propertyOrdering  Optional. The order of the properties. Not a standard field in open api spec. Used to determine the order of the properties in the response.
     * @param  Schema|null  $items  Optional. Schema of the elements of Type.ARRAY.
     * @param  string|null  $title  Optional. The title of the schema.
     * @param  string|null  $minProperties  Optional. Minimum number of the properties for Type.OBJECT.
     * @param  string|null  $maxProperties  Optional. Maximum number of the properties for Type.OBJECT.
     * @param  string|null  $minLength  Optional. SCHEMA FIELDS FOR TYPE STRING Minimum length of the Type.STRING
     * @param  string|null  $maxLength  Optional. Maximum length of the Type.STRING
     * @param  string|null  $pattern  Optional. Pattern of the Type.STRING to restrict a string to a regular expression.
     * @param  int|float|string|bool|array<array-key, mixed>|null  $example  Optional. Example of the object. Will only populated when the object is the root. https://protobuf.dev/reference/protobuf/google.protobuf/#value
     * @param  array<Schema>  $anyOf  Optional. The value should be validated against any (one or more) of the subschemas in the list.
     * @param  int|float|string|bool|array<array-key, mixed>|null  $default  Optional. Default value of the field. Per JSON Schema, this field is intended for documentation generators and doesn't affect validation. Thus it's included here and ignored so that developers who send schemas with a default field don't get unknown-field errors.
     * @param  float|null  $minimum  Optional. SCHEMA FIELDS FOR TYPE INTEGER and NUMBER Minimum value of the Type.INTEGER and Type.NUMBER
     * @param  float|null  $maximum  Optional. Maximum value of the Type.INTEGER and Type.NUMBER
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
        public readonly ?Schema $items = null,
        public readonly ?string $title = null,
        public readonly ?string $minProperties = null,
        public readonly ?string $maxProperties = null,
        public readonly ?string $minLength = null,
        public readonly ?string $maxLength = null,
        public readonly ?string $pattern = null,
        public readonly int|float|string|bool|array|null $example = null,
        public readonly ?array $anyOf = null,
        public readonly int|float|string|bool|array|null $default = null,
        public readonly ?float $minimum = null,
        public readonly ?float $maximum = null,
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
                'properties' => array_map(
                    static fn (Schema $property) => $property->toArray(),
                    $this->properties ?? []
                ),
                'required' => $this->required,
                'propertyOrdering' => $this->propertyOrdering,
                'items' => $this->items?->toArray(),
                'title' => $this->title,
                'minProperties' => $this->minProperties,
                'maxProperties' => $this->maxProperties,
                'minLength' => $this->minLength,
                'maxLength' => $this->maxLength,
                'pattern' => $this->pattern,
                'example' => $this->example,
                'anyOf' => array_map(
                    static fn (Schema $schema) => $schema->toArray(),
                    $this->anyOf ?? []
                ),
                'default' => $this->default,
                'minimum' => $this->minimum,
                'maximum' => $this->maximum,
            ]
        );
    }
}
