<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DocumentManager extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_manager', function (Blueprint $table) {
            $table->id('document_manager_id');
            $table->unsignedBigInteger('user_id');
            $table->string('document_details', 100);
            $table->string('document_url', 100);
            $table->char('document_status', 1);
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
