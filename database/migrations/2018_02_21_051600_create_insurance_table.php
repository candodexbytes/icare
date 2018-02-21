<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInsuranceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insurance', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ptd_id', 150);
            $table->integer('property_id', 11);
            $table->integer('user_id', 100);
            $table->string('car_model', 255);
            $table->string('car_number', 255);
            $table->string('insurance_company', 255);
            $table->timestamps('create_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insurance');
    }
}
