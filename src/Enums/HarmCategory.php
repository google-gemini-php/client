<?php

declare(strict_types=1);

namespace Gemini\Enums;

/**
 * The category of a rating.
 * These categories cover various kinds of harms that developers may wish to adjust.
 *
 * https://ai.google.dev/api/rest/v1/HarmCategory
 */
enum HarmCategory: string
{
    /**
     * Category is unspecified.
     */
    case HARM_CATEGORY_UNSPECIFIED = 'HARM_CATEGORY_UNSPECIFIED';

    /**
     * Negative or harmful comments targeting identity and/or protected attribute.
     */
    case HARM_CATEGORY_DEROGATORY = 'HARM_CATEGORY_DEROGATORY';

    /**
     * Content that is rude, disrepspectful, or profane.
     */
    case HARM_CATEGORY_TOXICITY = 'HARM_CATEGORY_TOXICITY';

    /**
     * Describes scenarios depictng violence against an individual or group, or general descriptions of gore.
     */
    case HARM_CATEGORY_VIOLENCE = 'HARM_CATEGORY_VIOLENCE';

    /**
     * Contains references to sexual acts or other lewd content.
     */
    case HARM_CATEGORY_SEXUAL = 'HARM_CATEGORY_SEXUAL';

    /**
     * Promotes unchecked medical advice.
     */
    case HARM_CATEGORY_MEDICAL = 'HARM_CATEGORY_MEDICAL';

    /**
     * Dangerous content that promotes, facilitates, or encourages harmful acts.
     */
    case HARM_CATEGORY_DANGEROUS = 'HARM_CATEGORY_DANGEROUS';

    /**
     * Harasment content.
     */
    case HARM_CATEGORY_HARASSMENT = 'HARM_CATEGORY_HARASSMENT';

    /**
     * Hate speech and content.
     */
    case HARM_CATEGORY_HATE_SPEECH = 'HARM_CATEGORY_HATE_SPEECH';

    /**
     * Sexually explicit content.
     */
    case HARM_CATEGORY_SEXUALLY_EXPLICIT = 'HARM_CATEGORY_SEXUALLY_EXPLICIT';

    /**
     * Dangerous content.
     */
    case HARM_CATEGORY_DANGEROUS_CONTENT = 'HARM_CATEGORY_DANGEROUS_CONTENT';

    /**
     * Content that may be used to harm civic integrity.
     */
    case HARM_CATEGORY_CIVIC_INTEGRITY = 'HARM_CATEGORY_CIVIC_INTEGRITY';
}
