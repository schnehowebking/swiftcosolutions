<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeAmountTypeSize extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'account_lists', function (Blueprint $table){
            $table->float('initial_balance', 25, 2)->default(0.00)->change();
        }
        );

        Schema::table(
            'assets', function (Blueprint $table){
            $table->float('amount', 25, 2)->default(0.00)->change();
        }
        );

        Schema::table(
            'employees', function (Blueprint $table){
            $table->float('salary', 25, 2)->default(0.00)->change();
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
        Schema::table(
            'account_lists', function (Blueprint $table){
            $table->dropColumn('initial_balance');
        }
        );

        Schema::table(
            'assets', function (Blueprint $table){
            $table->dropColumn('amount');
        }
        );

        Schema::table(
            'employees', function (Blueprint $table){
            $table->dropColumn('salary');
        }
        );

    }
}
