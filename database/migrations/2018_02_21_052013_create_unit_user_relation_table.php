<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnitUserRelationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unit_user_relation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('property_id', 11);
            $table->integer('user_id', 10);
            $table->integer('unit_id', 10);
            $table->integer('status', 3)->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('unit_user_relation');
    }
}
