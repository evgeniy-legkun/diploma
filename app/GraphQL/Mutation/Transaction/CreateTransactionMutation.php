<?php

namespace App\GraphQL\Mutation\Transaction;

use App\Services\MaterialManager\MaterialManager;
use App\Services\TransactionManager\TransactionManager;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;

class CreateTransactionMutation extends Mutation
{
    protected $transactionManager;

    public function __construct($attributes = [], TransactionManager $transactionManager)
    {
        $this->transactionManager = $transactionManager;
        parent::__construct($attributes);
    }

    public $attributes = [
        'name' => 'createTransaction'
    ];

    public function type()
    {
        return GraphQL::type('Transaction');
    }

    public function args()
    {
        return [
            'fromWarehouseId' => [
                'name' => 'fromWarehouseId',
                'type' => Type::int()
            ],

            'toWarehouseId' => [
                'name' => 'toWarehouseId',
                'type' => Type::int()
            ],

            'courierId' => [
                'name' => 'courierId',
                'type' => Type::int()
            ],
        ];
    }

    /**
     * @param $root
     * @param $args
     * @return \App\Models\Transaction
     * @throws \App\Services\TransactionManager\TransactionManagerException
     * @throws \Exception
     */
    public function resolve($root, $args)
    {
        $transactionId = $this->transactionManager->createTransaction(
            $args['fromWarehouseId'],
            $args['toWarehouseId'],
            $args['courierId']
        );

        $transaction = $this->transactionManager->getTransaction($transactionId);
        return $transaction;
    }
}