<?php

namespace App\GraphQL\Mutation;

use App\Contracts\Services\UserManager\UserManagerInterface;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;
use App\Models\User;

class UserRemoveMutation extends Mutation
{
    protected $userManager;

    public function __construct($attributes = [], UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
        parent::__construct($attributes);
    }

    public $attributes = [
        'name' => 'removeUser'
    ];

    public function type()
    {
        return GraphQL::type('User');
    }

    public function args()
    {
        return [
            'id' => ['name' => 'id', 'type' => Type::int()]
        ];
    }

    public function resolve($root, $args)
    {
        $user = $this->userManager->getUser($args['id']);
        $this->userManager->removeUser($args['id']);
        return $user;
    }
}