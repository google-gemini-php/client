<?php

declare(strict_types=1);

namespace Gemini\Testing\Responses\Fixtures\GenerativeModel;

final class GenerateContentResponseFixture
{
    public const ATTRIBUTES = [
        'candidates' => [
            [
                'content' => [
                    'parts' => [
                        [
                            'text' => 'Once upon a time, in a small town nestled at the foot of towering mountains, there lived a young girl named Lily. Lily was an adventurous and imaginative child, always dreaming of exploring the world beyond her home. One day, while wandering through the attic of her grandmother\'s house, she stumbled upon a dusty old backpack tucked away in a forgotten corner. Intrigued, Lily opened the backpack and discovered that it was an enchanted one. Little did she know that this magical backpack would change her life forever.\n\nAs Lily touched the backpack, it shimmered with an otherworldly light. She reached inside and pulled out a map that seemed to shift and change before her eyes, revealing hidden paths and distant lands. Curiosity tugged at her heart, and without hesitation, Lily shouldered the backpack and embarked on her first adventure.\n\nWith each step she took, the backpack adjusted to her needs. When the path grew treacherous, the backpack transformed into sturdy hiking boots, providing her with the confidence to navigate rocky terrains. When a sudden rainstorm poured down, the backpack transformed into a cozy shelter, shielding her from the elements.\n\nAs days turned into weeks, Lily\'s journey took her through lush forests, across treacherous rivers, and to the summits of towering mountains. The backpack became her loyal companion, guiding her along the way, offering comfort, protection, and inspiration.\n\nAmong her many adventures, Lily encountered a lost fawn that she gently carried in the backpack\'s transformed cradle. She helped a friendly giant navigate a dense fog by using the backpack\'s built-in compass. And when faced with a raging river, the backpack magically transformed into a sturdy raft, transporting her safely to the other side.\n\nThrough her travels, Lily discovered the true power of the magic backpack. It wasn\'t just a magical object but a reflection of her own boundless imagination and tenacity. She realized that the world was hers to explore, and the backpack was a tool to help her reach her full potential.\n\nAs Lily returned home, enriched by her adventures and brimming with stories, she decided to share the magic of the backpack with others. She organized a special adventure club, where children could embark on their own extraordinary journeys using the backpack\'s transformative powers. Together, they explored hidden worlds, learned valuable lessons, and formed lifelong friendships.\n\nAnd so, the legend of the magic backpack lived on, passed down from generation to generation. It became a reminder that even the simplest objects can hold extraordinary power when combined with imagination, courage, and a sprinkle of magic.',
                        ],
                    ],
                    'role' => 'model',
                ],
                'finishReason' => 'STOP',
                'index' => 0,
                'safetyRatings' => [
                    [
                        'category' => 'HARM_CATEGORY_SEXUALLY_EXPLICIT',
                        'probability' => 'NEGLIGIBLE',
                    ],
                    [
                        'category' => 'HARM_CATEGORY_HATE_SPEECH',
                        'probability' => 'NEGLIGIBLE',
                    ],
                    [
                        'category' => 'HARM_CATEGORY_HARASSMENT',
                        'probability' => 'NEGLIGIBLE',
                    ],
                    [
                        'category' => 'HARM_CATEGORY_DANGEROUS_CONTENT',
                        'probability' => 'NEGLIGIBLE',
                    ],
                ],
            ],
        ],
        'promptFeedback' => [
            'safetyRatings' => [
                [
                    'category' => 'HARM_CATEGORY_SEXUALLY_EXPLICIT',
                    'probability' => 'NEGLIGIBLE',
                ],
                [
                    'category' => 'HARM_CATEGORY_HATE_SPEECH',
                    'probability' => 'NEGLIGIBLE',
                ],
                [
                    'category' => 'HARM_CATEGORY_HARASSMENT',
                    'probability' => 'NEGLIGIBLE',
                ],
                [
                    'category' => 'HARM_CATEGORY_DANGEROUS_CONTENT',
                    'probability' => 'NEGLIGIBLE',
                ],
            ],
        ],
        'usageMetadata' => [
            'promptTokenCount' => 8,
            'candidatesTokenCount' => 444,
            'totalTokenCount' => 452,
        ],
    ];
}
