<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales_team extends Model
{
    use HasFactory;

    protected $fillable = [

        'sales_team_id',
        'sales_team_user',
        'sales_team_status',
        'sales_team_entdate',
        'created_at',
        'updated_at',
      
    ];
}
