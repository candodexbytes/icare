<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visitors', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id', 100);
            $table->string('cell_number',255);
            $table->integer('country_code', 11)->nullable()->default();
            $table->integer('unit_id', 10)->nullable()->default();
            $table->string('name',255)->nullable()->default();
            $table->string('password',250)->nullable()->default();
            $table->string('visitor_nric',255)->nullable()->default();
            $table->string('mycard_image',250)->nullable()->default();
            $table->text('profile_image')->nullable()->default();
            $table->string('visitor_code',255)->nullable()->default();
            $table->integer('login_status',5)->default(0);
            $table->timestamps('created_date')->useCurrent();
            $table->integer('otp',50)->nullable()->default();
            $table->string('otp_create_date',150)->nullable()->default();  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visitors');
    }
}
