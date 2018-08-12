<?php

namespace App\GraphQL\Mutation;

use App\Services\UserManager\UserManger;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;
use App\Models\User;

class UserUpdateMutation extends Mutation
{
    protected $userManager;

    public function __construct($attributes = [], UserManger $userManager)
    {
        $this->userManager = $userManager;
        parent::__construct($attributes);
    }

    public $attributes = [
        'name' => 'updateUser'
    ];

    public function type()
    {
        return GraphQL::type('User');
    }

    public function args()
    {
        return [
            'id' => ['name' => 'id', 'type' => Type::int()],
            'name' => ['name' => 'name', 'type' => Type::string()],
            'email' => ['name' => 'email', 'type' => Type::string()],
            'role' => ['name' => 'role', 'type' => Type::int()],
            'password' => ['name' => 'password', 'type' => Type::string()]
        ];
    }

    public function resolve($root, $args)
    {
        $updatedUser = $this->userManager->getUser($args['id']);

        $this->userManager->updateUser(
            $args['id'],
            $args['email'],
            $args['name'],
            $args['role'],
            $args['password']
        );

        return $updatedUser;
    }
}