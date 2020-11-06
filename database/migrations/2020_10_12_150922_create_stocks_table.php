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

            $table->bigInteger('job_master_id')->unsigned();
            $table ->foreign('job_master_id')->references('id')->on('job_masters');

            $table->bigInteger('agent_id')->unsigned()->default(2);
            $table ->foreign('agent_id')->references('id')->on('users');

            $table->string('tag')->nullable(false);
            $table->string('size')->nullable(false);
            $table->integer('material_id')->nullable(false);
            $table->double('gold')->nullable(false);
            $table->double('gross_weight')->nullable(false);
            $table->double('amount')->nullable(false);
            $table->bigInteger('quantity')->nullable(false);
            $table->integer('in_stock')->default(1);

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
