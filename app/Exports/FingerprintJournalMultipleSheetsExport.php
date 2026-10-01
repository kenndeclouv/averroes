<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Export;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class FingerprintJournalMultipleSheetsExport implements WithMultipleSheets, Export
{
    protected $journalsByTeacher;
    protected $monthYear;
    protected $fingerLogs;
    protected $fingerNames;
    protected $year;
    protected $month;

    public function __construct($journalsByTeacher, $monthYear, $fingerLogs, $fingerNames, $year, $month)
    {
        $this->journalsByTeacher = $journalsByTeacher;
        $this->monthYear = $monthYear;
        $this->fingerLogs = $fingerLogs;
        $this->fingerNames = $fingerNames;
        $this->year = $year;
        $this->month = $month;
    }

    public function sheets(): array
    {
        $sheets = [];

        // No summary sheet for this? The screenshot only shows the fingerprint report.
        // We'll just generate the teacher sheets.
        
        foreach ($this->journalsByTeacher as $teacherName => $journals) {
            // we pass the first journal's teacher as well so we know their position
            $teacher = $journals->first()->teacher;
            $sheets[] = new FingerprintJournalExport($journals, $this->monthYear, $teacherName, $this->fingerLogs, $this->fingerNames, $this->year, $this->month, $teacher);
        }

        return $sheets;
    }
}
