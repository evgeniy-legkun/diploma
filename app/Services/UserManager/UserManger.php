<?php

namespace App\Services\UserManager;

use App\Models\User;

/**
 * Class UserManger
 * @package App\Services\UserManager
 */
class UserManger
{
    /**
     * @param string $email
     * @param string $name
     * @param string $password
     * @param int $role
     * @return int
     * @throws UserManagerException
     */
    public function createUser(
        string $email,
        string $name,
        string $password,
        int $role
    ): int {


        if (0 < User::where(['email' => $email])->count()) {
            throw new UserManagerException('Користувач із даним емейлом вже існує в системі');
        }

        $user = User::create(
            [
                'email' => $email,
                'password' => bcrypt($password),
                'name' => $name,
                'role' => $role
            ]
        );

        return $user->id;
    }

    /**
     * @param int $userId
     * @param string $email
     * @param string $name
     * @param int $role
     * @param string $password
     * @throws UserManagerException
     */
    public function updateUser(
        int $userId,
        string $email,
        string $name,
        int $role,
        string $password
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
                'role' => $role,
                'password' => bcrypt($password)
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
    public function getUser(int $userId): User
    {
        $user = User::find($userId);

        if (null === $user) {
            throw new UserManagerException('Користувач не знайдений');
        }

        return $user;
    }
}