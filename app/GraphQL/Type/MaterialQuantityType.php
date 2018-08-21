<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class MaterialQuantityType extends GraphQLType
{
    protected $attributes = [
        'name' => 'MaterialQuantity',
        'description' => 'A material quantity'
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::int(),
                'description' => 'The id of the material'
            ],
            'quantity' => [
                'type' => Type::float(),
                'description' => 'quantity'
            ],
        ];
    }
}