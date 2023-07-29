<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class AlbumType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Album',
        'description' => 'Album data type'
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::id(),
                'description' => 'album id'
            ],
            'composer_name' => [
                'type' => Type::string(),
                'description' => 'album composer name'
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'album name'
            ],
            'year' => [
                'type' => Type::int(),
                'description' => 'album year'
            ],
            'musics' => [
                'type' => Type::listOf(GraphQL::type('Music')),
                'description' => "someone's relationship with musics",
                'is_relation' => true
            ]
        ];
    }
}
