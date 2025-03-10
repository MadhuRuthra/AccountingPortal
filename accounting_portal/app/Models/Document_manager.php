<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document_manager extends Model
{
    use HasFactory;

    protected $fillable = [

        'user_id',
        'document_details',
        'document_url',
        'document_status',
        
        
    ];
}
