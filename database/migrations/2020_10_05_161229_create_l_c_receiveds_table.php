<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLCReceivedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('l_c_receiveds', function (Blueprint $table) {
            $table->id();

            $table->date('received_date')->nullable(false);

            $table->bigInteger('customer_id')->unsigned();
            $table ->foreign('customer_id')->references('id')->on('users');

            $table->bigInteger('agent_id')->unsigned();
            $table ->foreign('agent_id')->references('id')->on('users');

            $table->bigInteger('bill_master_id')->unsigned();
            $table ->foreign('bill_master_id')->references('id')->on('bill_masters');


            $table->double('LC_received')->default(0);

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
        Schema::dropIfExists('l_c_receiveds');
    }
}
