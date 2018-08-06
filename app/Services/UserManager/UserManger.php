<?php

namespace App\Services\UserManager;

use App\Contracts\Models\UserInterface;
use App\Contracts\Services\UserManager\UserManagerInterface;
use App\Models\User;

/**
 * Class UserManger
 * @package App\Services\UserManager
 */
class UserManger implements UserManagerInterface
{
    /**
     * @param string $email
     * @param string $password
     * @param string $firstName
     * @param string $lastName
     * @param string $roleName
     * @return int
     * @throws UserManagerException
     */
    public function createUser(
        string $email,
        string $password,
        string $firstName,
        string $lastName,
        string $roleName
    ): int {

        if (null != User::find(['email' => $email])) {
            throw new UserManagerException('Користувач із даним емейлом вже існує в системі');
        }

        $user = User::create(
            [
                'email' => $email. rand(1,200),
                'password' => bcrypt($password),
                'name' => $firstName .' '. $lastName,
            ]
        );

        return $user->id;
    }

    /**
     * @param int $userId
     * @param string $email
     * @param null|string $password
     * @param string $firstName
     * @param string $lastName
     * @throws UserManagerException
     */
    public function updateUser(
        int $userId,
        string $email,
        ?string $password,
        string $firstName,
        string $lastName
    ): void {

        $user = $this->getUser($userId);
        $userWithEmail = User::where(
            [
                ['id' , '<>', $userId],
                ['email', '=', $email]
            ]
        )->get();

        if (null != $userWithEmail) {
            throw new UserManagerException('Даний емейл належить іншому користувачу');
        }

        $user->update(
            [
                'email' => $email. rand(1,200),
                'password' => null == $password ? $user->password : bcrypt($password),
                'name' => $firstName .' '. $lastName,
            ]
        );
    }

    /**
     * @param int $userId
     * @throws UserManagerException
     */
    public function removeUser(int $userId): void
    {
        $user = $this->getUser($userId);
        $user->delete();
    }

    /**
     * @param int $userId
     * @param string $roleName
     */
    public function updateUserRole(int $userId, string $roleName): void
    {
        // TODO: Implement updateUserRole() method.
    }

    /**
     * @param int $userId
     * @return UserInterface
     * @throws UserManagerException
     */
    public function getUser(int $userId): UserInterface
    {
        $user = User::find($userId);

        if (null === $user) {
            throw new UserManagerException('Користувач не знайдений');
        }

        return $user;
    }
}