<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Services\TransactionService;
use App\Http\Requests\TransactionValidation;

class TransactionController extends Controller
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
     * Store a newly created resource in storage if successful, 
     * otherwise return appropriate status code.
     *
     * @param  App\Http\Requests\TransactionValidation
     * @return \Illuminate\Http\Response
     */
    public function store(TransactionValidation $request)
    {
        $responseStatus = $this->transactionService->save($request->all());

        switch ($responseStatus) {
            case Response::HTTP_CREATED:
                return response()->json(
                    'Transaction Created',
                    Response::HTTP_CREATED
                );
                break;

            case Response::HTTP_CONFLICT:
                return response()->json(
                    'Transaction already exist!',
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
    }
}
