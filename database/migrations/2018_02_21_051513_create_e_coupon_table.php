<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateECouponTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('e_coupon', function (Blueprint $table) {
            $table->increments('id', 11);
            $table->string('ptd_id', 150);
            $table->integer('property_id', 11);
            $table->string('title', 100);
            $table->string('subject', 250);
            $table->text('description');
            $table->string('type', 150);
            $table->text('image');
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
        Schema::dropIfExists('e_coupon');
    }
}
