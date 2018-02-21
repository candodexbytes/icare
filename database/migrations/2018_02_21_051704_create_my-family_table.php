<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMyFamilyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('my-family', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ptd_id', 100);
            $table->integer('property_id', 11);
            $table->integer('user_id', 10);
            $table->integer('unit_id', 10);
            $table->string('name', 150)->nullable()->default();
            $table->string('email', 250)->nullable()->default();
            $table->string('address', 250)->nullable()->default();
            $table->string('nric', 250)->nullable()->default();
            $table->string('relationship', 150)->nullable()->default();
            $table->string('gender', 100)->nullable()->default();
            $table->string('car_model', 250)->nullable()->default();
            $table->string('car_number', 250)->nullable()->default();
            $table->string('colour', 250)->nullable()->default();
            $table->string('phone', 250)->nullable()->default();
            $table->integer('country_code', 11)->nullable()->default();
            $table->string('phone2', 250)->nullable()->default();
            $table->integer('type', 5)->default(0);
            $table->string('image', 250)->nullable()->default();
            $table->integer('status', 5)->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('my-family');
    }
}
