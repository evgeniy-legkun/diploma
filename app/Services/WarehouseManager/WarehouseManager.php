<?php

namespace App\Services\WarehouseManager;

use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class WarehouseManager
 * @package App\Services\WarehouseManager
 */
class WarehouseManager
{
    /**
     * @param string $name
     * @param string $address
     * @param string $note
     * @return int
     */
    public function createWarehouse(string $name, string $address, string $note): int
    {
        $warehouse = Warehouse::create(
            [
                'name' => $name,
                'address' => $address,
                'note' => $note
            ]
        );

        return $warehouse->id;
    }

    /**
     * @param int $warehouseId
     * @param string $name
     * @param string $address
     * @param string $note
     * @throws WarehouseManagerException
     */
    public function updateWarehouse(int $warehouseId, string $name, string $address, string $note): void
    {
        $warehouse = $this->getWarehouse($warehouseId);

        $warehouse->update([
            'name' => $name,
            'address' => $address,
            'note' => $note
        ]);
    }

    /**
     * @param int $warehouseId
     * @throws WarehouseManagerException
     * @throws \Exception
     */
    public function removeWarehouse(int $warehouseId)
    {
        $warehouse = $this->getWarehouse($warehouseId);
        $warehouse->delete();
    }

    /**
     * @param int $warehouseId
     * @return Warehouse
     * @throws WarehouseManagerException
     */
    public function getWarehouse(int $warehouseId): Warehouse
    {
        $warehouse = Warehouse::find($warehouseId);

        if (null == $warehouse) {
            throw new WarehouseManagerException('Склад не був знайдений');
        }

        return $warehouse;
    }

    /**
     * @return Collection
     */
    public function getAllWarehouses(): Collection
    {
        return Warehouse::all();
    }
}