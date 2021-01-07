<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentGoldTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_gold', function (Blueprint $table) {
            $table->id();

            $table->String('transaction_id', 100)->nullable(false);

            $table->bigInteger('person_id')->unsigned();
            $table ->foreign('person_id')->references('id')->on('users');

            $table->bigInteger('agent_id')->unsigned();
            $table ->foreign('agent_id')->references('id')->on('users');

            $table->bigInteger('user_id')->unsigned();
            $table ->foreign('user_id')->references('id')->on('users');

            $table->double('gold_received')->nullable(false);

            $table->date('received_date')->nullable(false);

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
        Schema::dropIfExists('payment_gold');
    }
}
