<?php

namespace App\GraphQL\Mutation\Warehouse;

use App\Services\WarehouseManager\WarehouseManager;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;

class WarehouseCreateMutation extends Mutation
{
    protected $warehouseManager;

    public function __construct($attributes = [], WarehouseManager $warehouseManager)
    {
        $this->warehouseManager = $warehouseManager;
        parent::__construct($attributes);
    }

    public $attributes = [
        'name' => 'createWarehouse'
    ];

    public function type()
    {
        return GraphQL::type('Warehouse');
    }

    public function args()
    {
        return [
            'name' => ['name' => 'name', 'type' => Type::string()],
            'address' => ['name' => 'address', 'type' => Type::string()],
            'note' => ['name' => 'note', 'type' => Type::string()],
        ];
    }

    /**
     * @param $root
     * @param $args
     * @return \App\Models\Warehouse
     * @throws \App\Services\WarehouseManager\WarehouseManagerException
     */
    public function resolve($root, $args)
    {
        $warehouseId = $this->warehouseManager->createWarehouse(
            $args['name'],
            $args['address'],
            $args['note']
        );

        $warehouse = $this->warehouseManager->getWarehouse($warehouseId);
        return $warehouse;
    }
}