<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialTransactionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_transaction_details', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('transaction_masters_id')->unsigned();
            $table ->foreign('transaction_masters_id')->references('id')->on('material_transaction_masters');

            $table->bigInteger('employee_id')->unsigned()->nullable(false);
            $table->tinyInteger('transaction_value')->nullable(false);
            $table->double('quantity')->nullable(false);

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
        Schema::dropIfExists('material_transaction_details');
    }
}
