<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizAttempt extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
    ];

    public function Quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function Student()
    {
        return $this->belongsTo(Student::class);
    }

    public function Answers()
    {
        return $this->hasMany(QuizAnswer::class);
    }
}
