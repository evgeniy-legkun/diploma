<?php

namespace App\GraphQL\Type;

use GraphQL;
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
            ]
        ];
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