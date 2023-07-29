<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations\Album;

use App\Models\Album;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Log;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;

class Delete extends Mutation
{
    protected $attributes = [
        'name' => 'albumDelete',
        'description' => 'Mutation delete album'
    ];

    public function type(): Type
    {
        return Type::string();
    }

    public function args(): array
    {
        return [
            'id' => [
                'type' => Type::id(),
                'description' => 'album id'
            ]
        ];
    }

    protected function rules(array $args = []): array
    {
        return [
            'id' => [
                'required',
                'exists:albums'
            ]
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        try {
            $album = Album::query()->findOrFail($args['id']);

            $album->delete();

            return 'Successfully deleted album';
        } catch (\Exception $exception) {
            Log::error('Album mutation delete', [
                'message' => $exception->getMessage(),
                'trace' => $exception->getTrace()
            ]);
            return $exception->getMessage();
        }
    }
}
