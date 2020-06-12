<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Model\Product;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('model_number',40)->unique();
            $table->string('product_name',110);


            $table->bigInteger('product_category_id')->unsigned();
            $table ->foreign('product_category_id')->references('id')->on('product_categories');

            $table->bigInteger('price_code_id')->unsigned();
            $table ->foreign('price_code_id')->references('id')->on('price_codes');



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
        Schema::dropIfExists('products');
    }
}
