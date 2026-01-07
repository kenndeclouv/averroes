<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeachingJournalSubject extends Model
{
    protected $fillable = ['teaching_journal_id', 'teaching_subject_id'];

    public function teachingJournal()
    {
        return $this->belongsTo(TeachingJournal::class);
    }

    public function teachingSubject()
    {
        return $this->belongsTo(TeachingSubject::class);
    }
}
