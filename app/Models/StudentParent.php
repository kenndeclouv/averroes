<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class StudentParent extends Model
{
    protected $guarded = [];
    protected static function boot()
    {
        parent::boot();

    }
    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_has_parents', 'student_parent_id', 'student_id');
    }
}
