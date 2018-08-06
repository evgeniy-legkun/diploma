<?php

namespace App\Http\Controllers;

use App\Contracts\Services\UserManager\UserManagerInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function testUser(Request $request, UserManagerInterface $userManager): int
    {

    }
}
