<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'duration_minutes' => 'integer',
        'status' => 'string',
    ];

    public function Teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function Classes()
    {
        return $this->belongsTo(Classes::class);
    }

    public function Questions()
    {
        return $this->hasMany(Question::class);
    }

    public function Attempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }
}
