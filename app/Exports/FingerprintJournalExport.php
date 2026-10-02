<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;

class FingerprintJournalExport implements FromView, ShouldAutoSize, WithColumnWidths, WithTitle
{
    public $journals;      // Collection (may be empty)
    public $monthYear;
    public $name;          // Display name (from DB)
    public $fingerLogs;    // all finger logs keyed by fingerName
    public $fingerName;    // the exact key in fingerLogs for this person (null if no match)
    public $year;
    public $month;
    public $teacher;       // Teacher model or null

    public function __construct($journals, $monthYear, $name, $fingerLogs, $fingerName, $year, $month, $teacher)
    {
        $this->journals   = $journals;
        $this->monthYear  = $monthYear;
        $this->name       = $name;
        $this->fingerLogs = $fingerLogs;
        $this->fingerName = $fingerName;
        $this->year       = $year;
        $this->month      = $month;
        $this->teacher    = $teacher;
    }

    public function title(): string
    {
        $name  = ucwords(strtolower($this->name));
        $title = str_replace(['*', ':', '/', '\\', '?', '[', ']'], '', $name);
        return substr($title, 0, 31);
    }

    public function view(): View
    {
        // Finger logs for this person (keyed by Y-m-d)
        $logs = $this->fingerName ? ($this->fingerLogs[$this->fingerName] ?? []) : [];

        // Compute avg datang & pulang from days with >= 2 scans (for smart single-scan detection)
        $datangSecs = [];
        $pulangSecs = [];
        foreach ($logs as $dayLogs) {
            if (count($dayLogs) >= 2) {
                $datangSecs[] = \Carbon\Carbon::parse(min($dayLogs))->secondsSinceMidnight();
                $pulangSecs[] = \Carbon\Carbon::parse(max($dayLogs))->secondsSinceMidnight();
            }
        }
        $avgDatang = count($datangSecs) > 0 ? array_sum($datangSecs) / count($datangSecs) : 25200; // default 07:00
        $avgPulang = count($pulangSecs) > 0 ? array_sum($pulangSecs) / count($pulangSecs) : 57600; // default 16:00

        // Index journals by date
        $journalsByDate = collect($this->journals)->groupBy('date');

        // Generate rows for every day in the month
        $daysInMonth = \Carbon\Carbon::create($this->year, $this->month)->daysInMonth;
        $rows        = [];

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $dateObj  = \Carbon\Carbon::create($this->year, $this->month, $day);
            $dateYmd  = $dateObj->format('Y-m-d');
            $dayOfWeek = $dateObj->dayOfWeek; // 0=Sun, 6=Sat

            $isWeekend = ($dayOfWeek === 0 || $dayOfWeek === 6);
            $weekendLabel = $dayOfWeek === 6 ? 'LIBUR HARI SABTU' : 'LIBUR HARI MINGGU';

            // Finger data for this day
            $dayLogs    = $logs[$dateYmd] ?? [];
            $datangTime = null;
            $pulangTime = null;

            if (count($dayLogs) > 0) {
                $datangTime = min($dayLogs);
                $pulangTime = max($dayLogs);
                if ($datangTime === $pulangTime) {
                    $scanSec = \Carbon\Carbon::parse($datangTime)->secondsSinceMidnight();
                    if (abs($scanSec - $avgDatang) < abs($scanSec - $avgPulang)) {
                        $pulangTime = null; // only datang recorded
                    } else {
                        $pulangTime = $datangTime;
                        $datangTime = null; // only pulang recorded
                    }
                }
            }

            // Subject & JP from journals on this day
            $dayJournals = $journalsByDate[$dateYmd] ?? collect();
            $subjects    = $dayJournals->flatMap(fn($j) => $j->teachingSubjects)->pluck('name')->unique()->implode(', ');
            $jpReguler   = $dayJournals->sum('total_regular_hours');
            $jpBadal     = $dayJournals->sum('total_replacement_hours');

            // Keterangan
            $keterangan   = '';
            $keteranganBg = '';

            if (count($dayLogs) > 0 && (!$datangTime || !$pulangTime)) {
                $keterangan   = 'LUPA FINGER';
                $keteranganBg = '#ffe699';
            } elseif (count($dayLogs) === 0 && ($dayJournals->isNotEmpty())) {
                // Has journal entry but no finger at all (even on weekends)
                $keterangan   = 'LUPA FINGER';
                $keteranganBg = '#ffe699';
            }

            // Determine if person was present (had finger OR has journal)
            $hadir = (count($dayLogs) > 0 || $dayJournals->isNotEmpty()) ? 1 : 0;

            $rows[] = [
                'date'          => $dateObj->locale('id')->translatedFormat('j F Y'),
                'datang'        => $datangTime,
                'pulang'        => $pulangTime,
                'subjects'      => $subjects ?: ($dayJournals->isEmpty() && count($dayLogs) > 0 ? '-' : ''),
                'jp_reguler'    => (int) $jpReguler,
                'jp_badal'      => (int) $jpBadal,
                'keterangan'    => $keterangan,
                'keteranganBg'  => $keteranganBg,
                'hadir'         => $hadir,
                'isWeekend'     => $isWeekend,
            ];
        }

