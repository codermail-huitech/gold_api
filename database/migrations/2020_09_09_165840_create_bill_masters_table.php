<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bill_masters', function (Blueprint $table) {
            $table->id();

            $table->string('bill_number')->nullable(false);

            $table->date('bill_date')->nullable(false);

            $table->bigInteger('order_master_id')->unsigned()->nullable(true);
//            $table ->foreign('order_master_id')->references('id')->on('order_masters');

//            $table->bigInteger('karigarh_id')->unsigned();
//            $table ->foreign('karigarh_id')->references('id')->on('users');

            $table->bigInteger('customer_id')->unsigned();
            $table ->foreign('customer_id')->references('id')->on('users');

            $table->bigInteger('agent_id')->unsigned();
            $table ->foreign('agent_id')->references('id')->on('users');

            $table->double('discount')->default(0);

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
        Schema::dropIfExists('bill_masters');
    }
}
