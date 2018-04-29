<?php 

namespace App\Services;

use App\Transaction;

class TransactionService
{
    private $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function save($transaction) {
        return $this->transaction->create($transaction);        
    }

    public function displayAll() {
        return Transaction::all();
    }
}