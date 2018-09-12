<?php

namespace App\Services\WarehouseManager;

use App\Models\Warehouse;
use App\Services\MaterialManager\MaterialManager;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class WarehouseManager
 * @package App\Services\WarehouseManager
 */
class WarehouseManager
{
    /**
     * @var MaterialManager
     */
    protected $materialManager;

    /**
     * WarehouseManager constructor.
     * @param MaterialManager $materialManager
     */
    public function __construct(MaterialManager $materialManager)
    {
        $this->materialManager = $materialManager;
    }

    /**
     * @param string $name
     * @param string $address
     * @param string $lat_point
     * @param string $lng_point
     * @param string $note
     * @return int
     */
    public function createWarehouse(string $name, string $address, string $lat_point, string $lng_point, string $note): int
    {
        $warehouse = Warehouse::create(
            [
                'name' => $name,
                'address' => $address,
                'lat_point' => $lat_point,
                'lng_point' => $lng_point,
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
    public function updateWarehouse(int $warehouseId, string $name, string $address, string $lat_point, string $lng_point, string $note): void
    {
        $warehouse = $this->getWarehouse($warehouseId);

        $warehouse->update([
            'name' => $name,
            'address' => $address,
            'lat_point' => $lat_point,
            'lng_point' => $lng_point,
            'note' => $note
        ]);
    }

    /**
     * @param int $warehouseId
     * @throws WarehouseManagerException
     * @throws \Exception
     */
    public function removeWarehouse(int $warehouseId): void
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
            throw new WarehouseManagerException('Склад не знайдений');
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

    /**
     * @param int $warehouseId
     * @param int $materialId
     * @param float $quantity
     * @throws WarehouseManagerException
     * @throws \App\Services\MaterialManager\MaterialManagerException
     */
    public function addMaterialToWarehouse(
        int $warehouseId,
        int $materialId,
        float $quantity
    ): void {
        $material = $this->materialManager->getMaterial($materialId);
        $warehouse = $this->getWarehouse($warehouseId);
        $warehouseMaterials = [];

        foreach ($warehouse->materials()->get() as $warehouseMaterial) {
            $warehouseMaterials[$warehouseMaterial->id] = [
                'quantity' => $warehouseMaterial->pivot->quantity
            ];
        }

        if (!key_exists($material->id, $warehouseMaterials)) {
            $warehouseMaterials[$material->id] = ['quantity' => 0];
        }

        $warehouseMaterials[$material->id]['quantity'] += $quantity;
        $warehouse->materials()->sync($warehouseMaterials);
    }

    /**
     * @param int $warehouseId
     * @param int $materialId
     * @param float $quantity
     * @throws WarehouseManagerException
     * @throws \App\Services\MaterialManager\MaterialManagerException
     */
    public function removeMaterialFromWarehouse(
        int $warehouseId,
        int $materialId,
        float $quantity
    ): void {

        $material = $this->materialManager->getMaterial($materialId);
        $warehouse = $this->getWarehouse($warehouseId);
        $warehouseMaterials = [];

        foreach ($warehouse->materials()->get() as $warehouseMaterial) {
            $warehouseMaterials[$warehouseMaterial->id] = [
                'quantity' => $warehouseMaterial->pivot->quantity
            ];
        }

        if (!key_exists($material->id, $warehouseMaterials)) {
            $warehouseMaterials[$material->id] = ['quantity' => 0];
        }

        if ($warehouseMaterials[$material->id]['quantity'] - $quantity < 0) {
            throw new WarehouseManagerException(
                'Не можливо видалити більше матеріалу ніж є на складі'
            );
        } elseif ($warehouseMaterials[$material->id]['quantity'] - $quantity > 0) {
            $warehouseMaterials[$material->id]['quantity'] -= $quantity;
        } else {
            unset($warehouseMaterials[$material->id]);
        }

        $warehouse->materials()->sync($warehouseMaterials);
    }
}