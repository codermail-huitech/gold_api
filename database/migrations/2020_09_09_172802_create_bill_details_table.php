<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bill_details', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('bill_master_id')->unsigned();
            $table ->foreign('bill_master_id')->references('id')->on('bill_masters');

//            $table->bigInteger('order_master_id')->unsigned();
//            $table ->foreign('order_master_id')->references('id')->on('order_masters');

            $table->bigInteger('job_master_id')->unsigned()->nullable(true);
//            $table ->foreign('job_master_id')->references('id')->on('job_masters');

            $table->string('tag')->nullable(true);

            $table->string('model_number')->nullable(false);
            $table->string('size')->nullable(false);
            $table->double('gross_weight')->nullable(false);
            $table->integer('material_id')->nullable(false);
            $table->double('ginnie')->nullable(false);
            $table->double('rate')->nullable(false);
            $table->double('pure_gold')->nullable(false);
            $table->integer('quantity')->nullable(false);
//            $table->double('LC')->nullable(false);
            $table->double('mv')->nullable(false);



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
        Schema::dropIfExists('bill_details');
    }
}
