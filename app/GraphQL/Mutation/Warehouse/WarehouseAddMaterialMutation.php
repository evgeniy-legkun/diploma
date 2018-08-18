<?php

namespace App\GraphQL\Mutation\Warehouse;

use App\Services\WarehouseManager\WarehouseManager;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;

class WarehouseAddMaterialMutation extends Mutation
{
    protected $warehouseManager;

    public function __construct($attributes = [], WarehouseManager $warehouseManager)
    {
        $this->warehouseManager = $warehouseManager;
        parent::__construct($attributes);
    }

    public $attributes = [
        'name' => 'addWarehouseMaterial'
    ];

    public function type()
    {
        return GraphQL::type('Warehouse');
    }

    public function args()
    {
        return [
            'warehouseId' => ['name' => 'warehouseId', 'type' => Type::int()],
            'materialId' => ['name' => 'materialId', 'type' => Type::int()],
            'quantity' => ['name' => 'quantity', 'type' => Type::float()],
        ];
    }

    /**
     * @param $root
     * @param $args
     * @return \App\Models\Warehouse
     * @throws \App\Services\WarehouseManager\WarehouseManagerException
     * @throws \App\Services\MaterialManager\MaterialManagerException
     */
    public function resolve($root, $args)
    {
        $this->warehouseManager->addMaterialToWarehouse(
            $args['warehouseId'],
            $args['materialId'],
            $args['quantity']
        );

        $warehouse = $this->warehouseManager->getWarehouse($args['warehouseId']);
        return $warehouse;
    }
}