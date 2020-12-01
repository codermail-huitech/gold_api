<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('id');
            $table->string('person_name')->nullable(true);
            $table->string('email');

            $table->string('password');
            $table->rememberToken();
            $table->string('mobile1',15)->nullable(true);
            $table->string('mobile2',15)->nullable(true);
            $table->bigInteger('person_type_id')->unsigned();
            $table ->foreign('person_type_id')->references('id')->on('person_types');
            $table->bigInteger('customer_category_id')->unsigned()->default(1);
            $table ->foreign('customer_category_id')->references('id')->on('customer_categories');
            //Address
            $table->String('address1', 100)->nullable(true);
            $table->String('address2', 100)->nullable(true);
            $table->String('state', 50)->default('West Bengal')->nullable(true);
            $table->String('po', 50)->nullable(true);
            $table->String('area', 50)->nullable(true);
            $table->String('city', 50)->nullable(true);
            $table->String('pin', 10)->nullable(true);
            $table->integer('mv')->default(0)->nullable(false);

            $table->double('opening_balance_LC')->default(0);
            $table->double('opening_balance_Gold')->default(0);


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
        Schema::dropIfExists('users');
    }
}
