<?php 

namespace App\Services;

use App\Transaction;
use Carbon\Carbon;
use Exception;
use Log;
use Illuminate\Http\Response;

class TransactionService
{
    /**
     * Instance ot transaction class.
     */
    private $transaction;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Create a transaction if it already doesn't exist.
     *
     * @return boolean
     */
    public function save($transaction)
    {
        if ($this->transactionById($transaction['transaction_id'])) {
            Log::warning('Error: Transaction already exists!');
            return Response::HTTP_CONFLICT;
        }

        $this->transaction->create($transaction);

        return Response::HTTP_CREATED;
    }    

    /**
     * Find the transaction and if it exist refund the transaction.
     *
     * @return boolean
     */
    public function refund($transactionId)
    {
        try {
            $numberOfTransactions = $this->transaction->whereTransactionId($transactionId)->count();

            if ($numberOfTransactions > 1) {
                return Response::HTTP_CONFLICT;
            }

            $transaction = $this->transactionById($transactionId);                            

            $amount = $transaction->total_amount;

            $refundTransaction = $transaction->replicate();
            $refundTransaction->total_amount = -1 * abs($amount);
            $refundTransaction->created_at = Carbon::parse(now());

            $refundTransaction->save();

            return Response::HTTP_CREATED;
        } catch (Exception $e) {
            Log::warning('Error: Transaction Refund Failed. Message: ' . $e->getMessage());
            return Response::HTTP_UNPROCESSABLE_ENTITY;
        } 
    }

    /**
     * Get transaction by transaction id.     
     */
    public function transactionById($transactionId)
    {
        return $this->transaction->whereTransactionId($transactionId)->first();
    }    
}
