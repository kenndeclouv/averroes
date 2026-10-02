<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class KafalahExport implements FromView, ShouldAutoSize, WithColumnWidths, WithColumnFormatting, WithTitle
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

    public function title(): string
    {
        return 'Rencana Kafalah';
    }

    public function view(): View
    {
        $daysInMonth = \Carbon\Carbon::create($this->year, $this->month)->daysInMonth;

        $sdmInternal = [];
        $sdmEksternal = [];

        $internalCount = 0;
        $eksternalCount = 0;

        foreach ($this->masterList as $entry) {
            $name       = $entry['name'];
            $teacher    = $entry['teacher'];
            $fingerName = $entry['fingerName'];

            $journals = $this->journalsByTeacherDB[$name] ?? collect();
            $logs     = $fingerName ? ($this->fingerLogs[$fingerName] ?? []) : [];

            // Calculate presence / attendance
            $hadirCount = 0;
            $logsInMonthCount = 0;
            for ($d = 1; $d <= $daysInMonth; $d++) {
                $dYmd = \Carbon\Carbon::create($this->year, $this->month, $d)->format('Y-m-d');
                $dayLogs = $logs[$dYmd] ?? [];
                $dayJournals = $journals->where('date', $dYmd);
                $isWeekend = \Carbon\Carbon::create($this->year, $this->month, $d)->isWeekend();

                if (!empty($dayLogs)) {
                    $logsInMonthCount++;
                }
                if (!empty($dayLogs) || $dayJournals->isNotEmpty()) {
                    $hadirCount++;
                }
            }

            // Teacher position / Jabatan
            $jabatan = 'Pengajar';
            $isInternal = false;
            if ($teacher) {
                $types = $teacher->teacherTypes->pluck('name')->toArray();
                if (!empty($types)) {
                    $jabatan = implode(', ', $types);
                }
                $internalSlugs = ['kepala-sekolah', 'mudir-ma-had', 'wakil-kepala-sekolah-humas', 'wakil-kepala-sekolah-kurikulum', 'sarpras', 'musyrif', 'tata-usaha', 'treasurer', 'admin', 'keuangan'];
                $teacherSlugs = $teacher->teacherTypes->pluck('slug')->toArray();
                foreach ($internalSlugs as $slug) {
                    if (in_array($slug, $teacherSlugs)) {
                        $isInternal = true;
                        break;
                    }
                }
            }

            // Teaching JP
            $jpReguler = (int) $journals->sum('total_regular_hours');
            $jpBadal   = (int) $journals->sum('total_replacement_hours');
            $totalJp   = $jpReguler + $jpBadal;

            if ($isInternal) {
                $internalCount++;
                $hariKerja = collect(range(1, $daysInMonth))->filter(fn($d) => !\Carbon\Carbon::create($this->year, $this->month, $d)->isWeekend())->count();
                $hariLibur = $daysInMonth - $hariKerja;
                $alpha = max(0, $hariKerja - $hadirCount);

                // Use DB fields with intelligent fallbacks
                $potonganPerAlpha = $teacher?->potongan_alpha ?? 15000;
                $fungsional = $teacher?->tunjangan_fungsional;
                if (!$fungsional) {
                    if (str_contains(strtolower($jabatan), 'kepala') || str_contains(strtolower($jabatan), 'mudir')) {
                        $fungsional = 2000000;
                    } elseif (str_contains(strtolower($jabatan), 'admin') || str_contains(strtolower($jabatan), 'keuangan')) {
                        $fungsional = 1500000;
                    } else {
                        $fungsional = 1000000;
                    }
                }
                $transport = $teacher?->tunjangan_transport ?? 450000;
                $gajiPokok = $teacher?->gaji_pokok ?? 100000;
                $rateJp    = $teacher?->rate_jp ?? 12500;
                $potongan  = $alpha * $potonganPerAlpha;

                $kafalahMengajar = $totalJp * $rateJp;
                $totalKafalah    = $kafalahMengajar + $fungsional + $transport + $gajiPokok - $potongan;

                $sdmInternal[] = [
                    'no'                => $internalCount,
                    'name'              => $name,
                    'jabatan'           => $jabatan,
                    'hari_kerja'        => $hariKerja,
                    'hari_libur'        => $hariLibur,
                    'izin'              => 0,
                    'sakit'             => 0,
                    'alpha'             => $alpha,
                    'total_tidak_hadir' => $alpha,
                    'potongan'          => $potongan,
                    'jp_pekan'          => (int) ceil($jpReguler / 4),
                    'jp_badal'          => $jpBadal,
                    'jp_reguler'        => $jpReguler,
                    'total_jp'          => $totalJp,
                    'kafalah_mengajar'  => $kafalahMengajar,
                    'fungsional'        => $fungsional,
                    'transport'         => $transport,
                    'gaji_pokok'        => $gajiPokok,
                    'total_kafalah'     => $totalKafalah,
                    'tambahan'          => 0,
                    'total_akhir'       => $totalKafalah,
                    'no_rekening'       => $teacher?->no_rekening ?? '-',
                    'bank'              => $teacher?->bank ?? '-',
                ];
            } else {
                $eksternalCount++;
                // Active days of week for external teacher
                $teachingDaysOfWeek = $journals->map(fn($j) => \Carbon\Carbon::parse($j->date)->dayOfWeek)->unique()->toArray();
                $hariKerja = 0;
                for ($d = 1; $d <= $daysInMonth; $d++) {
                    if (in_array(\Carbon\Carbon::create($this->year, $this->month, $d)->dayOfWeek, $teachingDaysOfWeek)) {
                        $hariKerja++;
                    }
                }
                $hariKerja = max($hariKerja, 1);
                $hariLibur = $daysInMonth - $hariKerja;

                // Rate @JP: use DB field, fallback to jabatan-based estimation
                $rateJp = $teacher?->rate_jp;
                if (!$rateJp) {
                    $rateJp = 25000;
                    if (str_contains(strtolower($jabatan), 'diniyah') || str_contains(strtolower($jabatan), 'khusus')) {
                        $rateJp = 50000;
                    } elseif (str_contains(strtolower($jabatan), 'olahraga') || str_contains(strtolower($jabatan), 'matematika')) {
                        $rateJp = 35000;
                    }
                }
                $kafalahMengajarEkst = $totalJp * $rateJp;

                $sdmEksternal[] = [
                    'no'                => $eksternalCount,
                    'name'              => $name,
                    'jabatan'           => $jabatan,
                    'hari_kerja'        => $hariKerja,
                    'hari_libur'        => $hariLibur,
                    'izin'              => 0,
                    'sakit'             => 0,
                    'alpha'             => 0,
                    'total_tidak_hadir' => 0,
                    'potongan'          => 0,
                    'target_jp'         => $totalJp > 0 ? $totalJp : 8,
                    'realisasi_jp'      => $jpReguler,
                    'jp_badal'          => $jpBadal,
                    'rate_jp'           => $rateJp,
                    'kafalah_mengajar'  => $kafalahMengajarEkst,
                    'total_kafalah'     => $kafalahMengajarEkst,
                    'tambahan'          => 0,
                    'total_akhir'       => $kafalahMengajarEkst,
                    'no_rekening'       => $teacher?->no_rekening ?? '-',
                    'bank'              => $teacher?->bank ?? '-',
                ];
            }
        }

        $monthNameUpper = strtoupper(\Carbon\Carbon::create($this->year, $this->month, 1)->locale('id')->translatedFormat('F'));

        return view('exports.kafalah', [
            'monthNameUpper' => $monthNameUpper,
            'year'           => $this->year,
            'sdmInternal'    => $sdmInternal,
            'sdmEksternal'   => $sdmEksternal,
        ]);
    }

    public function columnFormats(): array
    {
        return [
            'K' => '"Rp "#,##0',
            'P' => '"Rp "#,##0',
            'Q' => '"Rp "#,##0',
            'R' => '"Rp "#,##0',
            'S' => '"Rp "#,##0',
            'T' => '"Rp "#,##0',
            'U' => '"Rp "#,##0',
            'V' => '"Rp "#,##0',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 6,   // NO
            'B' => 30,  // NAMA
            'C' => 30,  // AMANAH
            'D' => 15,  // HARI EFEKTIF
            'E' => 12,  // HARI LIBUR
            'F' => 10,  // IZIN
            'G' => 10,  // SAKIT
            'H' => 10,  // ALPHA
            'I' => 10,  // TOTAL
            'J' => 18,  // TOTAL TIDAK HADIR
            'K' => 15,  // POTONGAN
            'L' => 18,  // AMANAH MENGAJAR
            'M' => 15,  // BADAL
            'N' => 15,  // TOTAL JP
            'O' => 15,  // KAFALAH @JP
            'P' => 18,  // KAFALAH MENGAJAR
            'Q' => 15,  // FUNGSIONAL
            'R' => 15,  // TRANSPORT
            'S' => 15,  // GAJI POKOK
            'T' => 18,  // TOTAL KAFALAH
            'U' => 18,  // TAMBAHAN
            'V' => 22,  // TOTAL AKHIR
            'W' => 20,  // NO REKENING
            'X' => 12,  // BANK
        ];
    }
}
