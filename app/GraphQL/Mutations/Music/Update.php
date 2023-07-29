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

class Update extends Mutation
{
    protected $attributes = [
        'name' => 'musicUpdate',
        'description' => 'Mutation update music'
    ];

    public function type(): Type
    {
        return GraphQL::type('Music');
    }

    public function args(): array
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
                'descrption' => 'music genre'
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'music name'
            ],
            'launch_date' => [
                'type' => Type::string(),
                'description' => 'music launch date'
            ]
        ];
    }

    protected function rules(array $args = []): array
    {
        return [
            'id' => [
                'required',
                'exists:musics'
            ],
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
            $music = Music::query()->findOrFail($args['id']);

            $music->update($args);

            $music->refresh();

            return $music;
        } catch (\Exception $exception) {
            Log::error('Music mutation update', [
                'message' => $exception->getMessage(),
                'trace' => $exception->getTrace()
            ]);
            return $exception->getMessage();
        }
    }
}
