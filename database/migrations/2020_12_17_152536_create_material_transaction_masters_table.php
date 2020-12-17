<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialTransactionMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_transaction_masters', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('transaction_type_id')->unsigned();
            $table ->foreign('transaction_type_id')->references('id')->on('transaction_types');

            $table->bigInteger('material_id')->unsigned();
            $table ->foreign('material_id')->references('id')->on('materials');

            $table->string('transaction_comment')->nullable(true);


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
        Schema::dropIfExists('material_transaction_masters');
    }
}
