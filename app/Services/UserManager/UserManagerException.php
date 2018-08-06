<?php

namespace App\Services\UserManager;

use App\Contracts\Services\UserManager\UserManagerExceptionInterface;

class UserManagerException extends \Exception implements UserManagerExceptionInterface
{
}