<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $guarded = [];
    
    public function Category()
    {
        return $this->belongsTo(TransactionCategory::class, 'transaction_category_id');
    }
}
