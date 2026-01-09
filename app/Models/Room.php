<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $guarded = ['id'];
    public function Teachers()
    {
        return $this->hasMany(Teacher::class);
    }
    public function Students()
    {
        return $this->hasMany(Student::class);
    }

    public function Inventories()
    {
        return $this->hasMany(Inventory::class);
    }
}
