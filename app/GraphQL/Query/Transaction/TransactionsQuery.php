<?php

namespace App\GraphQL\Query\Transaction;

use App\Services\MaterialManager\MaterialManager;
use App\Services\TransactionManager\TransactionManager;
use GraphQL;
use Folklore\GraphQL\Support\Query;
use GraphQL\Type\Definition\Type;

class TransactionsQuery extends Query
{
    protected $transactionManager;

    public function __construct($attributes = [], TransactionManager $transactionManager)
    {
        $this->transactionManager = $transactionManager;
        parent::__construct($attributes);
    }

    public function type()
    {
        return Type::listOf(GraphQL::type('Transaction'));
    }

    public function args()
    {
        return [];
    }

    /**
     * @param $root
     * @param $args
     * @return mixed
     */
    public function resolve($root, $args)
    {
        return $this->transactionManager->getAllTransactions();
    }
}