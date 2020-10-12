<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('order_details_id')->unsigned();
            $table ->foreign('order_details_id')->references('id')->on('order_details');

            $table->bigInteger('tag')->unsigned()->nullable(false);
            $table->double('gold')->nullable(false);
            $table->double('amount')->nullable(false);
            $table->bigInteger('quantity')->nullable(false);

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
        Schema::dropIfExists('stocks');
    }
}
