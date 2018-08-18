<?php

namespace App\GraphQL\Mutation\Warehouse;

use App\Services\WarehouseManager\WarehouseManager;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;

class WarehouseRemoveMutation extends Mutation
{
    protected $warehouseManager;

    public function __construct($attributes = [], WarehouseManager $warehouseManager)
    {
        $this->warehouseManager = $warehouseManager;
        parent::__construct($attributes);
    }

    public $attributes = [
        'name' => 'removeWarehouse'
    ];

    public function type()
    {
        return GraphQL::type('Warehouse');
    }

    public function args()
    {
        return [
            'id' => ['name' => 'id', 'type' => Type::int()]
        ];
    }

    /**
     * @param $root
     * @param $args
     * @return \App\Models\Warehouse
     * @throws \App\Services\WarehouseManager\WarehouseManagerException
     * @throws \Exception
     */
    public function resolve($root, $args)
    {
        $warehouse = $this->warehouseManager->getWarehouse($args['id']);
        $this->warehouseManager->removeWarehouse($args['id']);
        return $warehouse;
    }
}