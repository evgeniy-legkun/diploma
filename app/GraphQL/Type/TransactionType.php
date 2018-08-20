<?php

namespace App\GraphQL\Type;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class TransactionType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Transaction',
        'description' => 'A transaction'
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The id of the material'
            ],
            'courier' => [
                'type' => GraphQL::type('User'),
                'description' => 'A courier',
            ],
            'fromWarehouse' => [
                'type' => GraphQL::type('Warehouse'),
                'description' => 'from warehouse'
            ],
            'toWarehouse' => [
                'type' => GraphQL::type('Warehouse'),
                'description' => 'to warehouse'
            ],
            'materials' => [
                'args' => [
                    'id' => [
                        'type' => Type::int(),
                        'description' => 'id of the material',
                    ],
                ],
                'type' => Type::listOf(GraphQL::type('WarehouseMaterial')),
                'description' => 'Warehouse materials',
            ],
            'status_code' => [
                'type' => Type::int(),
                'description' => 'status code'
            ]
        ];
    }

    public function resolveFromWarehouseField($root, $args)
    {
        return $root->fromWarehouse;
    }

    public function resolveToWarehouseField($root, $args)
    {
        return $root->toWarehouse;
    }

    public function resolveCourierField($root, $args)
    {
        return $root->courier;
    }

    public function resolveMaterialsField($root, $args)
    {
        $materials = [];

        if (isset($args['id'])) {
            $materials = $root->materials()->where('material_id', $args['id'])->get();
        } else {
            $materials = $root->materials()->get();
        }

        $warehouseMaterials = [];

        foreach ($materials as $material) {
            $warehouseMaterials[] = [
                'id' => $material->id,
                'name' => $material->name,
                'unit' => $material->unit,
                'quantity' => $material->pivot->quantity,
            ];
        }

        return $warehouseMaterials;
    }
}