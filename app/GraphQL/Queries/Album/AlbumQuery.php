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

class AlbumQuery extends Query
{
    protected $attributes = [
        'name' => 'album',
        'description' => 'Query return one album data'
    ];

    public function type(): Type
    {
        return GraphQL::type('Album');
    }

    public function args(): array
    {
        return [
            'id' => [
                'type' => Type::int(),
                'description' => 'album id'
            ]
        ];
    }

    protected function rules(array $args = []): array
    {
        return [
            'id' => [
                'required',
                'exists:albums,id'
            ]
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
       try {
           return Album::query()->findOrFail($args['id']);
       } catch (\Exception $exception) {
           Log::error('Album query one', [
               'message' => $exception->getMessage(),
               'trace' => $exception->getTrace()
           ]);

           return $exception->getMessage();
       }
    }
}
