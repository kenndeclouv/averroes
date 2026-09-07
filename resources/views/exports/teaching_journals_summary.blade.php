<table>
    <thead>
        <tr>
            <th colspan="5" style="background-color: #E9C62C; text-align: center; font-weight: bold; font-size: 14px;">
                Rangkuman Jurnal Mengajar Bulan {{ $monthYear }}
            </th>
        </tr>
        <tr>
            <th style="font-weight: bold; text-align: center; border: 1px solid #000000;">No</th>
            <th style="font-weight: bold; text-align: center; border: 1px solid #000000;">Guru</th>
            <th style="font-weight: bold; text-align: center; border: 1px solid #000000;">Total JP Reguler</th>
            <th style="font-weight: bold; text-align: center; border: 1px solid #000000;">Total JP Badal</th>
            <th style="font-weight: bold; text-align: center; border: 1px solid #000000;">Total Keseluruhan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($summary as $index => $row)
            <tr>
                <td style="text-align: center; border: 1px solid #000000;">{{ $index + 1 }}</td>
                <td style="border: 1px solid #000000;">=HYPERLINK("#'{{ $row['sheet_name'] }}'!A1", "{{ $row['nama'] }}")</td>
                <td style="text-align: center; border: 1px solid #000000;">{{ $row['total_reguler'] }}</td>
                <td style="text-align: center; border: 1px solid #000000;">{{ $row['total_badal'] }}</td>
                <td style="text-align: center; border: 1px solid #000000;">{{ $row['total_keseluruhan'] }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th colspan="2" style="font-weight: bold; text-align: right; border: 1px solid #000000; background-color: #F4E295;">Grand Total</th>
            <th style="font-weight: bold; text-align: center; border: 1px solid #000000; background-color: #F4E295;">{{ collect($summary)->sum('total_reguler') }}</th>
            <th style="font-weight: bold; text-align: center; border: 1px solid #000000; background-color: #F4E295;">{{ collect($summary)->sum('total_badal') }}</th>
            <th style="font-weight: bold; text-align: center; border: 1px solid #000000; background-color: #F4E295;">{{ collect($summary)->sum('total_keseluruhan') }}</th>
        </tr>
    </tfoot>
</table>
