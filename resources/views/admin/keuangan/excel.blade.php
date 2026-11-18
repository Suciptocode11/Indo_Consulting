<html xmlns:o="urn:schemas-microsoft-com:office:office"
      xmlns:x="urn:schemas-microsoft-com:office:excel"
      xmlns="http://www.w3.org/TR/REC-html40">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
@verbatim
    <!--[if gte mso 9]>
    <xml>
        <x:ExcelWorkbook>
            <x:ExcelWorksheets>
                <x:ExcelWorksheet>
                    <x:Name>Laporan Keuangan</x:Name>
                    <x:WorksheetOptions>
                        <x:DisplayGridlines/>
                    </x:WorksheetOptions>
                </x:ExcelWorksheet>
            </x:ExcelWorksheets>
        </x:ExcelWorkbook>
    </xml>
    <![endif]-->
@endverbatim
    <style>
        body, table {
            font-family: Calibri, 'Segoe UI', Arial, sans-serif;
            font-size: 11pt;
            color: #1e293b;
        }
        .header-title {
            font-size: 16pt;
            font-weight: bold;
            color: #040614;
        }
        .header-sub {
            font-size: 10pt;
            color: #64748b;
        }
        .table-data {
            border-collapse: collapse;
            width: 100%;
        }
        .table-data th {
            background-color: #040614;
            color: #ffffff;
            font-weight: bold;
            text-align: center;
            border: 1px solid #334155;
            padding: 8px 10px;
            vertical-align: middle;
        }
        .table-data td {
            border: 1px solid #cbd5e1;
            padding: 6px 10px;
            vertical-align: middle;
        }
        .text-center { text-align: center; }
        .text-right  { text-align: right; }
        .text-left   { text-align: left; }
        
        .badge-masuk {
            color: #15803d;
            font-weight: bold;
        }
        .badge-keluar {
            color: #b91c1c;
            font-weight: bold;
        }
        .nominal-in {
            color: #16a34a;
            font-weight: bold;
            mso-number-format: "\#\,\#\#0";
        }
        .nominal-out {
            color: #dc2626;
            font-weight: bold;
            mso-number-format: "\#\,\#\#0";
        }
        .text-format {
            mso-number-format: "\@";
        }
        .date-format {
            mso-number-format: "dd\/mm\/yyyy";
            text-align: center;
        }
        .row-even {
            background-color: #f8fafc;
        }
        .summary-title {
            font-weight: bold;
            background-color: #f1f5f9;
            border: 1px solid #cbd5e1;
        }
        .summary-val-in {
            font-weight: bold;
            color: #16a34a;
            background-color: #f0fdf4;
            border: 1px solid #cbd5e1;
            text-align: right;
            mso-number-format: "\#\,\#\#0";
        }
        .summary-val-out {
            font-weight: bold;
            color: #dc2626;
            background-color: #fef2f2;
            border: 1px solid #cbd5e1;
            text-align: right;
            mso-number-format: "\#\,\#\#0";
        }
        .summary-val-net {
            font-weight: bold;
            color: #2563eb;
            background-color: #eff6ff;
            border: 1px solid #cbd5e1;
            text-align: right;
            mso-number-format: "\#\,\#\#0";
        }
    </style>
