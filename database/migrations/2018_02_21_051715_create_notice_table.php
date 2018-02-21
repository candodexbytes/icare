<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoticeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notice', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ptd_id', 100);
            $table->integer('property_id', 11);
            $table->string('subject', 255);
            $table->text('description');
            $table->text('image');
            $table->timestamps('create_date')->useCurrent();
            $table->string('end_date', 150);
            $table->integer('seen_status', 11)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notice');
    }
}
