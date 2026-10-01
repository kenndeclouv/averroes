<table>
    <thead>
        <tr>
            <th colspan="7" style="background-color: #1a5e3a; color: white; font-weight: bold; text-align: center; font-size: 14px;">
                Jurnal Mengajar - {{ $name }} (Bulan {{ $monthYear }})
            </th>
        </tr>
        <tr>
            <th style="background-color: #f2f2f2; font-weight: bold; border: 1px solid #000000;">Tanggal</th>
            <th style="background-color: #f2f2f2; font-weight: bold; border: 1px solid #000000;">Subjek</th>
            <th style="background-color: #f2f2f2; font-weight: bold; border: 1px solid #000000;">Waktu Datang</th>
            <th style="background-color: #f2f2f2; font-weight: bold; border: 1px solid #000000;">Waktu Pulang</th>
            <th style="background-color: #f2f2f2; font-weight: bold; border: 1px solid #000000;">Keterangan</th>
            <th style="background-color: #f2f2f2; font-weight: bold; border: 1px solid #000000;">JP Reguler</th>
            <th style="background-color: #f2f2f2; font-weight: bold; border: 1px solid #000000;">JP Badal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($rows as $row)
        @php
            $cellBg = $row['isWeekend'] ? 'background-color: #ffff8e;' : '';
        @endphp
        <tr>
            <td style="border: 1px solid #000000; {{ $cellBg }}">{{ $row['date'] }}</td>
            <td style="border: 1px solid #000000; {{ $cellBg }}">{{ $row['subjects'] }}</td>
            <td style="border: 1px solid #000000; text-align: center; {{ $cellBg }}">{{ $row['datang'] ?? ($row['isWeekend'] ? '' : '-') }}</td>
            <td style="border: 1px solid #000000; text-align: center; {{ $cellBg }}">{{ $row['pulang'] ?? ($row['isWeekend'] ? '' : '-') }}</td>
            <td style="border: 1px solid #000000; text-align: center; {{ $row['keteranganBg'] ? 'background-color: ' . $row['keteranganBg'] . ';' : $cellBg }}">{{ $row['keterangan'] }}</td>
            <td style="border: 1px solid #000000; text-align: right; {{ $cellBg }}">{{ $row['jp_reguler'] ?: '' }}</td>
            <td style="border: 1px solid #000000; text-align: right; {{ $cellBg }}">{{ $row['jp_badal'] ?: '' }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5" style="background-color: #c6e0b4; font-weight: bold; border: 1px solid #000000;">Total</td>
            <td style="background-color: #c6e0b4; font-weight: bold; border: 1px solid #000000; text-align: right;">{{ $totalJpReguler }}</td>
            <td style="background-color: #c6e0b4; font-weight: bold; border: 1px solid #000000; text-align: right;">{{ $totalJpBadal }}</td>
        </tr>
    </tfoot>
</table>
