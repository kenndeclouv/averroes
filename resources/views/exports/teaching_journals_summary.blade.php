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

<table>
    <tr><td></td></tr>
    <tr>
        <th colspan="3" style="font-weight: bold; background-color: #d9d9d9; border: 1px solid #000000;">LEGENDA WARNA KETERANGAN ABSENSI</th>
    </tr>
    <tr>
        <td style="background-color: #ffff8e; text-align: center; border: 1px solid #000000;">Warna Kuning (Satu Baris)</td>
        <td colspan="2" style="border: 1px solid #000000;">Libur Akhir Pekan (Sabtu / Minggu)</td>
    </tr>
    <tr>
        <td style="background-color: #ffe699; text-align: center; border: 1px solid #000000;">Warna Oranye Soft</td>
        <td colspan="2" style="border: 1px solid #000000;">Lupa Finger (Scan < 2x / Tidak Finger Saat Mengajar)</td>
    </tr>
</table>
