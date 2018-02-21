<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHandymanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('handyman', function (Blueprint $table) {
            $table->increments('id', 11);
            $table->string('ptd_id', 150);
            $table->integer('property_id', 11);
            $table->string('name', 255);
            $table->string('cell_number', 250);
            $table->text('image');
            $table->string('type', 150);
            $table->text('description');
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
        Schema::dropIfExists('handyman');
    }
}
