<table>
    <thead>
        <tr>
            <th colspan="8" style="background-color: #1a5e3a; color: white; font-weight: bold; text-align: center; font-size: 14px;">
                Jurnal Mengajar Bulan {{ $monthYear }}
            </th>
        </tr>
        <tr>
            <th style="background-color: #f2f2f2; font-weight: bold; border: 1px solid #000000;">Tanggal</th>
            <th style="background-color: #f2f2f2; font-weight: bold; border: 1px solid #000000;">Guru</th>
            <th style="background-color: #f2f2f2; font-weight: bold; border: 1px solid #000000;">Subjek</th>
            <th style="background-color: #f2f2f2; font-weight: bold; border: 1px solid #000000;">Waktu Datang</th>
            <th style="background-color: #f2f2f2; font-weight: bold; border: 1px solid #000000;">Waktu Pulang</th>
            <th style="background-color: #f2f2f2; font-weight: bold; border: 1px solid #000000;">Keterangan</th>
            <th style="background-color: #f2f2f2; font-weight: bold; border: 1px solid #000000;">JP Reguler</th>
            <th style="background-color: #f2f2f2; font-weight: bold; border: 1px solid #000000;">JP Badal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($journals as $journal)
        @php
            $keteranganBg = '';
            if ($journal->keterangan == 'BELUM ADA FINGER') {
                $keteranganBg = 'background-color: #f4b084;';
            } elseif ($journal->keterangan == 'LUPA FINGER') {
                $keteranganBg = 'background-color: #ffe699;';
            }
        @endphp
        <tr>
            <td style="border: 1px solid #000000;">{{ formatDate($journal->date) }}</td>
            <td style="border: 1px solid #000000;">{{ $journal->teacher->name }}</td>
            <td style="border: 1px solid #000000;">
                {{ $journal->teachingSubjects->pluck('name')->implode(', ') }}
            </td>
            <td style="border: 1px solid #000000; text-align: center;">{{ $journal->datang ?? '-' }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ $journal->pulang ?? '-' }}</td>
            <td style="border: 1px solid #000000; text-align: center; {{ $keteranganBg }}">{{ $journal->keterangan }}</td>
            <td style="border: 1px solid #000000; text-align: right;">{{ $journal->total_regular_hours }}</td>
            <td style="border: 1px solid #000000; text-align: right;">{{ $journal->total_replacement_hours }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="6" style="background-color: #c6e0b4; font-weight: bold; border: 1px solid #000000;">Total</td>
            <td style="background-color: #c6e0b4; font-weight: bold; border: 1px solid #000000; text-align: right;">
                {{ $journals->sum('total_regular_hours') }}
            </td>
            <td style="background-color: #c6e0b4; font-weight: bold; border: 1px solid #000000; text-align: right;">
                {{ $journals->sum('total_replacement_hours') }}
            </td>
        </tr>
    </tfoot>
</table>
