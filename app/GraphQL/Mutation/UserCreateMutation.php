<?php

namespace App\GraphQL\Mutation;

use App\Contracts\Services\UserManager\UserManagerInterface;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;
use App\Models\User;

class UserCreateMutation extends Mutation
{
    protected $userManager;

    public function __construct($attributes = [], UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
        parent::__construct($attributes);
    }

    public $attributes = [
        'name' => 'createUser'
    ];

    public function type()
    {
        return GraphQL::type('User');
    }

    public function args()
    {
        return [
            'name' => ['name' => 'name', 'type' => Type::string()],
            'email' => ['name' => 'email', 'type' => Type::string()],
            'password' => ['name' => 'password', 'type' => Type::string()],
            'role' => ['name' => 'role', 'type' => Type::string()]
        ];
    }

    public function resolve($root, $args)
    {
        $userId = $this->userManager->createUser(
            $args['email'],
            $args['name'],
            $args['password'],
            $args['role']
        );

        $createdUser = $this->userManager->getUser($userId);
        return $createdUser;
    }
}