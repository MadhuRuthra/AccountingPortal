<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank_master extends Model
{
    use HasFactory;

     protected $fillable = [

        'bank_master_id',
        'company_name',
        'bank_name',
        'bank_account_no',
        'bank_ifsc_code',
        'bank_branch',
        'bank_city',
        'bank_master_status',
        'bank_master_entdate',
      
    ];

}
