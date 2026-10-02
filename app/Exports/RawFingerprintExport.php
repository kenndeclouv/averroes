<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class RawFingerprintExport implements FromArray, WithTitle, ShouldAutoSize
{
    protected $rawFingerLines;

    public function __construct($rawFingerLines)
    {
        $this->rawFingerLines = $rawFingerLines;
    }

    public function array(): array
    {
        $data = [];
        
        foreach ($this->rawFingerLines as $line) {
            $line = trim($line);
            if (empty($line)) continue;
            
            // The text file is tab-separated
            $columns = explode("\t", $line);
            $data[] = $columns;
        }

        return $data;
    }

    public function title(): string
    {
        return 'Raw Fingerprint';
    }
}
