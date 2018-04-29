<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Services\TransactionService;
use App\Http\Requests\TransactionValidation;

class TransactionRefundController extends Controller
{
    /**
     * Instance ot transaction service class.
     */
    private $transactionService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\TransactionValidation
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $responseStatus = $this->transactionService->refund($request->transaction_id);

        switch ($responseStatus) {
            case Response::HTTP_CREATED:
                return response()->json(
                    'Transaction Refunded.',
                    Response::HTTP_CREATED
                );
                break;

            case Response::HTTP_CONFLICT:
                return response()->json(
                    'Unable to refund transaction!',
                    Response::HTTP_CONFLICT
                );
                break;
            
            default:
                return response()->json(
                    'Unable to process transaction!',
                    Response::HTTP_UNPROCESSABLE_ENTITY
                );
                break;
        }

        // return response()->json(
        //         $this->transactionService->refund($request->transaction_id),
        //         409
        //     );

        // if (!$this->transactionService->refund($request->transaction_id)) {
        //     return response()->json(
        //         'Unable to refund transaction.',
        //         409
        //     );            
        // }

        // return response()->json(
        //     'Transaction Refunded',
        //     201
        // );
    }    
}
