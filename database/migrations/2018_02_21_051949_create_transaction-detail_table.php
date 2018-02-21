<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction-detail', function (Blueprint $table) {
            $table->increments('transaction_id');
            $table->integer('user_id', 100);
            $table->integer('maintenance_id', 11)->nullable()->default();
            $table->double('amount')->nullable()->default();
            $table->integer('status', 11)->default(0);
            $table->string('slug', 250)->nullable()->default();
            $table->string('bill_id', 150)->nullable()->default();
            $table->timestamps('created_date')->useCurrent();
            $table->timestamps('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction-detail');
    }
}
