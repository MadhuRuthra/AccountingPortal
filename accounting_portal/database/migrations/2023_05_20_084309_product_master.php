<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProductMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_master', function (Blueprint $table) {
            $table->id('product_master_id');
            $table->string('product_master_name', 100);
            $table->string('product_master_details', 300);
            $table->char('product_master_status', 1);
            $table->timestamp('product_master_entdate');
            $table->string('product_qty', 100);
            $table->string('product_rate', 20);
            $table->string('product_amount', 20);
            $table->string('product_gst', 20);
            $table->string('product_total_amount', 20);
    
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
    Schema::dropIfExists('product_master');

    }
}
