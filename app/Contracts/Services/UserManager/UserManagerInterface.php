<?php

namespace App\Contracts\Services\UserManager;

use App\Contracts\Models\UserInterface;

interface UserManagerInterface
{
    public function getUser(int $userId): UserInterface;

    public function createUser(string $email, string $password, string $firstName, string $lastName, string $roleName): int;

    public function updateUser(int $userId, string $email, ?string $password, string $firstName, string $lastName): void;

    public function removeUser(int $userId): void;

    public function updateUserRole(int $userId, string $roleName): void;
}