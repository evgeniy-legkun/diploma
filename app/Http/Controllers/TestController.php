<?php

namespace App\Http\Controllers;

use App\Services\WarehouseManager\WarehouseManager;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(WarehouseManager $warehouseManager)
    {
        $warehouseManager->removeMaterialFromWarehouse(3,3,25);
        die;
    }
}
