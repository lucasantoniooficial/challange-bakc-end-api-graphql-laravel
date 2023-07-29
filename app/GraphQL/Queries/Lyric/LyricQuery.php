<?php

declare(strict_types=1);

namespace App\GraphQL\Queries\Lyric;

use App\Models\Lyric;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Log;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\SelectFields;

class LyricQuery extends Query
{
    protected $attributes = [
        'name' => 'lyric',
        'description' => 'Query return one lyric data '
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
            ]
        ];
    }

    protected function rules(array $args = []): array
    {
        return [
            'id' => [
                'required',
                'exists:lyrics,id'
            ]
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        try {
            return Lyric::query()->findOrFail($args['id']);
        } catch (\Exception $exception) {
            Log::error('Lyric query one', [
                'message' => $exception->getMessage(),
                'trace' => $exception->getTrace()
            ]);

            return $exception->getMessage();
        }
    }
}
