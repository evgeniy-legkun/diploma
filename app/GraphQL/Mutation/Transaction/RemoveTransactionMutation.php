<?php

namespace App\GraphQL\Mutation\Transaction;

use App\Services\MaterialManager\MaterialManager;
use App\Services\TransactionManager\TransactionManager;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;

class RemoveTransactionMutation extends Mutation
{
    protected $transactionManager;

    public function __construct($attributes = [], TransactionManager $transactionManager)
    {
        $this->transactionManager = $transactionManager;
        parent::__construct($attributes);
    }

    public $attributes = [
        'name' => 'removeTransaction'
    ];

    public function type()
    {
        return GraphQL::type('Transaction');
    }

    public function args()
    {
        return [
            'id' => ['name' => 'id', 'type' => Type::int()]
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
        $this->transactionManager->removeTransaction($args['id']);
        $transaction = $this->transactionManager->getTransaction($args['id']);
        return $transaction;
    }
}