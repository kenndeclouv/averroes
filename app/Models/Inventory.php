<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = [
        'item_code',
        'name',
        'condition',
        'quantity',
        'purchase_date',
        'description',
        'location',
        'room_id', // Add room_id
    ];

    protected $casts = [
        'purchase_date' => 'date',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
