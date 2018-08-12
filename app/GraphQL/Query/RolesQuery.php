<?php

namespace App\GraphQL\Query;

use App\Models\User;
use App\Services\UserManager\UserManger;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;

class RolesQuery extends Query
{

    public function type()
    {
        return Type::listOf(GraphQL::type('Role'));
    }

    public function args()
    {
        return [];
    }

    public function resolve($root, $args)
    {
        return [
            [
                'name' => 'Адміністратор',
                'code' => User::ROLE_ADMINISTRATOR
            ],
            [
                'name' => 'Менеджер складу',
                'code' => User::ROLE_WAREHOUSE_MANAGER
            ],
            [
                'name' => 'Перевізник',
                'code' => User::ROLE_COURIER
            ]
        ];
    }
}