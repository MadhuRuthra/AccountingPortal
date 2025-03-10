<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_master extends Model
{
    use HasFactory;

    protected $fillable = [

        'product_master_id',
        'product_master_name',
        'product_master_details',
        'product_master_status',
        'product_master_entdate',
        'product_qty',
        'product_rate',
        'product_amount',
        'product_gst',
        'product_total_amount',
        'created_at',
        'updated_at',
      
        
    ];

}
