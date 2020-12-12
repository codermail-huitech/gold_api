<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerToAgentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_to_agents', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('customer_id')->unsigned()->unique();
            $table ->foreign('customer_id')->references('id')->on('users');

            $table->bigInteger('agent_id')->unsigned();
            $table ->foreign('agent_id')->references('id')->on('users');
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
        Schema::dropIfExists('customer_to_agents');
    }
}
