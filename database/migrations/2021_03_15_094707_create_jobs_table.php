<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'jobs', function (Blueprint $table){
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('requirement')->nullable();
            $table->integer('branch')->default(0);
            $table->integer('category')->default(0);
            $table->text('skill')->nullable();
            $table->integer('position')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('status')->nullable();
            $table->string('applicant')->nullable();
            $table->string('visibility')->nullable();
            $table->string('code')->nullable();
            $table->string('custom_question')->nullable();
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
        Schema::dropIfExists('jobs');
    }
}
