<?php

declare(strict_types=1);

namespace Gemini\Enums;

enum DecisionQuestionType: string
{
    case NOUL = 'noul';
    case CHOICE = 'choice';
    case SCORE = 'score';
}
