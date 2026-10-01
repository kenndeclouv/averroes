<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Export;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\KafalahExport;

class FingerprintJournalMultipleSheetsExport implements WithMultipleSheets, Export
{
    protected $masterList;
    protected $journalsByTeacherDB;
    protected $monthYear;
    protected $fingerLogs;
    protected $year;
    protected $month;

    public function __construct($masterList, $journalsByTeacherDB, $monthYear, $fingerLogs, $year, $month)
    {
        $this->masterList          = $masterList;
        $this->journalsByTeacherDB = $journalsByTeacherDB;
        $this->monthYear           = $monthYear;
        $this->fingerLogs          = $fingerLogs;
        $this->year                = $year;
        $this->month               = $month;
    }

    public function sheets(): array
    {
        $sheets = [];

        // Halaman pertama: Rangkuman
        $allTeachersJournals = collect();
        foreach ($this->masterList as $entry) {
            $name = $entry['name'];
            $allTeachersJournals[$name] = $this->journalsByTeacherDB[$name] ?? collect();
        }

        $sheets[] = new TeachingJournalSummaryExport($allTeachersJournals, $this->monthYear);

        // Halaman kedua: Rencana Kafalah
        $sheets[] = new KafalahExport(
            $this->masterList,
            $this->journalsByTeacherDB,
            $this->monthYear,
            $this->fingerLogs,
            $this->year,
            $this->month
        );

        // Halaman per orang (DB teacher atau finger-only)
        foreach ($this->masterList as $entry) {
            $name       = $entry['name'];
            $teacher    = $entry['teacher'];
            $fingerName = $entry['fingerName'];

            // Journals for this person (may be empty if they don't teach)
            $journals = $this->journalsByTeacherDB[$name] ?? collect();

            $sheets[] = new FingerprintJournalExport(
                $journals,
                $this->monthYear,
                $name,
                $this->fingerLogs,
                $fingerName,
                $this->year,
                $this->month,
                $teacher
            );
        }

        return $sheets;
    }
}
