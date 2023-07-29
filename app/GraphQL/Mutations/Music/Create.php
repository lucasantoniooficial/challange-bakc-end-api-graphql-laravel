<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations\Music;

use App\Models\Music;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Log;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;

class Create extends Mutation
{
    protected $attributes = [
        'name' => 'musicCreate',
        'description' => 'Mutation create music'
    ];

    public function type(): Type
    {
        return GraphQL::type('Music');
    }

    public function args(): array
    {
        return [
            'album_id' => [
                'type' => Type::id(),
                'description' => 'music album id'
            ],
            'genre' => [
                'type' => Type::string(),
                'descrption' => 'music genre'
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'music name'
            ],
            'launch_date' => [
                'type' => Type::string(),
                'description' => 'music launch date'
            ],
        ];
    }

    protected function rules(array $args = []): array
    {
        return [
            'album_id' => [
                'required',
                'exists:albums,id'
            ],
            'genre' => [
                'required',
                'string'
            ],
            'name' => [
                'required',
                'string',
            ],
            'launch_date' => [
                'required'
            ]
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        try {
            return Music::query()->create($args);
        } catch (\Exception $exception) {
            Log::error('Music mutation create', [
                'message' => $exception->getMessage(),
                'trace' => $exception->getTrace()
            ]);
            return $exception->getMessage();
        }
    }
}
