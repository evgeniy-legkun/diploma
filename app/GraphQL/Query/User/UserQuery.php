<?php

namespace App\GraphQL\Query\User;

use App\Services\UserManager\UserManger;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use App\Models\User;

class UserQuery extends Query
{

    protected $userManager;

    public function __construct($attributes = [], UserManger $userManager)
    {
        $this->userManager = $userManager;
        parent::__construct($attributes);
    }

    protected $attributes = [
        'name' => 'user'
    ];

    public function type()
    {
        return GraphQL::type('User');
    }

    public function args()
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::int()
            ]
        ];
    }

    public function resolve($root, $args)
    {
        $user = $this->userManager->getUser($args['id']);
        return $user;
    }
}