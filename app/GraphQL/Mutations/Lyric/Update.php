<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations\Lyric;

use App\Models\Lyric;
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
        'name' => 'lyricUpdate',
        'description' => 'Mutation update lyric'
    ];

    public function type(): Type
    {
        return GraphQL::type('Lyric');
    }

    public function args(): array
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
            ]
        ];
    }

    protected function rules(array $args = []): array
    {
        return [
            'id' => [
                'required',
                'exists:lyrics'
            ],
            'music_id' => [
                'required',
                'exists:musics,id'
            ],
            'content' => [
                'required',
                'string',
                'max:1000'
            ]
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        try {
            $lyric = Lyric::query()->findOrFail($args['id']);

            $lyric->update($args);

            $lyric->refresh();

            return $lyric;
        } catch (\Exception $exception) {
            Log::error('Lyric mutation update', [
                'message' => $exception->getMessage(),
                'trace' => $exception->getTrace()
            ]);
            return $exception->getMessage();
        }
    }
}
