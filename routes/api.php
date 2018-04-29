<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'API'],
    function () {
        Route::get('transactions', 'TransactionController@index');
        Route::post('transactions', 'TransactionController@store');

        Route::get('refundTransaction', 'TransactionRefundController@index');
        Route::post('refundTransaction', 'TransactionRefundController@store');
    });

