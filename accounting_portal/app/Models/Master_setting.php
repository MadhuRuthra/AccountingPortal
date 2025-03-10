<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Master_setting extends Model
{
    use HasFactory;

      protected $fillable = [

        'master_settings_id',
        'master_settings_name',
        'master_settings_value',
        'master_settings_status',
        'master_settings_date',
      
    ];

}
