<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company_master extends Model
{
    use HasFactory;

    protected $fillable = [

        'user_master_id',
        'company_name',
        'gst_no',
	'hsc_sac_code',
        'company_type',
        'company_contact_user',
        'company_phone',
        'company_email',
        'company_address',
        'company_location',
        'company_status',
        'company_entry_date',
        
    ];

}
