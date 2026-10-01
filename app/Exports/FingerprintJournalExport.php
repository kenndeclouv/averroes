<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;

class FingerprintJournalExport implements FromView, ShouldAutoSize, WithColumnWidths, WithTitle
{
    public $journals;
    public $monthYear;
    public $title;
    public $fingerLogs;
    public $fingerNames;
    public $year;
    public $month;
    public $teacher;

    public function __construct($journals, $monthYear, $title, $fingerLogs, $fingerNames, $year, $month, $teacher)
    {
        $this->journals = $journals;
        $this->monthYear = $monthYear;
        $this->title = $title;
        $this->fingerLogs = $fingerLogs;
        $this->fingerNames = $fingerNames;
        $this->year = $year;
        $this->month = $month;
        $this->teacher = $teacher;
    }

    public function title(): string
    {
        $title = str_replace(['*', ':', '/', '\\', '?', '[', ']'], '', $this->title);
        return substr($title, 0, 31);
    }

    public function view(): View
    {
        // Find best matching fingerprint name
        $bestMatch = null;
        $tName = strtolower(trim($this->title));
        $tNameNoSpace = str_replace(' ', '', $tName);

        // 1. Exact match (with spaces)
        foreach ($this->fingerNames as $fName) {
            if (strtolower(trim($fName)) === $tName) {
                $bestMatch = $fName;
                break;
            }
        }

        // 2. Exact match ignoring spaces (e.g. "Nur Huda" vs "NURHUDA")
        if (!$bestMatch) {
            foreach ($this->fingerNames as $fName) {
                $fNameNoSpace = str_replace(' ', '', strtolower(trim($fName)));
                if ($fNameNoSpace === $tNameNoSpace) {
                    $bestMatch = $fName;
                    break;
                }
            }
        }

        // 3. Substring match ignoring spaces
        if (!$bestMatch) {
            foreach ($this->fingerNames as $fName) {
                $fNameNoSpace = str_replace(' ', '', strtolower(trim($fName)));
                if (strlen($fNameNoSpace) >= 3 && (str_contains($tNameNoSpace, $fNameNoSpace) || str_contains($fNameNoSpace, $tNameNoSpace))) {
                    $bestMatch = $fName;
                    break;
                }
            }
        }

        $logs = $bestMatch ? ($this->fingerLogs[$bestMatch] ?? []) : [];
        
        $datangTimesSec = [];
        $pulangTimesSec = [];

        foreach ($logs as $dateYmd => $dayLogs) {
            if (count($dayLogs) >= 2) {
                $d = min($dayLogs);
                $p = max($dayLogs);
                $datangTimesSec[] = \Carbon\Carbon::parse($d)->secondsSinceMidnight();
                $pulangTimesSec[] = \Carbon\Carbon::parse($p)->secondsSinceMidnight();
            }
        }
        
        // Default threshold if not enough data
        $avgDatang = count($datangTimesSec) > 0 ? array_sum($datangTimesSec) / count($datangTimesSec) : 25200; // 07:00:00 default
        $avgPulang = count($pulangTimesSec) > 0 ? array_sum($pulangTimesSec) / count($pulangTimesSec) : 57600; // 16:00:00 default
        
        // Add fingerprint info to each journal
        foreach ($this->journals as $journal) {
            $dateObj = \Carbon\Carbon::parse($journal->date);
            $dateYmd = $dateObj->format('Y-m-d');
            
            $dayLogs = $logs[$dateYmd] ?? [];
            
            $datangTime = null;
            $pulangTime = null;
            
            if (count($dayLogs) > 0) {
                $datangTime = min($dayLogs);
                $pulangTime = max($dayLogs);
                if ($datangTime === $pulangTime) {
                    $scanSec = \Carbon\Carbon::parse($datangTime)->secondsSinceMidnight();
                    $diffDatang = abs($scanSec - $avgDatang);
                    $diffPulang = abs($scanSec - $avgPulang);
                    
                    if ($diffDatang < $diffPulang) {
                        $pulangTime = null;
                    } else {
                        $pulangTime = $datangTime;
                        $datangTime = null;
                    }
                }
            }
            $keterangan = '';
            if (!$datangTime || !$pulangTime) {
                $keterangan = 'LUPA FINGER';
            }
            
            $journal->datang = $datangTime;
            $journal->pulang = $pulangTime;
            $journal->keterangan = $keterangan;
        }

        return view('exports.fingerprint_journals', [
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
            'D' => 15, // Datang
            'E' => 15, // Pulang
            'F' => 20, // Keterangan
            'G' => 15, // JP Reguler
            'H' => 15, // JP Badal
        ];
    }
}
