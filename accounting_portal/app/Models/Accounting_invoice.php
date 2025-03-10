<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accounting_invoice extends Model
{
    use HasFactory;

    protected $fillable = [

        'accounting_invoice_id',
        'financial_year',
        'user_id',
        'quotation_sr_no',
        'po_details',
        'invoice_sr_no',
        'billing_location_id',
        'contact_person',
        'activity',
        'activity_details',
        'quantity',
        'rate',
        'sub_total_amount',
        'gst_percentage',
        'gst_amount',
        'total_amount',
        'start_date',
        'end_date',
        'submit_date',
        'gst_status',
        'entry_status',
        'remarks',
        'payment_status',
        'payment_date',
        'payment_received',
        'accounting_invoice_status',
        'accounting_invoice_entdate',
        'created_at',
        'updated_at',
        
    ];
}
