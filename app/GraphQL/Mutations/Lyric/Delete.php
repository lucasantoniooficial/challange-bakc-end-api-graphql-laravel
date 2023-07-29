<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations\Lyric;

use App\Models\Lyric;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Log;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;

class Delete extends Mutation
{
    protected $attributes = [
        'name' => 'lyricDelete',
        'description' => 'Mutation delete lyric'
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
                'description' => 'lyric id'
            ]
        ];
    }

    protected function rules(array $args = []): array
    {
        return [
            'id' => [
                'required',
                'exists:lyrics'
            ]
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        try {
            $lyric = Lyric::query()->findOrFail($args['id']);

            $lyric->delete();

            return 'Successfully deleted lyric';
        } catch (\Exception $exception) {
            Log::error('Lyric mutation delete', [
                'message' => $exception->getMessage(),
                'trace' => $exception->getTrace()
            ]);
            return $exception->getMessage();
        }
    }
}
