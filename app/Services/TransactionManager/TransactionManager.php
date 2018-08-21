<?php

namespace App\Services\TransactionManager;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Warehouse;
use App\Services\MaterialManager\MaterialManager;
use App\Services\UserManager\UserManger;
use App\Services\WarehouseManager\WarehouseManager;
use App\Services\WarehouseManager\WarehouseManagerException;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class TransactionManager
 * @package App\Services\TransactionManager
 */
class TransactionManager
{
    /**
     * @var MaterialManager
     */
    protected $materialManager;

    /**
     * @var UserManger
     */
    protected $userManager;

    /**
     * @var WarehouseManager
     */
    protected $warehouseManager;

    /**
     * TransactionManager constructor.
     * @param MaterialManager $materialManager
     * @param UserManger $userManger
     * @param WarehouseManager $warehouseManager
     */
    public function __construct(
        MaterialManager $materialManager,
        UserManger $userManger,
        WarehouseManager $warehouseManager
    ) {
        $this->warehouseManager = $warehouseManager;
        $this->materialManager = $materialManager;
        $this->userManager = $userManger;
    }

    /**
     * @param int $fromWarehouseId
     * @param int $toWarehouseId
     * @param int $userId
     * @return int
     * @throws TransactionManagerException
     * @throws WarehouseManagerException
     * @throws \App\Services\UserManager\UserManagerException
     */
    public function createTransaction(
        int $fromWarehouseId,
        int $toWarehouseId,
        int $userId
    ): int {

        if ($fromWarehouseId == $toWarehouseId) {
            throw new TransactionManagerException(
                'Неможливо створити транзакцію між одним і тим же складом'
            );
        }

        $courier = $this->userManager->getUser($userId);

        if ($courier->role != User::ROLE_COURIER) {
            throw new TransactionManagerException(
                'Тільки курєри можуть перевозити матеріали'
            );
        }

        $fromWarehouse = $this->warehouseManager->getWarehouse($fromWarehouseId);
        $toWarehouse = $this->warehouseManager->getWarehouse($toWarehouseId);

        $transaction = Transaction::create(
            [
                'from_warehouse_id' => $fromWarehouse->id,
                'to_warehouse_id' => $toWarehouse->id,
                'user_id' => $courier->id,
                'status_code' => Transaction::CREATED_STATUS
            ]
        );

        return $transaction->id;
    }

    /**
     * @param $transactionId
     * @return Transaction
     * @throws TransactionManagerException
     */
    public function getTransaction($transactionId): Transaction
    {
        $transaction = Transaction::find($transactionId);

        if (null == $transaction) {
            throw new TransactionManagerException(
                'Транзакція не знайдена'
            );
        }

        return $transaction;
    }

    /**
     * @param int $transactionId
     * @param int $materialId
     * @param float $quantity
     * @throws TransactionManagerException
     * @throws \App\Services\MaterialManager\MaterialManagerException
     * @throws WarehouseManagerException
     */
    public function addMaterialsToTransaction(
        int $transactionId,
        int $materialId,
        float $quantity
    ): void {
        $transaction = $this->getTransaction($transactionId);
        $warehouse = $transaction->fromWarehouse;
        $material = $warehouse->getMaterial($materialId);

        $this->warehouseManager->removeMaterialFromWarehouse(
            $warehouse->id,
            $material->id,
            $quantity
        );

        $transaction->materials()->attach(
            $material->id,
            ['quantity' => $quantity]
        );
    }

    /**
     * @param int $transactionId
     * @throws TransactionManagerException
     * @throws WarehouseManagerException
     * @throws \App\Services\MaterialManager\MaterialManagerException
     */
    public function cancelTransaction(int $transactionId): void
    {
        $transaction = $this->getTransaction($transactionId);

        if ($transaction->status_code != Transaction::CREATED_STATUS) {
            throw new TransactionManagerException(
                'Неможливо відмінити замовлення в поточному статусі'
            );
        }

        $warehouse = $transaction->fromWarehouse;

        foreach ($transaction->materials()->get() as $transactionMaterial) {
            $this->warehouseManager->addMaterialToWarehouse(
                $warehouse->id,
                $transactionMaterial->id,
                $transactionMaterial->pivot->quantity
            );
        }

        $transaction->status_code = Transaction::CANCELED_STATUS;
        $transaction->save();
    }

    /**
     * @param int $transactionId
     * @throws TransactionManagerException
     */
    public function acceptTransaction(int $transactionId): void
    {
        $transaction = $this->getTransaction($transactionId);

        if ($transaction->status_code != Transaction::CREATED_STATUS) {
            throw new TransactionManagerException(
                'Неможливо прийняти замовлення в поточному статусі'
            );
        }

        $transaction->status_code = Transaction::ACCEPTED_STATUS;
        $transaction->save();
    }

    /**
     * @param int $transactionId
     * @throws TransactionManagerException
     * @throws WarehouseManagerException
     * @throws \App\Services\MaterialManager\MaterialManagerException
     */
    public function finishTransaction(int $transactionId): void
    {
        $transaction = $this->getTransaction($transactionId);

        if ($transaction->status_code != Transaction::ACCEPTED_STATUS) {
            throw new TransactionManagerException(
                'Неможливо завершити замовлення в поточному статусі'
            );
        }

        $warehouse = $transaction->toWarehouse;

        foreach ($transaction->materials()->get() as $transactionMaterial) {
            $this->warehouseManager->addMaterialToWarehouse(
                $warehouse->id,
                $transactionMaterial->id,
                $transactionMaterial->pivot->quantity
            );
        }

        $transaction->status_code = Transaction::DELIVERED_STATUS;
        $transaction->save();
    }

    /**
     * @param int $transactionId
     * @throws TransactionManagerException
     * @throws \Exception
     */
    public function removeTransaction(int $transactionId): void
    {
        $transaction = $this->getTransaction($transactionId);
        $transaction->delete();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAllTransactions(): Collection
    {
        return Transaction::all();
    }
}