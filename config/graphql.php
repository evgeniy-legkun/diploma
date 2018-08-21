<?php


return [

    'prefix' => 'graphql',

    'domain' => null,

    'routes' => '{graphql_schema?}',

    'controllers' => \Folklore\GraphQL\GraphQLController::class.'@query',

    'variables_input_name' => 'variables',

    'middleware' => [],

    'middleware_schema' => [
        'default' => [],
    ],

    'headers' => [],

    'json_encoding_options' => 0,

    'graphiql' => [
        'routes' => '/graphiql/{graphql_schema?}',
        'controller' => \Folklore\GraphQL\GraphQLController::class.'@graphiql',
        'middleware' => [],
        'view' => 'graphql::graphiql',
        'composer' => \Folklore\GraphQL\View\GraphiQLComposer::class,
    ],

    'schema' => 'default',

    'schemas' => [
        'default' => [
            'query' => [

                'users' => App\GraphQL\Query\User\UsersQuery::class,
                'user' => App\GraphQL\Query\User\UserQuery::class,

                'warehouses' => App\GraphQL\Query\Warehouse\WarehousesQuery::class,
                'warehouse' => App\GraphQL\Query\Warehouse\WarehouseQuery::class,

                'materials' => App\GraphQL\Query\Material\MaterialsQuery::class,
                'material' => App\GraphQL\Query\Material\MaterialQuery::class,

                'roles' => App\GraphQL\Query\RolesQuery::class,

                'transactions' => App\GraphQL\Query\Transaction\TransactionsQuery::class
            ],

            'mutation' => [
                'createUser' => App\GraphQL\Mutation\User\UserCreateMutation::class,
                'removeUser' => App\GraphQL\Mutation\User\UserRemoveMutation::class,
                'updateUser' => App\GraphQL\Mutation\User\UserUpdateMutation::class,

                'createWarehouse' => App\GraphQL\Mutation\Warehouse\WarehouseCreateMutation::class,
                'updateWarehouse' => App\GraphQL\Mutation\Warehouse\WarehouseUpdateMutation::class,
                'removeWarehouse' => App\GraphQL\Mutation\Warehouse\WarehouseRemoveMutation::class,
                'addWarehouseMaterial' => App\GraphQL\Mutation\Warehouse\WarehouseAddMaterialMutation::class,
                'removeWarehouseMaterial' => App\GraphQL\Mutation\Warehouse\WarehouseRemoveMaterialMutation::class,

                'createMaterial' => App\GraphQL\Mutation\Material\MaterialCreateMutation::class,
                'updateMaterial' => App\GraphQL\Mutation\Material\MaterialUpdateMutation::class,
                'removeMaterial' => App\GraphQL\Mutation\Material\MaterialRemoveMutation::class,

                'acceptTransaction' => App\GraphQL\Mutation\Transaction\AcceptTransactionMutation::class,
                'cancelTransaction' => App\GraphQL\Mutation\Transaction\CancelTransactionMutation::class,
                'removeTransaction' => App\GraphQL\Mutation\Transaction\RemoveTransactionMutation::class,
                'finishTransaction' => App\GraphQL\Mutation\Transaction\FinishTransactionMutation::class,
                'createTransaction' => App\GraphQL\Mutation\Transaction\CreateTransactionMutation::class,
                'addMaterialTransaction' => App\GraphQL\Mutation\Transaction\AddMaterialTransactionMutation::class,
            ]
        ]
    ],

    'resolvers' => [
        'default' => [
        ],
    ],

    'defaultFieldResolver' => null,

    'types' => [
        'User' => \App\GraphQL\Type\UserType::class,
        'Role' => \App\GraphQL\Type\RoleType::class,
        'Warehouse' => \App\GraphQL\Type\WarehouseType::class,
        'Material' => \App\GraphQL\Type\MaterialType::class,
        'MaterialQuantity' => \App\GraphQL\Type\MaterialQuantityType::class,
        'WarehouseMaterial' => \App\GraphQL\Type\WarehouseMaterialType::class,
        'Transaction' => \App\GraphQL\Type\TransactionType::class,
    ],

    'error_formatter' => [\Folklore\GraphQL\GraphQL::class, 'formatError'],

    'security' => [
        'query_max_complexity' => null,
        'query_max_depth' => null,
        'disable_introspection' => false
    ]
];
