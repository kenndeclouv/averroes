<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherType extends Model
{
    protected $guarded = ["id"];

    public function TeacherHasTypes()
    {
        return $this->hasMany(TeacherHasType::class);
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'teacher_has_types', 'teacher_type_id', 'teacher_id');
    }
}
