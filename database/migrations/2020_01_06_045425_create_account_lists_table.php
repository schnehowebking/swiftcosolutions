<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_lists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('account_name');
            $table->integer('initial_balance');
            $table->string('account_number');
            $table->string('branch_code');
            $table->string('bank_branch');
            $table->string('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_lists');
    }
}
