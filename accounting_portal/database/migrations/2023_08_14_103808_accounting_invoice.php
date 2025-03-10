<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AccountingInvoice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('accounting_invoice', function (Blueprint $table) {
            $table->id('accounting_invoice_id');
            $table->string('financial_year', 7);
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('bank_master_id')->nullable();
            $table->string('quotation_sr_no', 20);
            $table->string('quotation_submitted_by', 30)->nullable();
            $table->string('po_details', 10)->nullable();
            $table->string('po_attachment', 50)->nullable();
            $table->string('invoice_sr_no', 20)->nullable();
            $table->string('invoice_submitted_by', 30)->nullable();
            $table->char('quotation_type', 1)->nullable();
            $table->string('quotation_remarks', 150)->nullable();
            $table->string('quotation_remarks_2', 150)->nullable();
            $table->unsignedBigInteger('billing_location_id');
 	    $table->unsignedBigInteger('company_id');
            $table->string('contact_person', 50)->nullable();
            $table->string('company_address', 300)->nullable();
            $table->string('company_address_2', 300)->nullable();
            $table->string('company_address_3', 300)->nullable();
            $table->string('company_address_4', 300)->nullable();
            $table->string('company_location', 50)->nullable();
            $table->string('company_state', 30)->nullable();
            $table->string('company_pincode', 10)->nullable();
            $table->string('activity', 30)->nullable();
            $table->string('activity_details', 100)->nullable();
            $table->string('material_code', 50)->nullable();
            $table->string('vendor_code', 30)->nullable();
            $table->string('quantity', 10);
            $table->string('rate', 10);
            $table->string('sub_total_amount', 15);
            $table->string('gst_percentage', 2);
            $table->string('gst_amount', 10);
            $table->string('total_amount', 15);
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->timestamp('submit_date');
            $table->char('gst_status', 1)->nullable();
            $table->string('entry_status', 30);
            $table->timestamp('received_date')->nullable();
            $table->text('remarks')->nullable();
            $table->char('payment_status', 1)->nullable();
            $table->char('payment_method', 1)->nullable();
            $table->timestamp('payment_date')->nullable();
            $table->string('payment_received', 10)->nullable();
            $table->string('payment_attachment', 50)->nullable();
            $table->char('accounting_invoice_status', 1);
            $table->char('filing_status', 1)->nullable();
            $table->string('filing_upload', 50)->nullable();
            $table->timestamp('accounting_invoice_entdate');
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
        Schema::dropIfExists('accounting_invoice');
    }
}
