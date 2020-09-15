<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('material_name',110)->nullable(false);
            $table->bigInteger('material_category_id')->unsigned();
            $table ->foreign('material_category_id')->references('id')->on('material_categories');
            $table->integer('gold')->nullable(false);
            $table->integer('silver')->nullable(false);

            $table->tinyInteger('is_order_material')->default(0);
            $table->tinyInteger('is_main_production_material')->default(0);
            $table->tinyInteger('is_base_material')->default(0);
            $table->bigInteger('main_material_id')->nullable(true);
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
        Schema::dropIfExists('materials');
    }
}
