<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWithdrawalDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdrawal_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('property_id', 11)->nullable()->default();
            $table->string('amount', 250)->nullable()->default();
            $table->string('bank_name',250)->nullable()->default();
            $table->integer('bank_code', 11)->nullable()->default();
            $table->string('bank_account_number',255)->nullable()->default();
            $table->string('identity_number')->nullable()->default();
            $table->string('name')->nullable()->default();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('withdrawal_detail');
    }
}
