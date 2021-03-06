<?php

namespace App\GraphQL\Query\Material;

use App\Services\MaterialManager\MaterialManager;
use GraphQL;
use Folklore\GraphQL\Support\Query;
use GraphQL\Type\Definition\Type;

class MaterialQuery extends Query
{
    protected $materialManager;

    public function __construct($attributes = [], MaterialManager $materialManager)
    {
        $this->materialManager = $materialManager;
        parent::__construct($attributes);
    }

    public function type()
    {
        return GraphQL::type('Material');
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
     * @return mixed
     * @throws \App\Services\MaterialManager\MaterialManagerException
     */
    public function resolve($root, $args)
    {
        $materials = $this->materialManager->getMaterial($args['id']);
        return $materials;
    }
}