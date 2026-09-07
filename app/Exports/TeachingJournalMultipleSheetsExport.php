<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Export;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class TeachingJournalMultipleSheetsExport implements WithMultipleSheets, Export
{
    protected $journalsByTeacher;
    protected $monthYear;

    public function __construct($journalsByTeacher, $monthYear)
    {
        $this->journalsByTeacher = $journalsByTeacher;
        $this->monthYear = $monthYear;
    }

    public function sheets(): array
    {
        $sheets = [];

        // Halaman pertama: Rangkuman
        $sheets[] = new TeachingJournalSummaryExport($this->journalsByTeacher, $this->monthYear);

        // Halaman berikutnya: Per guru
        foreach ($this->journalsByTeacher as $teacherName => $journals) {
            $sheets[] = new TeachingJournalExport($journals, $this->monthYear, $teacherName);
        }

        return $sheets;
    }
}
