<?php

declare(strict_types=1);

namespace Gemini\Enums;

/**
 * Type contains the list of OpenAPI data types as defined by https://spec.openapis.org/oas/v3.0.3#data-types
 *
 * https://ai.google.dev/api/caching#Type
 */
enum DataType: string
{
    case TYPE_UNSPECIFIED = 'TYPE_UNSPECIFIED';
    case STRING = 'STRING';
    case NUMBER = 'NUMBER';
    case INTEGER = 'INTEGER';
    case BOOLEAN = 'BOOLEAN';
    case ARRAY = 'ARRAY';
    case OBJECT = 'OBJECT';
    case NULL = 'NULL';
}
