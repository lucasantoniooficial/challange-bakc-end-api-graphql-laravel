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

class Create extends Mutation
{
    protected $attributes = [
        'name' => 'lyricCreate',
        'description' => 'Mutation create lyric'
    ];

    public function type(): Type
    {
        return GraphQL::type('Lyric');
    }

    public function args(): array
    {
        return [
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
            return Lyric::query()->create($args);
        } catch (\Exception $exception) {
            Log::error('Lyric mutation create', [
                'message' => $exception->getMessage(),
                'trace' => $exception->getTrace()
            ]);
            return $exception->getMessage();
        }
    }
}
