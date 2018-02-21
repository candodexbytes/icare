<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ptd_id', 100);
            $table->integer('user_id', 5)->nullable()->default();
            $table->string('collection_id', 200)->nullable()->default();
            $table->string('recipient_array', 250)->nullable()->default();
            $table->string('country', 250);
            $table->string('country_code', 50);
            $table->string('country_phone_code', 50);
            $table->string('township_name', 150);
            $table->string('zipcode', 100);
            $table->string('city_name', 100)->nullable()->default();
            $table->string('address', 250)->nullable()->default();
            $table->string('image', 250)->nullable()->default();
            $table->string('state', 100);
            $table->string('area_name', 100);
            $table->string('property_type', 100);
            $table->string('property_management_contact', 100);
            $table->string('resident_committee_contact', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('property');
    }
}
