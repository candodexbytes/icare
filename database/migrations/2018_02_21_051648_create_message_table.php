<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ptd_id', 150)->nullable()->default();
            $table->integer('property_id', 11);
            $table->string('sent_to', 150);
            $table->string('sent_from', 150);
            $table->string('subject', 250)->nullable()->default();
            $table->string('message', 1000)->nullable()->default();
            $table->integer('sender_id', 11);
            $table->integer('reciever_id', 11);
            $table->integer('parent_id', 11)->default(0);
            $table->integer('status', 11)->default(0);
            $table->integer('u_delete_status', 11)->default(0);
            $table->integer('a_delete_status', 11)->default(0);
            $table->timestamps('date')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('message');
    }
}
