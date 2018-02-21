<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmergencyContactTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emergency-contact', function (Blueprint $table) {
            $table->increments('id', 11);
            $table->string('ptd_id', 150);
            $table->integer('property_id', 11);
            $table->string('name', 250);
            $table->string('cell_number', 250);
            $table->text('icon');
            $table->integer('status', 5)->default(0);
            $table->integer('save_type', 5)->default(5);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('emergency-contact');
    }
}
