<?php

namespace App\GraphQL\Query\User;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UsersQuery extends Query
{
    protected $attributes = [
        'name' => 'users'
    ];

    public function type()
    {
        return Type::listOf(GraphQL::type('User'));
    }

    public function args()
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::int()
            ],
            'email' => [
                'name' => 'email',
                'type' => Type::string()
            ],
            'role' => [
                'name' => 'role',
                'type' => Type::int()
            ]

        ];
    }

    public function resolve($root, $args)
    {
        $queryBuilder = User::select();

        if (isset($args['id'])) {
            $queryBuilder->where('id', $args['id']);
        }

        if (isset($args['email'])) {
            $queryBuilder->where('email', $args['email']);
        }

        if (isset($args['role'])) {
            $queryBuilder->where('role', $args['role']);
        }

        return $queryBuilder->get();
    }
}