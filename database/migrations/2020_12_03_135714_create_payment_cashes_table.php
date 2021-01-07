<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentCashesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_cashes', function (Blueprint $table) {
            $table->id();

            $table->String('transaction_id', 100)->nullable(false);

            $table->bigInteger('person_id')->unsigned();
            $table ->foreign('person_id')->references('id')->on('users');

            $table->bigInteger('agent_id')->unsigned();
            $table ->foreign('agent_id')->references('id')->on('users');

            $table->bigInteger('user_id')->unsigned();
            $table ->foreign('user_id')->references('id')->on('users');

            //1 for cash 2 for cheque
            $table->integer('payment_mode')->nullable(false);

            $table->double('cash_received')->nullable(false);
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
        Schema::dropIfExists('payment_cashes');
    }
}
