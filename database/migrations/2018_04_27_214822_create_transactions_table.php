<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->integer('transaction_id')->unsigned();
            $table->integer('store_id')->unsigned();
            $table->decimal('total_amount', 5, 2);
            $table->enum('currency', ['GBP', 'USD', 'EUR']);
            $table->dateTime('created_at');
        });

        Schema::table('transactions', function($table) {
            $table->foreign('store_id')->references('store_id')->on('stores')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
