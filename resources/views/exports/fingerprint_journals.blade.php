<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<table>
    <thead>
        <tr>
            <th colspan="8" style="background-color: #1a5e3a; color: white; font-weight: bold; text-align: center; font-size: 14px;">
                ABSENSI FINGER PRINT &amp; JURNAL MENGAJAR
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="font-weight: bold; background-color: #f2f2f2; border: 1px solid #000000;">NAMA</td>
            <td colspan="3" style="border: 1px solid #000000; font-weight: bold; text-align: left;">{{ strtoupper($name) }}</td>
            <td style="font-weight: bold; background-color: #f2f2f2; border: 1px solid #000000;">TOTAL HARI KERJA</td>
            <td colspan="3" style="border: 1px solid #000000; text-align: center; font-weight: bold;">{{ $totalHariKerja }}</td>
        </tr>
        <tr>
            <td style="font-weight: bold; background-color: #f2f2f2; border: 1px solid #000000;">JABATAN</td>
            <td colspan="3" style="border: 1px solid #000000; text-align: left;">{{ strtoupper($jabatan) }}</td>
            <td style="font-weight: bold; background-color: #f2f2f2; border: 1px solid #000000;">TOTAL HARI LIBUR</td>
            <td colspan="3" style="border: 1px solid #000000; text-align: center; font-weight: bold;">{{ $totalHariLibur }}</td>
        </tr>
        <tr>
            <td style="font-weight: bold; background-color: #f2f2f2; border: 1px solid #000000;">BULAN</td>
            <td colspan="3" style="border: 1px solid #000000; text-align: left;">{{ strtoupper($monthName) }}</td>
            <td style="font-weight: bold; background-color: #ffe699; border: 1px solid #000000;">LUPA FINGER</td>
            <td colspan="3" style="border: 1px solid #000000; text-align: center; font-weight: bold; background-color: #ffe699;">{{ $totalLupaFinger }}</td>
        </tr>
        <tr>
            <td style="font-weight: bold; background-color: #f2f2f2; border: 1px solid #000000;">TAHUN</td>
            <td colspan="3" style="border: 1px solid #000000; text-align: left;">{{ $year }}</td>
            <td style="font-weight: bold; background-color: #c6e0b4; border: 1px solid #000000;">TOTAL KEHADIRAN</td>
            <td colspan="3" style="border: 1px solid #000000; text-align: center; font-weight: bold; background-color: #c6e0b4;">{{ $totalHadir }}</td>
        </tr>

        <!-- Baris Kosong Pemisah -->
        <tr>
            <td colspan="8"></td>
        </tr>

        <!-- Header Tabel Utama (Warna Hijau #1a5e3a) -->
        <tr>
            <td style="background-color: #1a5e3a; color: white; font-weight: bold; border: 1px solid #000000;">Tanggal</td>
            <td style="background-color: #1a5e3a; color: white; font-weight: bold; border: 1px solid #000000;">Subjek</td>
            <td style="background-color: #1a5e3a; color: white; font-weight: bold; border: 1px solid #000000;">Waktu Datang</td>
            <td style="background-color: #1a5e3a; color: white; font-weight: bold; border: 1px solid #000000;">Waktu Pulang</td>
            <td style="background-color: #1a5e3a; color: white; font-weight: bold; border: 1px solid #000000;">Keterangan</td>
            <td style="background-color: #1a5e3a; color: white; font-weight: bold; border: 1px solid #000000;">Hadir</td>
            <td style="background-color: #1a5e3a; color: white; font-weight: bold; border: 1px solid #000000;">JP Reguler</td>
            <td style="background-color: #1a5e3a; color: white; font-weight: bold; border: 1px solid #000000;">JP Badal</td>
        </tr>

        <!-- Baris Data -->
        @foreach($rows as $row)
        @php
            $cellBg = $row['isWeekend'] ? 'background-color: #ffff8e;' : '';
        @endphp
        <tr>
            <td style="border: 1px solid #000000; {{ $cellBg }}">{{ $row['date'] }}</td>
            <td style="border: 1px solid #000000; {{ $cellBg }}">{!! $row['subjects'] !!}</td>
            <td style="border: 1px solid #000000; text-align: center; {{ $cellBg }}">{{ $row['datang'] ?? ($row['isWeekend'] ? '' : '-') }}</td>
            <td style="border: 1px solid #000000; text-align: center; {{ $cellBg }}">{{ $row['pulang'] ?? ($row['isWeekend'] ? '' : '-') }}</td>
            <td style="border: 1px solid #000000; text-align: center; {{ $row['keteranganBg'] ? 'background-color: ' . $row['keteranganBg'] . ';' : $cellBg }}">{{ $row['keterangan'] }}</td>
            <td style="border: 1px solid #000000; text-align: center; {{ $cellBg }}">{{ $row['hadir'] }}</td>
            <td style="border: 1px solid #000000; text-align: right; {{ $cellBg }}">{{ $row['jp_reguler'] ?: '' }}</td>
            <td style="border: 1px solid #000000; text-align: right; {{ $cellBg }}">{{ $row['jp_badal'] ?: '' }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5" style="background-color: #c6e0b4; font-weight: bold; border: 1px solid #000000;">Total</td>
            <td style="background-color: #c6e0b4; font-weight: bold; border: 1px solid #000000; text-align: center;">{{ $totalHadir }}</td>
            <td style="background-color: #c6e0b4; font-weight: bold; border: 1px solid #000000; text-align: right;">{{ $totalJpReguler }}</td>
            <td style="background-color: #c6e0b4; font-weight: bold; border: 1px solid #000000; text-align: right;">{{ $totalJpBadal }}</td>
        </tr>
    </tfoot>
</table>
</body>
</html>
