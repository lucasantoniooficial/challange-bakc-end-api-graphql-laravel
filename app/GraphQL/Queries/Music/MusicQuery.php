<?php

declare(strict_types=1);

namespace App\GraphQL\Queries\Music;

use App\Models\Music;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Log;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\SelectFields;

class MusicQuery extends Query
{
    protected $attributes = [
        'name' => 'music',
        'description' => 'Query return one music data'
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
            ]
        ];
    }

    protected function rules(array $args = []): array
    {
        return [
            'id' => [
                'required',
                'exists:musics'
            ]
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        try {
            return Music::query()->findOrFail($args['id']);
        } catch (\Exception $exception) {
            Log::error('Music query one', [
                'message' => $exception->getMessage(),
                'trace' => $exception->getTrace()
            ]);

            return $exception->getMessage();
        }
    }
}
