<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitingCardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visiting_card', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('resident_user_id', 10);
            $table->integer('visitor_user_id', 10);
            $table->string('sender_id',100);
            $table->string('visitor_mobile_number',255);
            $table->integer('property_id', 10);
            $table->integer('property_unit_id', 10);
            $table->string('car_number',255)->nullable();
            $table->string('total_vistiorr',255)->nullable();
            $table->string('qr_code_image',250)->nullable();
            $table->string('visiting_date',255);
            $table->timestamps('created_date')->useCurrent();
            $table->timestamps('updated_date')->useCurrent();
            $table->integer('invite_status', 10)->default(0);
            $table->string('visting_code',255);
            $table->integer('send_by', 10);
            $table->integer('favourite_resident', 10)->default(0);
            $table->integer('favourite_visitor', 10)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visiting_card');
    }
}
