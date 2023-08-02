<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'expenses', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->integer('account_id');
            $table->integer('amount');
            $table->date('date');
            $table->integer('expense_category_id');
            $table->integer('payee_id');
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
        Schema::dropIfExists('expenses');
    }
}
