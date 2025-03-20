<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppSetting extends Model
{
    protected $fillable = [
        'nis_prefix',
        'nis_start_number',
        'nis_padding',
        'nis_suffix',
        'nip_prefix',
        'nip_start_number',
        'nip_padding',
        'nip_suffix',
        
    ];
}
