<table>
    <thead>
        <tr>
            <th colspan="5" style="background-color: #1a5e3a; color: white; font-weight: bold; text-align: center; font-size: 14px;">
                Jurnal Mengajar Bulan {{ $monthYear }}
            </th>
        </tr>
        <tr>
            <th style="background-color: #f2f2f2; font-weight: bold; border: 1px solid #000000;">Tanggal</th>
            <th style="background-color: #f2f2f2; font-weight: bold; border: 1px solid #000000;">Guru</th>
            <th style="background-color: #f2f2f2; font-weight: bold; border: 1px solid #000000;">Subjek</th>
            <th style="background-color: #f2f2f2; font-weight: bold; border: 1px solid #000000;">JP Reguler</th>
            <th style="background-color: #f2f2f2; font-weight: bold; border: 1px solid #000000;">JP Badal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($journals as $journal)
        <tr>
            <td style="border: 1px solid #000000;">{{ formatDate($journal->date) }}</td>
            <td style="border: 1px solid #000000;">{{ $journal->teacher->name }}</td>
            <td style="border: 1px solid #000000;">
                {{ $journal->teachingSubjects->pluck('name')->implode(', ') }}
            </td>
            <td style="border: 1px solid #000000; text-align: right;">{{ $journal->total_regular_hours }}</td>
            <td style="border: 1px solid #000000; text-align: right;">{{ $journal->total_replacement_hours }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3" style="background-color: #c6e0b4; font-weight: bold; border: 1px solid #000000;">Total</td>
            <td style="background-color: #c6e0b4; font-weight: bold; border: 1px solid #000000; text-align: right;">
                {{ $journals->sum('total_regular_hours') }}
            </td>
            <td style="background-color: #c6e0b4; font-weight: bold; border: 1px solid #000000; text-align: right;">
                {{ $journals->sum('total_replacement_hours') }}
            </td>
        </tr>
    </tfoot>
</table>
