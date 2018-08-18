<?php

namespace App\GraphQL\Query\Material;

use App\Services\MaterialManager\MaterialManager;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;

class MaterialsQuery extends Query
{
    protected $materialManager;

    public function __construct($attributes = [], MaterialManager $materialManager)
    {
        $this->materialManager = $materialManager;
        parent::__construct($attributes);
    }

    public function type()
    {
        return Type::listOf(GraphQL::type('Material'));
    }

    public function args()
    {
        return [];
    }

    public function resolve($root, $args)
    {
        $materials = $this->materialManager->getMaterials();
        return $materials;
    }
}