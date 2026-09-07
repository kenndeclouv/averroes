<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;

class TeachingJournalExport implements FromView, ShouldAutoSize, WithColumnWidths, WithTitle
{
    public $journals;
    public $monthYear;
    public $title;

    public function __construct($journals, $monthYear, $title = 'Jurnal Mengajar')
    {
        $this->journals = $journals;
        $this->monthYear = $monthYear;
        $this->title = $title;
    }

    public function title(): string
    {
        // Max title length in excel is 31 characters, and illegal characters are forbidden
        $title = str_replace(['*', ':', '/', '\\', '?', '[', ']'], '', $this->title);
        return substr($title, 0, 31);
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
