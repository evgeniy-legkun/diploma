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
     * @param string $name
     * @param string $roleName
     * @return int
     * @throws UserManagerException
     */
    public function createUser(
        string $email,
        string $name,
        string $password,
        string $roleName
    ): int {


        if (0 < User::where(['email' => $email])->count()) {
            throw new UserManagerException('Користувач із даним емейлом вже існує в системі');
        }

        $user = User::create(
            [
                'email' => $email,
                'password' => bcrypt($password),
                'name' => $name,
            ]
        );

        return $user->id;
    }

    /**
     * @param int $userId
     * @param string $email
     * @param string $name
     * @throws UserManagerException
     */
    public function updateUser(
        int $userId,
        string $email,
        string $name
    ): void {

        $user = $this->getUser($userId);
        $userWithEmail = User::where(
            [
                ['id' , '<>', $userId],
                ['email', '=', $email]
            ]
        )->first();

        if (null != $userWithEmail) {
            throw new UserManagerException('Даний емейл належить іншому користувачу');
        }

        $user->update(
            [
                'email' => $email,
                'name' => $name,
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