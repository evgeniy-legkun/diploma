<?php

namespace App\GraphQL\Mutation\Material;

use App\Services\MaterialManager\MaterialManager;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;

class MaterialCreateMutation extends Mutation
{
    protected $materialManager;

    public function __construct($attributes = [], MaterialManager $materialManager)
    {
        $this->materialManager = $materialManager;
        parent::__construct($attributes);
    }

    public $attributes = [
        'name' => 'createMaterial'
    ];

    public function type()
    {
        return GraphQL::type('Material');
    }

    public function args()
    {
        return [
            'name' => ['name' => 'name', 'type' => Type::string()],
            'unit' => ['name' => 'unit', 'type' => Type::int()],
        ];
    }

    public function resolve($root, $args)
    {
        $material = $this->materialManager->createMaterial(
            $args['name'],
            $args['unit']
        );

        return $material;
    }
}