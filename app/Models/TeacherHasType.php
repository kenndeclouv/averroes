<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherHasType extends Model
{
    protected $guarded = ["id"];

    public function TeacherType()
    {
        return $this->belongsTo(TeacherType::class);
    }
    public function Teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
