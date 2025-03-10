<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AccountingInvoiceContact extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounting_invoice_contact', function (Blueprint $table) {
            $table->id('acc_inv_contact_id');
            $table->unsignedBigInteger('accounting_invoice_id')->nullable();
            $table->char('contact_type', 1)->nullable();
            $table->string('contact_name', 30)->nullable();
            $table->string('contact_mobile', 30)->nullable();
            $table->string('contact_email', 30)->nullable();
            $table->timestamp('contact_entry_date')->nullable();
            $table->char('contact_status', 1)->nullable();
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
      Schema::dropIfExists('accounting_invoice_contact');   
    }
}
