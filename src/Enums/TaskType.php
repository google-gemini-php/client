<?php

declare(strict_types=1);

namespace Gemini\Enums;

/**
 * Type of task for which the embedding will be used.
 *
 * https://ai.google.dev/api/rest/v1/TaskType
 */
enum TaskType: string
{
    /**
     * Unset value, which will default to one of the other enum values.
     */
    case TASK_TYPE_UNSPECIFIED = 'TASK_TYPE_UNSPECIFIED';

    /**
     * Specifies the given text is a query in a search/retrieval setting.
     */
    case RETRIEVAL_QUERY = 'RETRIEVAL_QUERY';

    /**
     * Specifies the given text is a document from the corpus being searched.
     */
    case RETRIEVAL_DOCUMENT = 'RETRIEVAL_DOCUMENT';

    /**
     * Specifies the given text will be used for STS.
     */
    case SEMANTIC_SIMILARITY = 'SEMANTIC_SIMILARITY';

    /**
     * Specifies that the given text will be classified.
     */
    case CLASSIFICATION = 'CLASSIFICATION';

    /**
     * Specifies that the embeddings will be used for clustering.
     */
    case CLUSTERING = 'CLUSTERING';

    /**
     * Specifies that the given text will be used for question answering.
     */
    case QUESTION_ANSWERING = 'QUESTION_ANSWERING';

    /**
     * Specifies that the given text will be used for fact verification.
     */
    case FACT_VERIFICATION = 'FACT_VERIFICATION';
}
