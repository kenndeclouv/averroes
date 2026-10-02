<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class RawJournalExport implements FromArray, WithHeadings, WithTitle, ShouldAutoSize
{
    protected $journalsByTeacherDB;

    public function __construct($journalsByTeacherDB)
    {
        $this->journalsByTeacherDB = $journalsByTeacherDB;
    }

    public function array(): array
    {
        $data = [];
        foreach ($this->journalsByTeacherDB as $teacherName => $journals) {
            foreach ($journals as $journal) {
                $subjects = $journal->teachingSubjects->pluck('name')->implode(', ');
                $data[] = [
                    'Teacher Name' => $teacherName,
                    'Date' => $journal->date,
                    'Subjects' => $subjects,
                    'Regular Hours' => $journal->total_regular_hours,
                    'Replacement Hours' => $journal->total_replacement_hours,
                ];
            }
        }
        return $data;
    }

    public function headings(): array
    {
        return [
            'Teacher Name',
            'Date',
            'Subjects',
            'Regular Hours',
            'Replacement Hours',
        ];
    }

    public function title(): string
    {
        return 'Raw Jurnal';
    }
}
