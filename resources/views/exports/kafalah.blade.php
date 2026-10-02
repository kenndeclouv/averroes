<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
@php
    $countInternal = count($sdmInternal);
    $countEksternal = count($sdmEksternal);

    $startInternal = 5;
    $endInternal   = 4 + $countInternal;
    $totalRowInternal = 5 + $countInternal;

    $startEksternal = $totalRowInternal + 5;
    $endEksternal   = $startEksternal + $countEksternal - 1;
    $totalRowEksternal = $endEksternal + 1;

    $grandTotalRow = $totalRowEksternal + 2;

    if ($countInternal > 0 && $countEksternal > 0) {
        $formulaT = "=T{$totalRowInternal}+T{$totalRowEksternal}";
        $formulaU = "=U{$totalRowInternal}+U{$totalRowEksternal}";
        $formulaV = "=V{$totalRowInternal}+V{$totalRowEksternal}";
    } elseif ($countInternal > 0) {
        $formulaT = "=T{$totalRowInternal}";
        $formulaU = "=U{$totalRowInternal}";
        $formulaV = "=V{$totalRowInternal}";
    } elseif ($countEksternal > 0) {
        $formulaT = "=T{$totalRowEksternal}";
        $formulaU = "=U{$totalRowEksternal}";
        $formulaV = "=V{$totalRowEksternal}";
    } else {
        $formulaT = 0;
        $formulaU = 0;
        $formulaV = 0;
    }
