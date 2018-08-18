<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class MaterialType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Material',
        'description' => 'A material'
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The id of the material'
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'material name'
            ],
            'unit' => [
                'type' => Type::int(),
                'description' => 'material type'
            ]
        ];
    }
}