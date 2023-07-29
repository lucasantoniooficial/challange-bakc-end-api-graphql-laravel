<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class LyricType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Lyric',
        'description' => 'Lyric data type'
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::id(),
                'description' => 'lyric id'
            ],
            'music_id' => [
                'type' => Type::id(),
                'description' => 'lyric music id'
            ],
            'content' => [
                'type' => Type::string(),
                'description' => 'lyric content'
            ],
            'music' => [
                'type' => GraphQL::type('Music'),
                'description' => "Someone's relation with music",
                'is_relation' => true
            ]
        ];
    }
}
