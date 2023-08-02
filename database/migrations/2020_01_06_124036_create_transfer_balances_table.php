<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransferBalancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'transfer_balances', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->integer('from_account_id');
            $table->integer('to_account_id');
            $table->date('date');
            $table->integer('amount');
            $table->integer('payment_type_id');
            $table->string('referal_id')->nullable();
            $table->text('description')->nullable();
            $table->integer('created_by');
            $table->timestamps();
        }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transfer_balances');
    }
}
