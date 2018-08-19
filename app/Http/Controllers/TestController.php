<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use App\Services\TransactionManager\TransactionManager;
use App\Services\WarehouseManager\WarehouseManager;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(TransactionManager $transactionManager)
    {
//        $transactionManager->addMaterialsToTransaction(
//            1,
//            3,
//            1
//        );
        die;
    }
}
