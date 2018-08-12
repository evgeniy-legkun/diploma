<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class RoleType extends GraphQLType
{
    public function fields()
    {
        return [
            'code' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'user role code'
            ],

            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'user role name'
            ],
        ];
    }
}