@endphp
<table>
    <thead>
        <tr>
            <th colspan="24" style="background-color: #E9C62C; font-weight: bold; text-align: center; font-size: 13px; border: 1px solid #000000;">
                SIMULASI / USULAN KAFALAH BULAN {{ $monthNameUpper }} {{ $year }} - AVERROES DIGITAL ISLAMIC SCHOOL
            </th>
        </tr>
    </thead>
    <tbody>

        {{-- ==================== SDM INTERNAL ==================== --}}
        <tr>
            <th colspan="24" style="background-color: #d0e8f4; font-weight: bold; text-align: center; border: 1px solid #000000;">SDM INTERNAL</th>
        </tr>

        {{-- Header Row 1 (merged group labels) --}}
        <tr>
            <th rowspan="2" style="background-color: #bdd7ee; font-weight: bold; border: 1px solid #000000; text-align: center;">NO</th>
            <th rowspan="2" style="background-color: #bdd7ee; font-weight: bold; border: 1px solid #000000; text-align: center;">NAMA</th>
            <th rowspan="2" style="background-color: #bdd7ee; font-weight: bold; border: 1px solid #000000; text-align: center;">AMANAH FUNGSIONAL</th>
            <th rowspan="2" style="background-color: #bdd7ee; font-weight: bold; border: 1px solid #000000; text-align: center;">HARI EFEKTIF</th>
            <th colspan="6" style="background-color: #bdd7ee; font-weight: bold; border: 1px solid #000000; text-align: center;">KEHADIRAN</th>
            <th rowspan="2" style="background-color: #bdd7ee; font-weight: bold; border: 1px solid #000000; text-align: center;">POTONGAN</th>
            <th rowspan="2" style="background-color: #bdd7ee; font-weight: bold; border: 1px solid #000000; text-align: center;">JP/PEKAN</th>
            <th rowspan="2" style="background-color: #bdd7ee; font-weight: bold; border: 1px solid #000000; text-align: center;">JP BADAL</th>
            <th colspan="2" style="background-color: #bdd7ee; font-weight: bold; border: 1px solid #000000; text-align: center;">TOTAL JP</th>
            <th colspan="4" style="background-color: #bdd7ee; font-weight: bold; border: 1px solid #000000; text-align: center;">RINCIAN KAFALAH</th>
            <th rowspan="2" style="background-color: #bdd7ee; font-weight: bold; border: 1px solid #000000; text-align: center;">TOTAL KAFALAH</th>
            <th rowspan="2" style="background-color: #bdd7ee; font-weight: bold; border: 1px solid #000000; text-align: center;">TAMBAHAN / KEGIATAN</th>
            <th rowspan="2" style="background-color: #bdd7ee; font-weight: bold; border: 1px solid #000000; text-align: center;">TOTAL</th>
            <th rowspan="2" style="background-color: #bdd7ee; font-weight: bold; border: 1px solid #000000; text-align: center;">NO REKENING</th>
            <th rowspan="2" style="background-color: #bdd7ee; font-weight: bold; border: 1px solid #000000; text-align: center;">BANK</th>
        </tr>
        {{-- Header Row 2 (sub-labels) --}}
        <tr>
            <th style="background-color: #bdd7ee; font-weight: bold; border: 1px solid #000000; text-align: center;">HARI LIBUR</th>
            <th style="background-color: #bdd7ee; font-weight: bold; border: 1px solid #000000; text-align: center;">IZIN</th>
            <th style="background-color: #bdd7ee; font-weight: bold; border: 1px solid #000000; text-align: center;">SAKIT</th>
            <th style="background-color: #bdd7ee; font-weight: bold; border: 1px solid #000000; text-align: center;">ALPHA</th>
            <th style="background-color: #bdd7ee; font-weight: bold; border: 1px solid #000000; text-align: center;">TOTAL</th>
            <th style="background-color: #bdd7ee; font-weight: bold; border: 1px solid #000000; text-align: center;">TOTAL TIDAK HADIR</th>
            <th style="background-color: #bdd7ee; font-weight: bold; border: 1px solid #000000; text-align: center;">JP REGULER</th>
            <th style="background-color: #bdd7ee; font-weight: bold; border: 1px solid #000000; text-align: center;">TOTAL JP</th>
            <th style="background-color: #bdd7ee; font-weight: bold; border: 1px solid #000000; text-align: center;">Mengajar</th>
            <th style="background-color: #bdd7ee; font-weight: bold; border: 1px solid #000000; text-align: center;">Fungsional</th>
            <th style="background-color: #bdd7ee; font-weight: bold; border: 1px solid #000000; text-align: center;">Transport</th>
            <th style="background-color: #bdd7ee; font-weight: bold; border: 1px solid #000000; text-align: center;">Gaji Pokok</th>
        </tr>

        {{-- Data Rows SDM Internal --}}
        @foreach($sdmInternal as $row)
        @php $r = 4 + $loop->iteration; @endphp
        <tr>
            <td style="border: 1px solid #000000; text-align: center;">{{ $row['no'] }}</td>
            <td style="border: 1px solid #000000;">{{ $row['name'] }}</td>
            <td style="border: 1px solid #000000;">{{ $row['jabatan'] }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ $row['hari_kerja'] }} Hari</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ $row['hari_libur'] }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ $row['izin'] }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ $row['sakit'] }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ $row['alpha'] }}</td>
            <td style="border: 1px solid #000000; text-align: center;">=F{{ $r }}+G{{ $r }}+H{{ $r }}</td>
            <td style="border: 1px solid #000000; text-align: center;">=I{{ $r }}</td>
            <td style="border: 1px solid #000000; text-align: right;">{{ $row['potongan'] }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ $row['jp_pekan'] }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ $row['jp_badal'] }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ $row['jp_pekan'] }}</td>
            <td style="border: 1px solid #000000; text-align: center; font-weight: bold;">=N{{ $r }}+M{{ $r }}</td>
            <td style="border: 1px solid #000000; text-align: right;">{{ $row['kafalah_mengajar'] }}</td>
            <td style="border: 1px solid #000000; text-align: right;">{{ $row['fungsional'] }}</td>
            <td style="border: 1px solid #000000; text-align: right;">{{ $row['transport'] }}</td>
            <td style="border: 1px solid #000000; text-align: right;">{{ $row['gaji_pokok'] }}</td>
            <td style="border: 1px solid #000000; text-align: right; font-weight: bold; background-color: #e6f2ff;">=P{{ $r }}+Q{{ $r }}+R{{ $r }}+S{{ $r }}-K{{ $r }}</td>
            <td style="border: 1px solid #000000; text-align: right;">{{ $row['tambahan'] ?: 0 }}</td>
            <td style="border: 1px solid #000000; text-align: right; font-weight: bold; background-color: #d9ead3;">=T{{ $r }}+U{{ $r }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ $row['no_rekening'] ?: '-' }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ $row['bank'] ?: '-' }}</td>
        </tr>
        @endforeach

        {{-- Total SDM Internal --}}
        @if($countInternal > 0)
        <tr>
            <th colspan="4" style="border: 1px solid #000000; font-weight: bold; text-align: right; background-color: #F4E295;">TOTAL</th>
            <th style="border: 1px solid #000000; background-color: #F4E295;"></th>
            <th style="border: 1px solid #000000; background-color: #F4E295; text-align: center;">=SUM(F{{ $startInternal }}:F{{ $endInternal }})</th>
            <th style="border: 1px solid #000000; background-color: #F4E295; text-align: center;">=SUM(G{{ $startInternal }}:G{{ $endInternal }})</th>
            <th style="border: 1px solid #000000; background-color: #F4E295; text-align: center;">=SUM(H{{ $startInternal }}:H{{ $endInternal }})</th>
            <th style="border: 1px solid #000000; background-color: #F4E295; text-align: center;">=SUM(I{{ $startInternal }}:I{{ $endInternal }})</th>
            <th style="border: 1px solid #000000; background-color: #F4E295; text-align: center;">=SUM(J{{ $startInternal }}:J{{ $endInternal }})</th>
            <th style="border: 1px solid #000000; background-color: #F4E295; text-align: right;">=SUM(K{{ $startInternal }}:K{{ $endInternal }})</th>
            <th style="border: 1px solid #000000; background-color: #F4E295; text-align: center;">=SUM(L{{ $startInternal }}:L{{ $endInternal }})</th>
            <th style="border: 1px solid #000000; background-color: #F4E295; text-align: center;">=SUM(M{{ $startInternal }}:M{{ $endInternal }})</th>
            <th style="border: 1px solid #000000; background-color: #F4E295; text-align: center;">=SUM(N{{ $startInternal }}:N{{ $endInternal }})</th>
            <th style="border: 1px solid #000000; background-color: #F4E295; text-align: center;">=SUM(O{{ $startInternal }}:O{{ $endInternal }})</th>
            <th style="border: 1px solid #000000; background-color: #F4E295; text-align: right;">=SUM(P{{ $startInternal }}:P{{ $endInternal }})</th>
            <th style="border: 1px solid #000000; background-color: #F4E295; text-align: right;">=SUM(Q{{ $startInternal }}:Q{{ $endInternal }})</th>
            <th style="border: 1px solid #000000; background-color: #F4E295; text-align: right;">=SUM(R{{ $startInternal }}:R{{ $endInternal }})</th>
            <th style="border: 1px solid #000000; background-color: #F4E295; text-align: right;">=SUM(S{{ $startInternal }}:S{{ $endInternal }})</th>
            <th style="border: 1px solid #000000; background-color: #F4E295; text-align: right; font-weight: bold;">=SUM(T{{ $startInternal }}:T{{ $endInternal }})</th>
            <th style="border: 1px solid #000000; background-color: #F4E295; text-align: right;">=SUM(U{{ $startInternal }}:U{{ $endInternal }})</th>
            <th style="border: 1px solid #000000; background-color: #F4E295; text-align: right; font-weight: bold;">=SUM(V{{ $startInternal }}:V{{ $endInternal }})</th>
            <th style="border: 1px solid #000000; background-color: #F4E295;"></th>
            <th style="border: 1px solid #000000; background-color: #F4E295;"></th>
        </tr>
        @endif

        {{-- ==================== SDM EKSTERNAL ==================== --}}
        <tr><td colspan="24"></td></tr>
        <tr>
            <th colspan="24" style="background-color: #d9ead3; font-weight: bold; text-align: center; border: 1px solid #000000;">SDM EKSTERNAL</th>
        </tr>

        {{-- Header Row 1 Eksternal --}}
        <tr>
            <th rowspan="2" style="background-color: #b7d7a8; font-weight: bold; border: 1px solid #000000; text-align: center;">NO</th>
            <th rowspan="2" style="background-color: #b7d7a8; font-weight: bold; border: 1px solid #000000; text-align: center;">NAMA</th>
            <th rowspan="2" style="background-color: #b7d7a8; font-weight: bold; border: 1px solid #000000; text-align: center;">AMANAH MENGAJAR</th>
            <th rowspan="2" style="background-color: #b7d7a8; font-weight: bold; border: 1px solid #000000; text-align: center;">HARI EFEKTIF</th>
            <th colspan="5" style="background-color: #b7d7a8; font-weight: bold; border: 1px solid #000000; text-align: center;">KEHADIRAN</th>
            <th rowspan="2" style="background-color: #b7d7a8; font-weight: bold; border: 1px solid #000000; text-align: center;">HARI LIBUR</th>
            <th rowspan="2" style="background-color: #b7d7a8; font-weight: bold; border: 1px solid #000000; text-align: center;">POTONGAN</th>
            <th rowspan="2" style="background-color: #b7d7a8; font-weight: bold; border: 1px solid #000000; text-align: center;">JP/BULAN</th>
            <th rowspan="2" style="background-color: #b7d7a8; font-weight: bold; border: 1px solid #000000; text-align: center;">BADAL</th>
            <th colspan="2" style="background-color: #b7d7a8; font-weight: bold; border: 1px solid #000000; text-align: center;">REALISASI MENGAJAR (JP/BULAN)</th>
            <th rowspan="2" style="background-color: #b7d7a8; font-weight: bold; border: 1px solid #000000; text-align: center;">KAFALAH @JP</th>
            <th rowspan="2" colspan="3" style="background-color: #b7d7a8; font-weight: bold; border: 1px solid #000000; text-align: center;">KAFALAH MENGAJAR</th>
            <th rowspan="2" style="background-color: #b7d7a8; font-weight: bold; border: 1px solid #000000; text-align: center;">TOTAL KAFALAH</th>
            <th rowspan="2" style="background-color: #b7d7a8; font-weight: bold; border: 1px solid #000000; text-align: center;">TAMBAHAN / KEGIATAN</th>
            <th rowspan="2" style="background-color: #b7d7a8; font-weight: bold; border: 1px solid #000000; text-align: center;">TOTAL</th>
            <th rowspan="2" style="background-color: #b7d7a8; font-weight: bold; border: 1px solid #000000; text-align: center;">NO REKENING</th>
            <th rowspan="2" style="background-color: #b7d7a8; font-weight: bold; border: 1px solid #000000; text-align: center;">BANK</th>
        </tr>
        {{-- Header Row 2 Eksternal --}}
        <tr>
            <th style="background-color: #b7d7a8; font-weight: bold; border: 1px solid #000000; text-align: center;">HARI LIBUR</th>
            <th style="background-color: #b7d7a8; font-weight: bold; border: 1px solid #000000; text-align: center;">IZIN</th>
            <th style="background-color: #b7d7a8; font-weight: bold; border: 1px solid #000000; text-align: center;">SAKIT</th>
            <th style="background-color: #b7d7a8; font-weight: bold; border: 1px solid #000000; text-align: center;">ALPHA</th>
            <th style="background-color: #b7d7a8; font-weight: bold; border: 1px solid #000000; text-align: center;">TOTAL</th>
            <th style="background-color: #b7d7a8; font-weight: bold; border: 1px solid #000000; text-align: center;">Mengajar</th>
            <th style="background-color: #b7d7a8; font-weight: bold; border: 1px solid #000000; text-align: center;">TOTAL JP</th>
        </tr>

        {{-- Data Rows SDM Eksternal --}}
        @foreach($sdmEksternal as $row)
        @php $r = $startEksternal + $loop->index; @endphp
        <tr>
            <td style="border: 1px solid #000000; text-align: center;">{{ $row['no'] }}</td>
            <td style="border: 1px solid #000000;">{{ $row['name'] }}</td>
            <td style="border: 1px solid #000000;">{{ $row['jabatan'] }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ $row['hari_kerja'] }} Hari</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ $row['hari_libur'] }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ $row['izin'] }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ $row['sakit'] }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ $row['alpha'] }}</td>
            <td style="border: 1px solid #000000; text-align: center;">=F{{ $r }}+G{{ $r }}+H{{ $r }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ $row['hari_libur'] }}</td>
            <td style="border: 1px solid #000000; text-align: right;">{{ $row['potongan'] }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ $row['target_jp'] }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ $row['jp_badal'] }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ $row['realisasi_jp'] }}</td>
            <td style="border: 1px solid #000000; text-align: center; font-weight: bold;">=N{{ $r }}+M{{ $r }}</td>
            <td style="border: 1px solid #000000; text-align: right;">{{ $row['rate_jp'] }}</td>
            <td colspan="3" style="border: 1px solid #000000; text-align: right;">=O{{ $r }}*P{{ $r }}</td>
            <td style="border: 1px solid #000000; text-align: right; font-weight: bold; background-color: #e6f2ff;">=Q{{ $r }}-K{{ $r }}</td>
            <td style="border: 1px solid #000000; text-align: right;">{{ $row['tambahan'] ?: 0 }}</td>
            <td style="border: 1px solid #000000; text-align: right; font-weight: bold; background-color: #d9ead3;">=T{{ $r }}+U{{ $r }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ $row['no_rekening'] ?: '-' }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ $row['bank'] ?: '-' }}</td>
        </tr>
        @endforeach

        {{-- Total SDM Eksternal --}}
        @if($countEksternal > 0)
        <tr>
            <th colspan="4" style="border: 1px solid #000000; font-weight: bold; text-align: right; background-color: #F4E295;">TOTAL</th>
            <th style="border: 1px solid #000000; background-color: #F4E295;"></th>
            <th style="border: 1px solid #000000; background-color: #F4E295; text-align: center;">=SUM(F{{ $startEksternal }}:F{{ $endEksternal }})</th>
            <th style="border: 1px solid #000000; background-color: #F4E295; text-align: center;">=SUM(G{{ $startEksternal }}:G{{ $endEksternal }})</th>
            <th style="border: 1px solid #000000; background-color: #F4E295; text-align: center;">=SUM(H{{ $startEksternal }}:H{{ $endEksternal }})</th>
            <th style="border: 1px solid #000000; background-color: #F4E295; text-align: center;">=SUM(I{{ $startEksternal }}:I{{ $endEksternal }})</th>
            <th style="border: 1px solid #000000; background-color: #F4E295;"></th>
            <th style="border: 1px solid #000000; background-color: #F4E295; text-align: right;">=SUM(K{{ $startEksternal }}:K{{ $endEksternal }})</th>
            <th style="border: 1px solid #000000; background-color: #F4E295; text-align: center;">=SUM(L{{ $startEksternal }}:L{{ $endEksternal }})</th>
            <th style="border: 1px solid #000000; background-color: #F4E295; text-align: center;">=SUM(M{{ $startEksternal }}:M{{ $endEksternal }})</th>
            <th style="border: 1px solid #000000; background-color: #F4E295; text-align: center;">=SUM(N{{ $startEksternal }}:N{{ $endEksternal }})</th>
            <th style="border: 1px solid #000000; background-color: #F4E295; text-align: center;">=SUM(O{{ $startEksternal }}:O{{ $endEksternal }})</th>
            <th style="border: 1px solid #000000; background-color: #F4E295;"></th>
            <th colspan="3" style="border: 1px solid #000000; background-color: #F4E295; text-align: right;">=SUM(Q{{ $startEksternal }}:Q{{ $endEksternal }})</th>
            <th style="border: 1px solid #000000; background-color: #F4E295; text-align: right; font-weight: bold;">=SUM(T{{ $startEksternal }}:T{{ $endEksternal }})</th>
            <th style="border: 1px solid #000000; background-color: #F4E295; text-align: right;">=SUM(U{{ $startEksternal }}:U{{ $endEksternal }})</th>
            <th style="border: 1px solid #000000; background-color: #F4E295; text-align: right; font-weight: bold;">=SUM(V{{ $startEksternal }}:V{{ $endEksternal }})</th>
            <th style="border: 1px solid #000000; background-color: #F4E295;"></th>
            <th style="border: 1px solid #000000; background-color: #F4E295;"></th>
        </tr>
        @endif

        {{-- Grand Total --}}
        <tr><td colspan="24"></td></tr>
        <tr>
            <th colspan="19" style="border: 1px solid #000000; font-weight: bold; text-align: right; background-color: #E9C62C;">Kafalah</th>
            <th style="border: 1px solid #000000; background-color: #E9C62C; text-align: right; font-weight: bold;">{{ $formulaT }}</th>
            <th style="border: 1px solid #000000; background-color: #E9C62C; text-align: right; font-weight: bold;">{{ $formulaU }}</th>
            <th style="border: 1px solid #000000; background-color: #E9C62C; text-align: right; font-weight: bold;">{{ $formulaV }}</th>
            <th style="border: 1px solid #000000; background-color: #E9C62C;"></th>
            <th style="border: 1px solid #000000; background-color: #E9C62C;"></th>
        </tr>

    </tbody>
</table>
</body>
</html>
