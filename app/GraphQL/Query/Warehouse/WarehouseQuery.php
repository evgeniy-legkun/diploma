<?php

namespace App\GraphQL\Query\Warehouse;

use App\Services\WarehouseManager\WarehouseManager;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;

class WarehouseQuery extends Query
{

    protected $warehouseManager;

    public function __construct($attributes = [], WarehouseManager $warehouseManager)
    {
        $this->warehouseManager = $warehouseManager;
        parent::__construct($attributes);
    }

    public function type()
    {
        return GraphQL::type('Warehouse');
    }

    public function args()
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::int()
            ],
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
        $warehouses = $this->warehouseManager->getWarehouse($args['id']);
        return $warehouses;
    }
}