<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherType extends Model
{
    protected $guarded = ["id"];

    public function TeacherHasTypes()
    {
        return $this->hasMany(TeacherType::class);
    }
}
