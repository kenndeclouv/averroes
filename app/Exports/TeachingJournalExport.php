<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class TeachingJournalExport implements FromView, ShouldAutoSize, WithColumnWidths
{
    public $journals;
    public $monthYear;

    public function __construct($journals, $monthYear)
    {
        $this->journals = $journals;
        $this->monthYear = $monthYear;
    }

    public function view(): View
    {
        return view('exports.teaching_journals', [
            'journals' => $this->journals,
            'monthYear' => $this->monthYear
        ]);
    }

    public function columnWidths(): array
    {
        return [
            'A' => 22, // Tanggal
            'B' => 30, // Guru
            'C' => 45, // Subjek
            'D' => 15, // JP Reguler
            'E' => 15, // JP Badal
        ];
    }
}
