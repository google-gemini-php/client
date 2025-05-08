<?php

namespace Gemini\Enums;

/**
 * Defines the execution behavior for function calling by defining the execution mode.
 *
 * https://ai.google.dev/api/caching#Mode_1
 */
enum Mode: string
{
    /**
     * Unspecified function calling mode. This value should not be used.
     */
    case MODE_UNSPECIFIED = 'MODE_UNSPECIFIED';

    /**
     * Default model behavior, model decides to predict either a function call or a natural language response.
     */
    case AUTO = 'AUTO';

    /**
     * Model is constrained to always predicting a function call only. If "allowedFunctionNames" are set, the predicted function call will be limited to any one of "allowedFunctionNames", else the predicted function call will be any one of the provided "functionDeclarations".
     */
    case ANY = 'ANY';

    /**
     * Model will not predict any function call. Model behavior is same as when not passing any function declarations.
     */
    case NONE = 'NONE';

    /**
     * Model decides to predict either a function call or a natural language response, but will validate function calls with constrained decoding.
     */
    case VALIDATED = 'VALIDATED';
}
