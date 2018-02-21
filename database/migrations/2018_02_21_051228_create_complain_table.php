<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComplainTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complain', function (Blueprint $table) {
            $table->increments('id', 11);
            $table->string('ptd_id', 150);
            $table->integer('property_id', 11);
            $table->integer('unit_id', 11);
            $table->string('ticket', 250);
            $table->integer('user_id', 100)->unsigned()->index();
            $table->text('remark');
            $table->text('image');
            $table->string('status', 50);
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
        Schema::dropIfExists('complain');
    }
}
