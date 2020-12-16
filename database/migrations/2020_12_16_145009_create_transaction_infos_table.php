<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_infos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('transaction_type_id')->unsigned();
            $table ->foreign('transaction_type_id')->references('id')->on('transaction_types');

            $table->bigInteger('employee_id')->unsigned()->nullable(true);

            $table->bigInteger('person_id')->unsigned();
            $table ->foreign('person_id')->references('id')->on('users');

            $table->double('amount')->nullable(false);
            $table->date('transaction_date')->nullable(false);

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
        Schema::dropIfExists('transaction_infos');
    }
}
