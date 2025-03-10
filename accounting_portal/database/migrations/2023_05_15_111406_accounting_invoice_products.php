<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AccountingInvoiceProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounting_invoice_products', function (Blueprint $table) {
            $table->id('accinvprd_id');
            $table->unsignedBigInteger('accounting_invoice_id');
            $table->unsignedBigInteger('product_master_id');
            $table->string('product_rate', 10);
            $table->string('prd_qty', 15);
            $table->string('prd_subtotal_amount', 15);
            $table->unsignedInteger('prd_gst_percentage');
            $table->string('prd_gst_amount', 10);
            $table->string('prd_total_amount', 15);
            $table->char('accinvprd_status', 1)->nullable();
            $table->timestamp('accinvprd_entry_date');

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
        Schema::dropIfExists('accounting_invoice_products');
    }
}
