<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\Export;

class TeachingJournalSummaryExport implements FromView, ShouldAutoSize, WithColumnWidths, WithTitle, Export
{
    public $journalsByTeacher;
    public $monthYear;

    public function __construct($journalsByTeacher, $monthYear)
    {
        $this->journalsByTeacher = $journalsByTeacher;
        $this->monthYear = $monthYear;
    }

    public function title(): string
    {
        return 'Rangkuman';
    }

    public function view(): View
    {
        $summary = [];

        foreach ($this->journalsByTeacher as $teacherName => $journals) {
            $safeSheetName = substr(str_replace(['*', ':', '/', '\\', '?', '[', ']'], '', $teacherName), 0, 31);
            
            $totalReguler = $journals->sum('total_regular_hours');
            $totalBadal = $journals->sum('total_replacement_hours');
            
            $summary[] = [
                'nama' => $teacherName,
                'sheet_name' => $safeSheetName,
                'total_reguler' => $totalReguler,
                'total_badal' => $totalBadal,
                'total_keseluruhan' => $totalReguler + $totalBadal
            ];
        }

        return view('exports.teaching_journals_summary', [
            'summary' => $summary,
            'monthYear' => $this->monthYear
        ]);
    }

    public function columnWidths(): array
    {
        return [
            'A' => 10, // No
            'B' => 35, // Guru
            'C' => 20, // Total JP Reguler
            'D' => 20, // Total JP Badal
            'E' => 20, // Total Keseluruhan
        ];
    }
}
