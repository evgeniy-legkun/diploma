<?php

namespace App\GraphQL\Query\Warehouse;

use App\Services\WarehouseManager\WarehouseManager;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;

class WarehousesQuery extends Query
{

    protected $warehouseManager;

    public function __construct($attributes = [], WarehouseManager $warehouseManager)
    {
        $this->warehouseManager = $warehouseManager;
        parent::__construct($attributes);
    }

    public function type()
    {
        return Type::listOf(GraphQL::type('Warehouse'));
    }

    public function args()
    {
        return [];
    }


    public function resolve($root, $args)
    {
        $warehouses = $this->warehouseManager->getAllWarehouses();
        return $warehouses;
    }
}