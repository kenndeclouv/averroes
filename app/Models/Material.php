<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = [
        'teacher_id',
        'classes_id',
        'semester_id',
        'teaching_subject_id',
        'title',
        'content',
        'type',
        'file_path'
    ];

    public function Teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function Classes()
    {
        return $this->belongsTo(Classes::class);
    }

    public function Semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function TeachingSubject()
    {
        return $this->belongsTo(TeachingSubject::class);
    }

    public function getFileUrlAttribute()
    {
        return $this->file_path ? asset('storage/' . $this->file_path) : null;
    }
}
