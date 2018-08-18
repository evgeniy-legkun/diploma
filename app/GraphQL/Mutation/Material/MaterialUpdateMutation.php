<?php

namespace App\GraphQL\Mutation\Material;

use App\Services\MaterialManager\MaterialManager;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;

class MaterialUpdateMutation extends Mutation
{
    protected $materialManager;

    public function __construct($attributes = [], MaterialManager $materialManager)
    {
        $this->materialManager = $materialManager;
        parent::__construct($attributes);
    }

    public $attributes = [
        'name' => 'updateMaterial'
    ];

    public function type()
    {
        return GraphQL::type('Material');
    }

    public function args()
    {
        return [
            'id' => ['name' => 'id', 'type' => Type::int()],
            'name' => ['name' => 'name', 'type' => Type::string()],
            'unit' => ['name' => 'unit', 'type' => Type::int()],
        ];
    }

    /**
     * @param $root
     * @param $args
     * @return mixed
     * @throws \App\Services\MaterialManager\MaterialManagerException
     */
    public function resolve($root, $args)
    {
        $material = $this->materialManager->getMaterial($args['id']);

        $this->materialManager->updateMaterial(
            $args['id'],
            $args['name'],
            $args['unit']
        );

        return $material;
    }
}