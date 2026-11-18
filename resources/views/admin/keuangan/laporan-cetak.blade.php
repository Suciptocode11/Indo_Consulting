<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan - {{ \Carbon\Carbon::parse($dateStart)->translatedFormat('d M Y') }} sd {{ \Carbon\Carbon::parse($dateEnd)->translatedFormat('d M Y') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Outfit', sans-serif;
            background: #f8fafc;
            color: #0f172a;
            padding: 24px;
            font-size: 12px;
        }
        .container {
            max-width: 1040px;
            margin: 0 auto;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 32px 36px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.04);
        }
        .no-print-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding: 12px 18px;
            background: #0f172a;
            color: #ffffff;
            border-radius: 10px;
        }
        .btn-print {
            background: #bb0027;
            color: #fff;
            border: none;
            padding: 8px 18px;
            border-radius: 6px;
            font-weight: 700;
            font-size: 13px;
            cursor: pointer;
        }
        .header-kop {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #0f172a;
            padding-bottom: 18px;
            margin-bottom: 20px;
        }
        .kop-brand h1 {
            font-size: 20px;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.3px;
        }
        .kop-brand p {
            font-size: 11px;
            color: #64748b;
            margin-top: 2px;
        }
        .kop-meta {
            text-align: right;
            font-size: 11px;
            color: #475569;
        }
        .doc-title {
            text-align: center;
            margin: 20px 0 16px;
        }
        .doc-title h2 {
            font-size: 16px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #0f172a;
        }
        .doc-title p {
            font-size: 12px;
            color: #64748b;
            margin-top: 3px;
        }

        /* KPI Ringkasan */
        .kpi-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 24px;
        }
        .kpi-box {
            padding: 12px 14px;
            border-radius: 8px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
        }
        .kpi-box-label {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            color: #64748b;
            letter-spacing: 0.4px;
        }
        .kpi-box-val {
            font-size: 16px;
            font-weight: 800;
            margin-top: 4px;
        }
        .val-in { color: #16a34a; }
        .val-out { color: #dc2626; }
        .val-pip { color: #d97706; }
        .val-selisih { color: #2563eb; }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
            margin-bottom: 24px;
        }
        th, td {
            padding: 8px 10px;
            border: 1px solid #cbd5e1;
            text-align: left;
        }
        th {
            background: #f1f5f9;
            color: #334155;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 10px;
            letter-spacing: 0.3px;
        }
        tr:nth-child(even) td {
            background: #fafafa;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }

        .badge-lunas {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 9px;
            font-weight: 700;
            background: #dcfce7;
            color: #15803d;
        }
        .badge-piutang {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 9px;
            font-weight: 700;
            background: #fef3c7;
            color: #b45309;
        }

        /* Signatures */
        .sig-row {
            display: flex;
            justify-content: space-between;
            margin-top: 36px;
            padding: 0 40px;
        }
        .sig-box {
            text-align: center;
            width: 200px;
        }
        .sig-space {
            height: 60px;
        }

        @media print {
            body { background: #fff; padding: 0; }
            .no-print-bar { display: none !important; }
            .container { border: none; box-shadow: none; padding: 0; max-width: 100%; }
            @page { margin: 15mm; size: landscape; }
        }
    </style>
</head>
<body>
    <div class="container">
        {{-- Tombol Tindakan Cetak / Save as PDF (Tidak tercetak di kertas) --}}
        <div class="no-print-bar">
            <div>
                <strong>Laporan Siap Cetak / Unduh PDF</strong>
                <span style="font-size: 11px; color: #94a3b8; margin-left: 8px;">Gunakan menu "Save as PDF" di dialog browser untuk menyimpan sebagai file PDF.</span>
            </div>
            <div style="display: flex; gap: 8px;">
                <button type="button" class="btn-print" onclick="window.print()">Cetak / Simpan PDF</button>
                <button type="button" onclick="window.close()" style="background:transparent; color:#fff; border:1px solid #475569; padding:8px 14px; border-radius:6px; cursor:pointer;">Tutup</button>
            </div>
        </div>

        {{-- Kop Perusahaan --}}
        <div class="header-kop">
            <div class="kop-brand">
                <h1>{{ $pengaturan->site_name ?? 'INDO CONSULTING UTAMA' }}</h1>
                <p>Konsultan Manajemen, Bisnis &amp; Legalitas Usaha Terpercaya</p>
                <p style="color: #94a3b8; font-size: 10px;">{{ $pengaturan->alamat ?? 'Indonesia' }} · Telp: {{ $pengaturan->whatsapp_number ?? '-' }}</p>
            </div>
            <div class="kop-meta">
                <div>Dicetak Tanggal: <strong>{{ now()->translatedFormat('d F Y, H:i') }}</strong></div>
                <div>Oleh: <strong>{{ auth()->user()->name ?? 'Administrator' }}</strong></div>
            </div>
        </div>

        {{-- Judul Dokumen --}}
        <div class="doc-title">
            <h2>Laporan Keuangan &amp; Arus Kas</h2>
            <p>Periode: <strong>{{ \Carbon\Carbon::parse($dateStart)->translatedFormat('d F Y') }}</strong> s/d <strong>{{ \Carbon\Carbon::parse($dateEnd)->translatedFormat('d F Y') }}</strong></p>
        </div>

        {{-- Ringkasan 4 Kartu KPI: Pemasukan -> Pengeluaran -> Piutang -> Selisih --}}
        <div class="kpi-row">
            <div class="kpi-box">
                <div class="kpi-box-label">Total Pemasukan</div>
                <div class="kpi-box-val val-in">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</div>
            </div>
            <div class="kpi-box">
                <div class="kpi-box-label">Total Pengeluaran</div>
                <div class="kpi-box-val val-out">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</div>
            </div>
            <div class="kpi-box">
                <div class="kpi-box-label">Piutang</div>
                <div class="kpi-box-val val-pip">Rp {{ number_format($totalPiutang, 0, ',', '.') }}</div>
            </div>
            <div class="kpi-box">
                <div class="kpi-box-label">Selisih (Saldo Kas)</div>
                <div class="kpi-box-val val-selisih">Rp {{ number_format($selisih, 0, ',', '.') }}</div>
            </div>
        </div>

        {{-- Tabel Rincian Transaksi --}}
        <table>
            <thead>
                <tr>
                    <th style="width: 30px;" class="text-center">No</th>
                    <th style="width: 95px;">Kode</th>
                    <th style="width: 75px;">Tanggal</th>
                    <th style="width: 75px;">Transaksi</th>
                    <th style="width: 100px;">Kategori</th>
                    <th style="width: 110px;">Program / Proyek</th>
                    <th>Deskripsi</th>
                    <th style="width: 80px;" class="text-center">Vol &amp; Satuan</th>
                    <th style="width: 105px;" class="text-right">Nominal (Rp)</th>
                    <th style="width: 60px;" class="text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksis as $idx => $t)
                    <tr>
                        <td class="text-center">{{ $idx + 1 }}</td>
                        <td style="font-family: monospace; font-weight: 600;">{{ $t->kode_transaksi }}</td>
                        <td>{{ $t->tanggal->format('d/m/Y') }}</td>
                        <td style="font-weight: 600; color: {{ $t->tipe === 'pemasukan' ? '#16a34a' : '#dc2626' }};">
                            {{ $t->tipe === 'pemasukan' ? 'Pemasukan' : 'Pengeluaran' }}
                        </td>
                        <td>{{ $t->kategori?->nama ?? '—' }}</td>
                        <td>{{ $t->proyekKlien?->nama_proyek ?? ($t->service?->title ?? 'Umum') }}</td>
                        <td>
                            <strong>{{ $t->deskripsi ?: $t->judul }}</strong>
                        </td>
                        <td class="text-center">{{ $t->volume ?? 1 }} {{ ucfirst($t->satuan ?? 'paket') }}</td>
                        <td class="text-right" style="font-weight: 700; color: {{ $t->tipe === 'pemasukan' ? '#16a34a' : '#dc2626' }};">
                            {{ $t->tipe === 'pemasukan' ? '+' : '-' }}{{ number_format($t->nominal, 0, ',', '.') }}
                        </td>
                        <td class="text-center">
                            @if($t->status === 'lunas')
                                <span class="badge-lunas">Lunas</span>
                            @else
                                <span class="badge-piutang">Piutang</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center" style="padding: 24px; color: #94a3b8;">
                            Tidak ada transaksi pada periode yang dipilih.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Tanda Tangan Pengesahan --}}
        <div class="sig-row">
            <div class="sig-box">
                <div>Mengetahui,</div>
                <div style="font-size: 11px; color:#64748b;">Direktur Utama</div>
                <div class="sig-space"></div>
                <div style="font-weight: 700; text-decoration: underline;">( ........................................ )</div>
            </div>
            <div class="sig-box">
                <div>Dibuat Oleh,</div>
                <div style="font-size: 11px; color:#64748b;">Administrasi Keuangan</div>
                <div class="sig-space"></div>
                <div style="font-weight: 700; text-decoration: underline;">{{ auth()->user()->name ?? '( ........................................ )' }}</div>
            </div>
        </div>
    </div>
</body>
</html>

