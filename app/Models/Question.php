<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function Quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function Options()
    {
        return $this->hasMany(QuestionOption::class);
    }
}
