<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeachingSubject extends Model
{
    protected $fillable = ['name', 'slug'];

    public function teachingJournalSubjects()
    {
        return $this->hasMany(TeachingJournalSubject::class);
    }
    //
}
