<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CompanyMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_master', function (Blueprint $table) {
            $table->id('user_id');
            $table->unsignedBigInteger('user_master_id')->nullable();
            $table->string('company_name', 50)->nullable();
            $table->string('gst_no', 30)->nullable();
            $table->string('hsn_sac_code', 20)->nullable();
            $table->string('company_type', 20)->nullable();
            $table->string('company_contact_user', 50)->nullable();
            $table->unsignedBigInteger('company_phone')->nullable();
            $table->string('company_email', 50)->nullable();
            $table->string('company_address', 300)->nullable();
            $table->string('company_address_2', 300)->nullable();
            $table->string('company_address_3', 300)->nullable();
            $table->string('company_address_4', 300)->nullable();
            $table->string('company_location', 50)->nullable();
            $table->string('company_state', 30)->nullable();
            $table->string('company_pincode', 10)->nullable();
            $table->string('contact_person_secondary', 50)->nullable();
            $table->unsignedBigInteger('contact_no_secondary')->nullable();
            $table->string('company_email_secondary', 30)->nullable();
            $table->string('submitted_name', 30)->nullable();
            $table->char('company_status', 1)->nullable();
            $table->timestamp('company_entry_date')->nullable();

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
        Schema::dropIfExists('company_master');
    }
}