        $totalHadir      = collect($rows)->sum('hadir');
        $totalJpReguler  = collect($rows)->sum('jp_reguler');
        $totalJpBadal    = collect($rows)->sum('jp_badal');
        $totalLupaFinger = collect($rows)->where('keterangan', 'LUPA FINGER')->count();

        // Determine if teacher is internal staff vs external/part-time teacher
        $isInternal = false;
        if ($this->teacher) {
            $internalSlugs = ['kepala-sekolah', 'mudir-ma-had', 'wakil-kepala-sekolah-humas', 'wakil-kepala-sekolah-kurikulum', 'sarpras', 'musyrif', 'tata-usaha', 'treasurer', 'admin', 'keuangan'];
            $teacherTypeSlugs = $this->teacher->teacherTypes->pluck('slug')->toArray();
            foreach ($internalSlugs as $slug) {
                if (in_array($slug, $teacherTypeSlugs)) {
                    $isInternal = true;
                    break;
                }
            }
        }

        if ($isInternal || empty($this->journals) || count($this->journals) === 0) {
            // Internal staff / non-teaching: Work days = Monday to Friday (weekdays)
            $totalHariKerja = collect($rows)->where('isWeekend', false)->count();
            $totalHariLibur = collect($rows)->where('isWeekend', true)->count();
        } else {
            // External teacher: Work days = count of days in month matching their teaching schedule days of week
            $teachingDaysOfWeek = collect($this->journals)
                ->map(fn($j) => \Carbon\Carbon::parse($j->date)->dayOfWeek)
                ->unique()
                ->toArray();

            $totalHariKerja = 0;
            for ($day = 1; $day <= $daysInMonth; $day++) {
                $dObj = \Carbon\Carbon::create($this->year, $this->month, $day);
                if (in_array($dObj->dayOfWeek, $teachingDaysOfWeek)) {
                    $totalHariKerja++;
                }
            }
            $totalHariLibur = $daysInMonth - $totalHariKerja;
        }

        $monthName = \Carbon\Carbon::create($this->year, $this->month, 1)->locale('id')->translatedFormat('F');

        $jabatan = 'GURU';
        if ($this->teacher) {
            $types = $this->teacher->teacherTypes->pluck('name')->toArray();
            if (!empty($types)) {
                $jabatan = implode(', ', $types);
            }
        } else {
            $jabatan = 'STAF';
        }

        return view('exports.fingerprint_journals', [
            'name'            => $this->name,
            'teacher'         => $this->teacher,
            'jabatan'         => $jabatan,
            'monthName'       => $monthName,
            'monthYear'       => $this->monthYear,
            'year'            => $this->year,
            'month'           => $this->month,
            'rows'            => $rows,
            'totalHadir'      => $totalHadir,
            'totalHariKerja'  => $totalHariKerja,
            'totalHariLibur'  => $totalHariLibur,
            'totalLupaFinger' => $totalLupaFinger,
            'totalJpReguler'  => $totalJpReguler,
            'totalJpBadal'    => $totalJpBadal,
        ]);
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20, // Tanggal
            'B' => 45, // Subjek
            'C' => 15, // Datang
            'D' => 15, // Pulang
            'E' => 20, // Keterangan
            'F' => 12, // Hadir
            'G' => 15, // JP Reguler
            'H' => 15, // JP Badal
        ];
    }
}
