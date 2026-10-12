<?php

declare(strict_types=1);

namespace Gemini\Enums;

/**
 * The stage of the underlying model.
 *
 * https://ai.google.dev/api/generate-content#ModelStage
 */
enum ModelStage: string
{
    /**
     * Unspecified model stage.
     */
    case MODEL_STAGE_UNSPECIFIED = 'MODEL_STAGE_UNSPECIFIED';

    /**
     * The underlying model is subject to lots of tunings.
     */
    case UNSTABLE_EXPERIMENTAL = 'UNSTABLE_EXPERIMENTAL';

    /**
     * Models in this stage are for experimental purposes only.
     */
    case EXPERIMENTAL = 'EXPERIMENTAL';

    /**
     * Models in this stage are more mature than experimental models.
     */
    case PREVIEW = 'PREVIEW';

    /**
     * Models in this stage are considered stable and ready for production use.
     */
    case STABLE = 'STABLE';

    /**
     * The model is on the path to deprecation in near future. Only existing customers can use this model.
     */
    case LEGACY = 'LEGACY';

    /**
     * Models in this stage are deprecated. These models cannot be used.
     */
    case DEPRECATED = 'DEPRECATED';

    /**
     * Models in this stage are retired. These models cannot be used.
     */
    case RETIRED = 'RETIRED';
}
