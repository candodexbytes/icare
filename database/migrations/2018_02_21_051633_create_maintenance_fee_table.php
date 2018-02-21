<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaintenanceFeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance_fee', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ptd_id', 150);
            $table->integer('property_id', 11);
            $table->integer('user_id', 100);
            $table->string('unit_id', 10);
            $table->double('amount')->nullable()->default();
            $table->text('item_list');
            $table->string('invoice_date', 50);
            $table->string('due_due', 50);
            $table->double('previous_due')->nullable()->default();
            $table->string('tax_percentage', 255)->nullable()->default();
            $table->double('tax_amount')->nullable()->default();
            $table->double('total_amount')->nullable()->default();
            $table->integer('payment_status', 11)->default(0);
            $table->integer('withdraw_status', 11)->nullable()->default(0);
            $table->timestamps('created_date')->useCurrent();
            $table->timestamps('updated_date')->useCurrent();
            $table->text('remarks');
            $table->text('invoice_path')->nullable()->default();
            $table->double('pay_amount')->nullable()->default();
            $table->string('invoice_month', 255);
            $table->string('pdfname', 150)->nullable()->default();
            $table->string('pdf_url', 250)->nullable()->default();
            $table->string('payment_url', 250)->nullable()->default();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('maintenance_fee');
    }
}
