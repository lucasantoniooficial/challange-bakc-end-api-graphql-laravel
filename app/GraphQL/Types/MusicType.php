<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class MusicType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Music',
        'description' => 'Music data type'
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::id(),
                'description' => 'music id'
            ],
            'album_id' => [
                'type' => Type::id(),
                'description' => 'music album id'
            ],
            'genre' => [
                'type' => Type::string(),
                'description' => 'music genre'
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'music name'
            ],
            'launch_date' => [
                'type' => Type::string(),
                'description' => 'music launch date'
            ],
            'album' => [
                'type' => GraphQL::type('Album'),
                'description' => "someone's relationship with album",
                'is_relation' => true
            ],
            'lyric' => [
                'type' => GraphQL::type('Lyric'),
                'description' => "someone's relationship with lyric",
                'is_relation' => true
            ]
        ];
    }
}
