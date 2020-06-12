<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rates', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('price_code_id')->unsigned();
            $table ->foreign('price_code_id')->references('id')->on('price_codes');

            $table->integer('price');
            $table->double('p_loss');


            $table->bigInteger('customer_category_id')->unsigned();
            $table ->foreign('customer_category_id')->references('id')->on('customer_categories');

            $table->tinyInteger('inforced')->default(1);
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
        Schema::dropIfExists('rates');
    }
}
