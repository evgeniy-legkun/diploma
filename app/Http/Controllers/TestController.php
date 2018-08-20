<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Warehouse;
use App\Services\TransactionManager\TransactionManager;
use App\Services\WarehouseManager\WarehouseManager;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(TransactionManager $transactionManager)
    {
        $u = User::find(25);
        dd($u->transactions()->get());
        die;
        $t = $transactionManager->finishTransaction(1);
//        dump($t->toWarehouse->name);
        die;
    }
}
