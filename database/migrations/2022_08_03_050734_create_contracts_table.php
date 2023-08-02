<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'contracts', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->string('subject')->nullable();
            $table->integer('employee_name');
            $table->string('value')->nullable();
            $table->integer('type');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('notes')->nullable();
            $table->string('status')->default('pending');
            $table->longText('description')->nullable();
            $table->longText('contract_description')->nullable();
            $table->longText('employee_signature')->nullable();
            $table->longText('company_signature')->nullable();
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
        Schema::dropIfExists('contracts');
    }
}
