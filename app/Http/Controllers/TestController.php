<?php

namespace App\Http\Controllers;

use App\Services\WarehouseManager\WarehouseManager;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(WarehouseManager $warehouseManager)
    {
        $w = $warehouseManager->getWarehouse(10);
        dd($w->materials()->first()->pivot->quantity);
        die;
    }
}
