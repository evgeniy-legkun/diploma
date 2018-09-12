<?php

namespace App\GraphQL\Mutation\Warehouse;

use App\Services\WarehouseManager\WarehouseManager;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;

class WarehouseUpdateMutation extends Mutation
{
    protected $warehouseManager;

    public function __construct($attributes = [], WarehouseManager $warehouseManager)
    {
        $this->warehouseManager = $warehouseManager;
        parent::__construct($attributes);
    }

    public $attributes = [
        'name' => 'updateWarehouse'
    ];

    public function type()
    {
        return GraphQL::type('Warehouse');
    }

    public function args()
    {
        return [
            'id' => ['name' => 'id', 'type' => Type::int()],
            'name' => ['name' => 'name', 'type' => Type::string()],
            'address' => ['name' => 'address', 'type' => Type::string()],
            'lat_point' => ['name' => 'lat_point', 'type' => Type::string()],
            'lng_point' => ['name' => 'lng_point', 'type' => Type::string()],
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
        $this->warehouseManager->updateWarehouse(
            $args['id'],
            $args['name'],
            $args['address'],
            $args['lat_point'],
            $args['lng_point'],
            $args['note']
        );

        $warehouse = $this->warehouseManager->getWarehouse($args['id']);
        return $warehouse;
    }
}