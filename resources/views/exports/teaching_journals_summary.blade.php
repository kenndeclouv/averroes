<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
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
                <td style="text-align: center; border: 1px solid #000000;">=SUM(C{{ $loop->iteration + 2 }},D{{ $loop->iteration + 2 }})</td>
            </tr>
        @endforeach
        <tr>
            <th colspan="2" style="font-weight: bold; text-align: right; border: 1px solid #000000; background-color: #F4E295;">Grand Total</th>
            <th style="font-weight: bold; text-align: center; border: 1px solid #000000; background-color: #F4E295;">=SUM(C3:C{{ count($summary) + 2 }})</th>
            <th style="font-weight: bold; text-align: center; border: 1px solid #000000; background-color: #F4E295;">=SUM(D3:D{{ count($summary) + 2 }})</th>
            <th style="font-weight: bold; text-align: center; border: 1px solid #000000; background-color: #F4E295;">=SUM(E3:E{{ count($summary) + 2 }})</th>
        </tr>

        <!-- Baris Kosong Pemisah -->
        <tr><td colspan="5"></td></tr>

        <!-- Legenda -->
        <tr>
            <th colspan="5" style="font-weight: bold; background-color: #d9d9d9; border: 1px solid #000000; text-align: left;">LEGENDA WARNA KETERANGAN ABSENSI</th>
        </tr>
        <tr>
            <td style="background-color: #ffff8e; text-align: center; border: 1px solid #000000;"></td>
            <td colspan="4" style="border: 1px solid #000000;">Libur Akhir Pekan (Sabtu / Minggu)</td>
        </tr>
        <tr>
            <td style="background-color: #ffe699; text-align: center; border: 1px solid #000000;"></td>
            <td colspan="4" style="border: 1px solid #000000;">Lupa Finger (Scan &lt; 2x / Tidak Finger Saat Mengajar)</td>
        </tr>
    </tbody>
</table>
</body>
</html>
