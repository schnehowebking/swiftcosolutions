<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeToAllowance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('allowances', function (Blueprint $table) {
            $table->string('type')->nullable()->after('amount');
        });
        Schema::table('commissions', function (Blueprint $table) {
            $table->string('type')->nullable()->after('amount');
        });
        Schema::table('loans', function (Blueprint $table) {
            $table->string('type')->nullable()->after('amount');
        });
        Schema::table('saturation_deductions', function (Blueprint $table) {
            $table->string('type')->nullable()->after('amount');
        });
        Schema::table('other_payments', function (Blueprint $table) {
            $table->string('type')->nullable()->after('amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('allowance', function (Blueprint $table) {
            //
        });
    }
}
