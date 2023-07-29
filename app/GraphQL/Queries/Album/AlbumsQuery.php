<?php

declare(strict_types=1);

namespace App\GraphQL\Queries\Album;

use App\Models\Album;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Log;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\SelectFields;

class AlbumsQuery extends Query
{
    protected $attributes = [
        'name' => 'albums',
        'description' => 'Query return all albums paginate'
    ];

    public function type(): Type
    {
        return GraphQL::paginate('Album');
    }

    public function args(): array
    {
        return [
            'page' => [
                'type' => Type::int(),
                'description' => 'current page',
                'defaultValue' => 1
            ],
            'limit' => [
                'type' => Type::int(),
                'description' => 'per page data',
                'defaultValue' => 10
            ]
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        try {
            return Album::query()
                ->paginate($args['limit'], '*', 'page', $args['page']);
        } catch (\Exception $exception) {
            Log::error('Albums query paginate', [
                'message' => $exception->getMessage(),
                'trace' => $exception->getTrace()
            ]);
            return $exception->getMessage();
        }
    }
}
