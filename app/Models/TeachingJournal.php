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

    public static function isLocked($month, $year)
    {
        $exception = TeachingJournalException::where('month', $month)->where('year', $year)->first();
        if ($exception && $exception->is_unlocked) {
            return false;
        }

        $autoLockDate = \Carbon\Carbon::createFromDate($year, $month, 1)->addMonth()->addDay(1)->startOfDay();
        return \Carbon\Carbon::now()->greaterThanOrEqualTo($autoLockDate);
    }
}
