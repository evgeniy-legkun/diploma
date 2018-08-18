<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class WarehouseType extends GraphQLType
{
    protected $attributes = [
        'name' => 'User',
        'description' => 'A user'
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The id of warehouse'
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'warehouse name'
            ],
            'address' => [
                'type' => Type::string(),
                'description' => 'a user name'
            ],
            'note' => [
                'type' => Type::string(),
                'description' => ''
            ]
        ];
    }
}