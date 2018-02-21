<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertyUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_units', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ptd_id', 10);
            $table->integer('property_id', 11);
            $table->string('collection_id', 200)->nullable()->default(0);
            $table->string('unit_ptd', 50);
            $table->string('block_number', 50);
            $table->string('unit_number', 50);
            $table->text('address');
            $table->integer('status',10)->default(1);
            $table->timestamps('created_date')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('property_units');
    }
}
