<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations\Album;

use App\Models\Album;
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
        'name' => 'albumCreate',
        'description' => 'Mutation create album'
    ];

    public function type(): Type
    {
        return GraphQL::type('Album');
    }

    public function args(): array
    {
        return [
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
            ]
        ];
    }

    protected function rules(array $args = []): array
    {
        return [
             'composer_name' => [
                 'required',
                 'string',
                 'max:255'
             ],
            'name' => [
                'required',
                'string',
            ],
            'year' => [
                'required',
                'numeric',
            ]
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        try {
            return Album::query()->create($args);
        } catch (\Exception $exception) {
            Log::error('Album mutation create', [
                'message' => $exception->getMessage(),
                'trace' => $exception->getTrace()
            ]);
            return $exception->getMessage();
        }
    }
}
