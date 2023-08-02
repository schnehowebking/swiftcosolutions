<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoalTrackingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'goal_trackings', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->integer('branch');
            $table->integer('goal_type');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('subject')->nullable();
            $table->string('target_achievement')->nullable();
            $table->text('description')->nullable();
            $table->integer('status')->default(0);
            $table->integer('progress')->default(0);
            $table->integer('created_by')->default(0);
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
        Schema::dropIfExists('goal_trackings');
    }
}
