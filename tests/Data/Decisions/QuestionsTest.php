<?php

use Gemini\Data\Decisions\ChoiceQuestion;
use Gemini\Data\Decisions\DecisionAnswer;
use Gemini\Data\Decisions\NoulQuestion;
use Gemini\Data\Decisions\ScoreQuestion;
use Gemini\Enums\DecisionQuestionType;

it('serializes noul question to array', function () {
    $question = NoulQuestion::make(
        instructions: 'Did it break?',
        criteria: ['true_description' => 'Yes it broke', 'false_description' => 'No intact'],
    );

    expect($question->toArray())->toBe([
        'type' => 'noul',
        'instructions' => 'Did it break?',
        'criteria' => ['true_description' => 'Yes it broke', 'false_description' => 'No intact'],
    ]);
});

it('serializes choice question to array', function () {
    $question = ChoiceQuestion::make(
        instructions: 'Pick a category',
        criteria: ['a' => 'Alpha', 'b' => 'Beta'],
    );

    expect($question->toArray())->toBe([
        'type' => 'choice',
        'instructions' => 'Pick a category',
        'criteria' => ['a' => 'Alpha', 'b' => 'Beta'],
    ]);
});

it('serializes score question to array', function () {
    $question = ScoreQuestion::make(
        instructions: 'Rate from 1 to 3',
        legend: [1 => 'Low', 2 => 'Medium', 3 => 'High'],
    );

    expect($question->toArray())->toBe([
        'type' => 'score',
        'instructions' => 'Rate from 1 to 3',
        'legend' => [1 => 'Low', 2 => 'Medium', 3 => 'High'],
    ]);
});

it('constructs decision answer and checks isYes', function () {
    $answer = DecisionAnswer::from([
        'type' => 'noul',
        'confidence' => 0.95,
        'noul' => 0.95,
    ]);

    expect($answer->type)->toBe(DecisionQuestionType::NOUL)
        ->and($answer->isYes())->toBeTrue()
        ->and($answer->toArray())->toBe([
            'type' => 'noul',
            'confidence' => 0.95,
            'noul' => 0.95,
        ]);
});
