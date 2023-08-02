<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTicketCreatedInTickets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'tickets', function (Blueprint $table){
            $table->integer('ticket_created')->default(0)->after('ticket_code');
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
            'tickets', function (Blueprint $table){
            $table->dropColumn('ticket_created');
        }
        );
    }
}
