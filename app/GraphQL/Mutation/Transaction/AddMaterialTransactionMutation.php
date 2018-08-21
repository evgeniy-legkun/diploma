<?php

namespace App\GraphQL\Mutation\Transaction;

use App\Services\TransactionManager\TransactionManager;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;

class AddMaterialTransactionMutation extends Mutation
{
    protected $transactionManager;

    public function __construct($attributes = [], TransactionManager $transactionManager)
    {
        $this->transactionManager = $transactionManager;
        parent::__construct($attributes);
    }

    public $attributes = [
        'name' => 'addMaterialTransaction'
    ];

    public function type()
    {
        return GraphQL::type('Transaction');
    }

    public function args()
    {
        return [
            'transactionId' => [
                'name' => 'transactionId',
                'type' => Type::int()
            ],

            'materialId' => [
                'name' => 'materialId',
                'type' => Type::int()
            ],

            'quantity' => [
                'name' => 'quantity',
                'type' => Type::float()
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
        $this->transactionManager->addMaterialsToTransaction(
            $args['transactionId'],
            $args['materialId'],
            $args['quantity']
        );

        $transaction = $this->transactionManager->getTransaction($args['transactionId']);
        return $transaction;
    }
}