<?php

declare(strict_types=1);

namespace Gemini\Enums;

/**
 * The type of a server-side tool.
 *
 * https://ai.google.dev/api/caching#ToolType
 */
enum ToolType: string
{
    /**
     * Unspecified tool type.
     */
    case TOOL_TYPE_UNSPECIFIED = 'TOOL_TYPE_UNSPECIFIED';

    /**
     * Google search tool, maps to Tool.google_search.search_types.web_search.
     */
    case GOOGLE_SEARCH_WEB = 'GOOGLE_SEARCH_WEB';

    /**
     * Image search tool, maps to Tool.google_search.search_types.image_search.
     */
    case GOOGLE_SEARCH_IMAGE = 'GOOGLE_SEARCH_IMAGE';

    /**
     * URL context tool, maps to Tool.url_context.
     */
    case URL_CONTEXT = 'URL_CONTEXT';

    /**
     * Google maps tool, maps to Tool.google_maps.
     */
    case GOOGLE_MAPS = 'GOOGLE_MAPS';

    /**
     * File search tool, maps to Tool.file_search.
     */
    case FILE_SEARCH = 'FILE_SEARCH';
}
