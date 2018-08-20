<?php

namespace App\GraphQL\Type;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class UserType extends GraphQLType
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
                'description' => 'The id of the user'
            ],
            'email' => [
                'type' => Type::string(),
                'description' => 'The email of user'
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'a user name'
            ],
            'role' => [
                'type' => Type::int(),
                'description' => 'a role code'
            ],
            'created' => [
                'type' => Type::string(),
                'description' => 'Created timestamp'
            ],
            'transactions' => [
                'args' => [
                    'id' => [
                        'type' => Type::int(),
                        'description' => 'id of a transaction',
                    ],
                    'status_code' => [
                        'type' => Type::int(),
                        'description' => 'transaction status'
                    ]
                ],
                'type' => Type::listOf(GraphQL::type('Transaction')),
                'description' => 'transactions',
            ]

        ];
    }

    public function resolveTransactionsField($root, $args)
    {
        $queryBuilder = $root->transactions();

        if (isset($args['id'])) {
            $queryBuilder->where('id', $args['id']);
        }

        if (isset($args['status_code'])) {
            $queryBuilder->where('status_code', $args['status_code']);
        }

        return $queryBuilder->get();
    }
}