<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeachingJournal extends Model
{
    protected $guarded = [];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function teachingJournalSubjects()
    {
        return $this->hasMany(TeachingJournalSubject::class);
    }

    public function teachingSubjects()
    {
        return $this->belongsToMany(TeachingSubject::class, 'teaching_journal_subjects');
    }
}
