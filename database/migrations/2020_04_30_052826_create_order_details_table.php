<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_master_id')->unsigned();
            $table ->foreign('order_master_id')->references('id')->on('order_masters');

            $table->integer('price');
            $table->double('p_loss');
            $table->double('approx_gold');
            $table->integer('quantity');
            $table->double('discount')->nullable(false);

            $table->bigInteger('material_id')->unsigned();
            $table ->foreign('material_id')->references('id')->on('materials');

            $table->string('size')->nullable(true);

            $table->bigInteger('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products');

//            $table->integer('job_status')->nullable('false')->default(0);

            $table->bigInteger('status_id')->unsigned();
            $table ->foreign('status_id')->references('id')->on('status_types');
            $table ->integer('bill_created')->default(0);
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
        Schema::dropIfExists('order_details');
    }
}