</head>
<body>
    <table>
        <tr>
            <td colspan="12" class="header-title">{{ $pengaturan->company ?? 'INDO CONSULTING' }}</td>
        </tr>
        <tr>
            <td colspan="12" style="font-weight: bold; font-size: 13pt; color: #bb0027;">LAPORAN ARUS KAS & TRANSAKSI KEUANGAN</td>
        </tr>
        <tr>
            <td colspan="12" class="header-sub">
                Periode: {{ \Carbon\Carbon::parse($dateStart)->format('d/m/Y') }} s/d {{ \Carbon\Carbon::parse($dateEnd)->format('d/m/Y') }}
                | Dicetak pada: {{ now()->translatedFormat('d F Y, H:i') }}
            </td>
        </tr>
        <tr><td colspan="12"></td></tr>
    </table>

    <table class="table-data">
        <thead>
            <tr>
                <th style="width: 40px;">No</th>
                <th style="width: 140px;">Kode Transaksi</th>
                <th style="width: 90px;">Tanggal</th>
                <th style="width: 100px;">Tipe</th>
                <th style="width: 160px;">Kategori</th>
                <th style="width: 180px;">Program / Layanan</th>
                <th style="width: 260px;">Judul / Keperluan Transaksi</th>
                <th style="width: 180px;">Penerima / Vendor</th>
                <th style="width: 130px;">Nominal (Rp)</th>
                <th style="width: 110px;">Metode</th>
                <th style="width: 120px;">Status</th>
                <th style="width: 220px;">Deskripsi / Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @php
                $no = 1;
                $totMasuk = 0;
                $totKeluar = 0;
            @endphp
            @forelse($transaksis as $index => $trx)
                @php
                    if ($trx->status === 'lunas') {
                        if ($trx->tipe === 'pemasukan') $totMasuk += $trx->nominal;
                        else $totKeluar += $trx->nominal;
                    }
                @endphp
                <tr class="{{ $index % 2 == 1 ? 'row-even' : '' }}">
                    <td class="text-center">{{ $no++ }}</td>
                    <td class="text-format" style="font-weight: 500; color: #bb0027;">{{ $trx->kode_transaksi }}</td>
                    <td class="date-format">{{ $trx->tanggal->format('d/m/Y') }}</td>
                    <td class="text-center">
                        <span class="{{ $trx->tipe === 'pemasukan' ? 'badge-masuk' : 'badge-keluar' }}">
                            {{ $trx->tipe === 'pemasukan' ? 'Pemasukan' : 'Pengeluaran' }}
                        </span>
                    </td>
                    <td>{{ $trx->kategori?->nama ?? '-' }}</td>
                    <td>{{ $trx->service?->title ?? '-' }}</td>
                    <td>{{ $trx->judul }}</td>
                    <td>{{ $trx->penerima ?? '-' }}</td>
                    <td class="{{ $trx->tipe === 'pemasukan' ? 'nominal-in' : 'nominal-out' }}">
                        {{ $trx->nominal }}
                    </td>
                    <td class="text-center">{{ $trx->metode_pembayaran }}</td>
                    <td class="text-center" style="font-weight: bold; color: {{ $trx->status === 'lunas' ? '#16a34a' : '#d97706' }};">
                        {{ $trx->status === 'lunas' ? 'Lunas' : 'Menunggu' }}
                    </td>
                    <td>{{ $trx->keterangan ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="12" class="text-center" style="padding: 20px; color: #94a3b8;">
                        Tidak ada transaksi pada periode ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr><td colspan="12" style="border: none; height: 10px;"></td></tr>
            <tr>
                <td colspan="8" class="summary-title" style="text-align: right; font-size: 11pt;">TOTAL PEMASUKAN (LUNAS):</td>
                <td class="summary-val-in" style="font-size: 11pt;">{{ $totMasuk }}</td>
                <td colspan="3" class="summary-title"></td>
            </tr>
            <tr>
                <td colspan="8" class="summary-title" style="text-align: right; font-size: 11pt;">TOTAL PENGELUARAN (LUNAS):</td>
                <td class="summary-val-out" style="font-size: 11pt;">{{ $totKeluar }}</td>
                <td colspan="3" class="summary-title"></td>
            </tr>
            <tr>
                <td colspan="8" class="summary-title" style="text-align: right; font-size: 11pt;">SALDO BERSIH (KAS RIIL):</td>
                <td class="summary-val-net" style="font-size: 11pt;">{{ $totMasuk - $totKeluar }}</td>
                <td colspan="3" class="summary-title"></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
