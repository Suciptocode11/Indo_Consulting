<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $keuangan->tipe === 'pemasukan' ? 'Invoice' : 'Voucher Pengeluaran' }} - {{ $keuangan->kode_transaksi }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Outfit', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f1f5f9;
            color: #0f172a;
            padding: 24px 0 40px;
            font-size: 13px;
            line-height: 1.5;
        }

        /* ── Action bar (layar saja) ────────────────────────── */
        .print-bar {
            max-width: 800px;
            margin: 0 auto 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 18px;
            background: #040614;
            color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 14px rgba(0,0,0,0.15);
        }
        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 8px;
            font-family: 'Outfit', sans-serif;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.15s;
            border: none;
        }
        .btn-print {
            background: #bb0027;
            color: #fff;
        }
        .btn-print:hover {
            background: #990020;
        }
        .btn-back {
            background: rgba(255,255,255,0.15);
            color: #fff;
        }
        .btn-back:hover {
            background: rgba(255,255,255,0.25);
        }

        /* ── Kertas Dokumen (A4) ───────────────────────────── */
        .document-page {
            max-width: 800px;
            margin: 0 auto;
            background: #ffffff;
            padding: 48px 52px;
            border-radius: 8px;
            box-shadow: 0 2px 20px rgba(0,0,0,0.06);
            position: relative;
        }

        /* ── Kop Surat ─────────────────────────────────────── */
        .kop-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding-bottom: 20px;
            border-bottom: 3px solid #bb0027;
            margin-bottom: 28px;
            position: relative;
        }
        .kop-logo-wrap {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .kop-logo {
            max-height: 55px;
            width: auto;
            object-fit: contain;
        }
        .kop-company-title {
            font-size: 20px;
            font-weight: 800;
            color: #040614;
            letter-spacing: -0.3px;
            text-transform: uppercase;
        }
        .kop-company-tagline {
            font-size: 11px;
            color: #bb0027;
            font-weight: 600;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            margin-top: 1px;
        }
        .kop-contact {
            text-align: right;
            font-size: 11px;
            color: #475569;
            line-height: 1.5;
            max-width: 280px;
        }

        /* ── Judul Dokumen & Stamp ─────────────────────────── */
        .doc-title-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 24px;
        }
        .doc-title {
            font-size: 20px;
            font-weight: 800;
            color: #040614;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .doc-subtitle {
            font-size: 12px;
            color: #64748b;
            margin-top: 2px;
        }

        /* Stamp Badge */
        .stamp-box {
            padding: 8px 16px;
            border: 2px dashed;
            border-radius: 8px;
            text-align: center;
            text-transform: uppercase;
            font-size: 13px;
            font-weight: 800;
            letter-spacing: 1px;
            transform: rotate(-3deg);
            display: inline-block;
        }
        .stamp-lunas {
            border-color: #16a34a;
            color: #16a34a;
            background: #f0fdf4;
        }
        .stamp-pending {
            border-color: #d97706;
            color: #d97706;
            background: #fffbeb;
        }

        /* ── Grid Metadata Transaksi ───────────────────────── */
        .meta-grid {
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            gap: 20px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 18px 20px;
            margin-bottom: 28px;
        }
        .meta-col dt {
            font-size: 10px;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 2px;
        }
        .meta-col dd {
            font-size: 13px;
            font-weight: 600;
            color: #0f172a;
            margin-bottom: 12px;
        }
        .meta-col dd:last-child {
            margin-bottom: 0;
        }

        /* ── Tabel Rincian Biaya ────────────────────────────── */
        .table-items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }
        .table-items th {
            background: #040614;
            color: #ffffff;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 12px 14px;
            text-align: left;
        }
        .table-items th:last-child {
            text-align: right;
        }
        .table-items td {
            padding: 14px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 13px;
            vertical-align: top;
        }
        .table-items td:last-child {
            text-align: right;
            font-weight: 700;
            color: #0f172a;
        }
        .table-items tfoot td {
            padding: 14px;
            border-bottom: none;
        }
        .total-row {
            background: #f8fafc;
            border-top: 2px solid #040614;
        }
        .total-row .total-label {
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-align: right;
            padding-right: 18px;
        }
        .total-row .total-val {
            font-size: 18px;
            font-weight: 800;
            color: #bb0027;
            text-align: right;
        }

        /* ── Terbilang Box ──────────────────────────────────── */
        .terbilang-box {
            background: #fef2f2;
            border-left: 4px solid #bb0027;
            padding: 12px 16px;
            margin-bottom: 24px;
            border-radius: 0 8px 8px 0;
        }
        .terbilang-label {
            font-size: 10px;
            font-weight: 700;
            color: #991b1b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 3px;
        }
        .terbilang-text {
            font-size: 13px;
            font-weight: 600;
            color: #0f172a;
            font-style: italic;
        }

        /* ── Catatan ────────────────────────────────────────── */
        .notes-box {
            font-size: 12px;
            color: #64748b;
            margin-bottom: 36px;
            line-height: 1.6;
        }
        .notes-box strong {
            color: #334155;
        }

        /* ── Tanda Tangan ───────────────────────────────────── */
        .signature-row {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
            padding-top: 20px;
        }
        .sig-col {
            text-align: center;
            width: 200px;
        }
        .sig-role {
            font-size: 11px;
            color: #64748b;
            margin-bottom: 60px;
            font-weight: 500;
        }
        .sig-name {
            font-size: 13px;
            font-weight: 700;
            color: #0f172a;
            border-bottom: 1px solid #94a3b8;
            padding-bottom: 4px;
        }
        .sig-sub {
            font-size: 10px;
            color: #94a3b8;
            margin-top: 2px;
        }

        /* ── Footer Dokumen ─────────────────────────────────── */
        .doc-footer {
            margin-top: 40px;
            padding-top: 14px;
            border-top: 1px solid #f1f5f9;
            font-size: 10px;
            color: #94a3b8;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* ── Media Print (Saat Cetak / PDF) ─────────────────── */
        @media print {
            body {
                background: #ffffff;
                padding: 0;
            }
            .no-print {
                display: none !important;
            }
            .document-page {
                box-shadow: none;
                padding: 24px 30px;
                max-width: 100%;
            }
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            @page {
                size: A4;
                margin: 12mm;
            }
        }
    </style>
</head>
<body>

    <!-- ── Bar Tombol Aksi (Layar Saja) ────────────────── -->
    <div class="print-bar no-print">
        <div style="display:flex; align-items:center; gap:8px;">
            <span class="material-symbols-outlined" style="font-size:20px; color:#fb7185;">receipt_long</span>
            <span style="font-weight:600; font-size:13px;">Preview Dokumen Keuangan</span>
        </div>
        <div style="display:flex; gap:8px;">
            <button type="button" class="btn-action btn-print" onclick="window.print()">
                <span class="material-symbols-outlined" style="font-size:16px;">print</span>
                Cetak Dokumen (Print / PDF)
            </button>
            <a href="{{ $keuangan->id ? route('admin.keuangan.show', $keuangan) : route('admin.keuangan.index') }}"
               class="btn-action btn-back"
               onclick="if(window.opener || window.history.length > 1){ window.close(); return false; }">
                <span class="material-symbols-outlined" style="font-size:16px;">arrow_back</span>
                Kembali
            </a>
        </div>
    </div>

    <!-- ── Halaman Dokumen A4 ───────────────────────────── -->
    <div class="document-page">

        <!-- 1. Kop Surat Resmi -->
        <div class="kop-header">
            <div class="kop-logo-wrap">
                @if(!empty($pengaturan?->logo) && \Illuminate\Support\Facades\Storage::disk('public')->exists($pengaturan->logo))
                    <img src="{{ asset('storage/' . $pengaturan->logo) }}" alt="{{ $pengaturan->company ?? 'Indo Consulting' }}" class="kop-logo">
                @else
                    <img src="{{ asset('images/logo.png') }}" alt="Indo Consulting" class="kop-logo" onerror="this.style.display='none'">
                @endif
                <div>
                    <h1 class="kop-company-title">{{ $pengaturan->company ?? 'INDO CONSULTING' }}</h1>
                    <div class="kop-company-tagline">Management & Business Consulting Services</div>
                </div>
            </div>
            <div class="kop-contact">
                <div>{{ $pengaturan->address ?? 'Jakarta, Indonesia' }}</div>
                @if(!empty($pengaturan?->phone))
                    <div>Telp: {{ $pengaturan->phone }}</div>
                @endif
                @if(!empty($pengaturan?->email))
                    <div>Email: {{ $pengaturan->email }}</div>
                @endif
                @if(!empty($pengaturan?->website))
                    <div>{{ $pengaturan->website }}</div>
                @endif
            </div>
        </div>

        <!-- 2. Judul Dokumen & Stamp -->
        <div class="doc-title-row">
            <div>
                <div class="doc-title">
                    {{ $keuangan->tipe === 'pemasukan' ? 'BUKTI PEMBAYARAN / INVOICE' : 'BUKTI PENGELUARAN KAS (VOUCHER)' }}
                </div>
                <div class="doc-subtitle">
                    {{ $keuangan->tipe === 'pemasukan' ? 'Official Payment Receipt & Billing Statement' : 'Internal Cash Disbursement Voucher' }}
                </div>
            </div>
            <div>
                @if($keuangan->status === 'lunas')
                    <div class="stamp-box stamp-lunas">
                        LUNAS / PAID
                    </div>
                @else
                    <div class="stamp-box stamp-pending">
                        PIUTANG / BELUM LUNAS
                    </div>
                @endif
            </div>
        </div>

        <!-- 3. Grid Metadata Transaksi -->
        <div class="meta-grid">
            <div class="meta-col">
                @if($keuangan->tipe === 'pemasukan')
                    <dt>Diterima Dari / Klien</dt>
                    <dd style="font-size:14px; font-weight:700;">{{ $keuangan->judul }}</dd>
                    
                    <dt>Program / Layanan</dt>
                    <dd>{{ $keuangan->service?->title ?? 'Layanan Konsultasi Umum' }}</dd>
                @else
                    <dt>Dibayarkan Kepada (Penerima / Vendor)</dt>
                    <dd style="font-size:14px; font-weight:700;">{{ $keuangan->penerima ?: '—' }}</dd>

                    <dt>Keperluan Pengeluaran</dt>
                    <dd>{{ $keuangan->judul }}</dd>
                @endif
            </div>
            <div class="meta-col">
                <dt>No. Transaksi</dt>
                <dd><code style="font-family:monospace; color:#bb0027; font-weight:700;">{{ $keuangan->kode_transaksi }}</code></dd>

                <dt>Tanggal Transaksi</dt>
                <dd>{{ $keuangan->tanggal->translatedFormat('d F Y') }}</dd>

                <dt>Metode Pembayaran</dt>
                <dd>{{ $keuangan->metode_pembayaran }}</dd>

                <dt>Kategori</dt>
                <dd>{{ $keuangan->kategori?->nama ?? '—' }}</dd>
            </div>
        </div>

        <!-- 4. Tabel Rincian Item Transaksi -->
        <table class="table-items">
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>Deskripsi / Uraian</th>
                    <th>Kategori / Program</th>
                    <th style="width: 180px;">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>
                        <div style="font-weight: 700; color: #0f172a; margin-bottom: 3px;">
                            {{ $keuangan->judul }}
                        </div>
                        @if($keuangan->penerima && $keuangan->tipe === 'pengeluaran')
                            <div style="font-size: 11px; color: #64748b;">
                                Penerima: <strong>{{ $keuangan->penerima }}</strong>
                            </div>
                        @endif
                        @if($keuangan->keterangan)
                            <div style="font-size: 11px; color: #64748b; margin-top: 4px;">
                                Deskripsi: {{ $keuangan->keterangan }}
                            </div>
                        @endif
                    </td>
                    <td>
                        <div>{{ $keuangan->kategori?->nama ?? '—' }}</div>
                        @if($keuangan->service)
                            <div style="font-size: 11px; color: #64748b;">
                                Ref: {{ $keuangan->service->title }}
                            </div>
                        @endif
                    </td>
                    <td>Rp {{ number_format($keuangan->nominal, 0, ',', '.') }}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td colspan="3" class="total-label">TOTAL JUMLAH:</td>
                    <td class="total-val">Rp {{ number_format($keuangan->nominal, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>

        <!-- 5. Terbilang Box -->
        <div class="terbilang-box">
            <div class="terbilang-label">Terbilang:</div>
            <div class="terbilang-text"># {{ $keuangan->terbilang }} #</div>
        </div>

        <!-- 6. Catatan -->
        <div class="notes-box">
            <strong>Catatan:</strong>
            @if($keuangan->tipe === 'pemasukan')
                Dokumen ini merupakan bukti resmi pembayaran transaksi jasa konsultasi Indo Consulting. Pembayaran yang telah lunas tidak dapat dibatalkan tanpa persetujuan tertulis dari manajemen.
            @else
                Voucher ini merupakan bukti sah pengeluaran kas operasional / proyek Indo Consulting yang telah disetujui oleh pejabat berwenang.
            @endif
        </div>

        <!-- 7. Tanda Tangan -->
        <div class="signature-row">
            <div class="sig-col">
                <div class="sig-role">
                    {{ $keuangan->tipe === 'pemasukan' ? 'Penerima Pembayaran / Klien' : 'Penerima Uang / Vendor' }},
                </div>
                <div class="sig-name">
                    {{ $keuangan->tipe === 'pemasukan' ? ($keuangan->penerima ?: 'Klien / Mitra') : ($keuangan->penerima ?: 'Penerima Dana') }}
                </div>
                <div class="sig-sub">Tanda Tangan & Nama Terang</div>
            </div>
            <div class="sig-col">
                <div class="sig-role">
                    Jakarta, {{ $keuangan->tanggal->translatedFormat('d F Y') }}<br>
                    Bagian Keuangan / Otorisasi,
                </div>
                <div class="sig-name">
                    {{ $keuangan->createdBy?->nama ?? $keuangan->createdBy?->name ?? 'Admin Keuangan' }}
                </div>
                <div class="sig-sub">{{ $pengaturan->company ?? 'Indo Consulting' }}</div>
            </div>
        </div>

        <!-- 8. Footer -->
        <div class="doc-footer">
            <div>Dokumen Resmi Sistem Manajemen Keuangan · {{ $pengaturan->company ?? 'Indo Consulting' }}</div>
            <div>Dicetak: {{ now()->translatedFormat('d/m/Y H:i') }} | ID: {{ $keuangan->kode_transaksi }}</div>
        </div>
    </div>

</body>
</html>
