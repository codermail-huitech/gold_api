<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_masters', function (Blueprint $table) {
            $table->id();
            $table->string('job_number')->nullable(false);

            $table->date('date')->nullable(false);

            $table->bigInteger('karigarh_id')->unsigned();
            $table ->foreign('karigarh_id')->references('id')->on('users');

            $table->bigInteger('order_details_id')->unsigned();
            $table ->foreign('order_details_id')->references('id')->on('order_details');

            $table ->double('gross_weight')->default(0);
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
        Schema::dropIfExists('job_masters');
    }
}
