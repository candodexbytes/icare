<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ptd_id', 100)->nullable()->default();
            $table->integer('property_id', 150);
            $table->integer('taman_condo_id', 10)->nullable()->default();
            $table->integer('country_phone_code', 11)->nullable()->default();
            $table->string('name', 150)->nullable()->default();
            $table->string('email', 250)->nullable()->default();
            $table->string('image', 250)->nullable()->default();
            $table->string('nric', 250)->nullable()->default();
            $table->string('mobile_number', 250)->nullable()->default();
            $table->string('otp', 20)->nullable()->default();
            $table->string('otp_create_date', 150)->nullable()->default();
            $table->string('password', 150)->nullable()->default();
            $table->string('first_name', 150)->nullable()->default();
            $table->string('last_name', 150)->nullable()->default();
            $table->string('remember_token', 400)->nullable()->default();
            $table->timestamps('created_at')->useCurrent();
            $table->timestamps('updated_at')->useCurrent();
            $table->integer('type', 3)->default(0);
            $table->integer('status', 5)->nullable()->default();
            $table->integer('delete_status', 11)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
