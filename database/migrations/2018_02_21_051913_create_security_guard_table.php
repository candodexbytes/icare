<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSecurityGuardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('security_guard', function (Blueprint $table) {
            $table->increments('security_id');
            $table->integer('property_id', 11);
            $table->string('security_name', 100);
            $table->string('username', 100);
            $table->string('password', 250);
            $table->integer('status', 11)->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('security_guard');
    }
}
