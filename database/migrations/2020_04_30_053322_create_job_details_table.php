<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('job_master_id')->unsigned();
            $table ->foreign('job_master_id')->references('id')->on('job_masters');

            $table->bigInteger('employee_id')->unsigned();
            $table ->foreign('employee_id')->references('id')->on('users');

            $table->bigInteger('material_id')->unsigned();
            $table ->foreign('material_id')->references('id')->on('materials');

            $table->bigInteger('job_task_id')->unsigned();
            $table ->foreign('job_task_id')->references('id')->on('job_tasks');

            $table->double('material_quantity')->nullable(false);
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
        Schema::dropIfExists('job_details');
    }
}
