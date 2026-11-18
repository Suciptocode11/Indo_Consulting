@extends('admin.layouts.app')

@section('title', 'Detail Transaksi')
@section('page-title', 'Manajemen Keuangan')

@section('content')
<div style="max-width: 680px;">
    <div style="margin-bottom: 16px; display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
        <a href="{{ route('admin.keuangan.index') }}" class="btn btn-secondary btn-sm"
           style="display:inline-flex; align-items:center; gap:5px;">
            <span class="material-symbols-outlined" style="font-size:15px;">arrow_back</span> Kembali
        </a>
        <a href="{{ route('admin.keuangan.edit', $keuangan) }}" class="btn btn-secondary btn-sm"
           style="display:inline-flex; align-items:center; gap:5px;">
            <span class="material-symbols-outlined" style="font-size:15px;">edit</span> Edit
        </a>
    </div>

    <div class="card">
        {{-- Header --}}
        <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:20px; flex-wrap:wrap; gap:10px;">
            <div>
                <div style="font-size:11px; color:#94a3b8; margin-bottom:4px;">Kode Transaksi</div>
                <code style="font-size:14px; color:#bb0027; background:#fff5f5; padding:3px 10px; border-radius:6px; font-weight:700;">
                    {{ $keuangan->kode_transaksi }}
                </code>
            </div>
            <div style="display:flex; gap:8px; align-items:center;">
                <span style="padding:5px 12px; border-radius:8px; font-size:12px; font-weight:600;
                    {{ $keuangan->tipe === 'pemasukan' ? 'background:#dcfce7; color:#15803d; border:1px solid #bbf7d0;' : 'background:#fee2e2; color:#b91c1c; border:1px solid #fecaca;' }}
                    display:inline-flex; align-items:center; gap:5px;">
                    <span class="material-symbols-outlined" style="font-size:14px;">
                        {{ $keuangan->tipe === 'pemasukan' ? 'arrow_downward' : 'arrow_upward' }}
                    </span>
                    {{ $keuangan->tipe === 'pemasukan' ? 'Pemasukan' : 'Pengeluaran' }}
                </span>
                <span style="padding:5px 12px; border-radius:8px; font-size:12px; font-weight:600;
                    {{ $keuangan->status === 'lunas' ? 'background:#dcfce7; color:#16a34a; border:1px solid #bbf7d0;' : 'background:#fef9c3; color:#a16207; border:1px solid #fef08a;' }}
                    display:inline-flex; align-items:center; gap:5px;">
                    <span class="material-symbols-outlined" style="font-size:14px;">
                        {{ $keuangan->status === 'lunas' ? 'check_circle' : 'schedule' }}
                    </span>
                    {{ $keuangan->status === 'lunas' ? 'Lunas' : 'Piutang' }}
                </span>
            </div>
        </div>

        {{-- Nominal besar --}}
        <div style="text-align:center; padding:24px 20px; background: {{ $keuangan->tipe === 'pemasukan' ? '#f0fdf4' : '#fef2f2' }}; border-radius:12px; margin-bottom:24px;">
            <div style="font-size:11px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.5px; margin-bottom:8px;">Nominal</div>
            <div style="font-size:32px; font-weight:800; color: {{ $keuangan->tipe === 'pemasukan' ? '#16a34a' : '#dc2626' }}; letter-spacing:-0.5px;">
                {{ $keuangan->tipe === 'pemasukan' ? '+' : '-' }}Rp {{ number_format($keuangan->nominal, 0, ',', '.') }}
            </div>
            <div style="font-size:12px; color:#64748b; margin-top:6px; font-style:italic;">
                # {{ $keuangan->terbilang }} #
            </div>
        </div>

        {{-- Detail fields --}}
        <dl style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
            <div>
                <dt style="font-size:11px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.4px; margin-bottom:4px;">Tanggal</dt>
                <dd style="font-size:14px; color:#0f172a;">{{ $keuangan->tanggal->translatedFormat('d F Y') }}</dd>
            </div>
            <div>
                <dt style="font-size:11px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.4px; margin-bottom:4px;">Metode Pembayaran</dt>
                <dd style="font-size:14px; color:#0f172a;">{{ $keuangan->metode_pembayaran }}</dd>
            </div>
            <div>
                <dt style="font-size:11px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.4px; margin-bottom:4px;">Kategori</dt>
                <dd style="font-size:14px; color:#0f172a;">{{ $keuangan->kategori?->nama ?? '—' }}</dd>
            </div>
            <div>
                <dt style="font-size:11px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.4px; margin-bottom:4px;">
                    {{ $keuangan->tipe === 'pemasukan' ? 'Program yang Dibayarkan' : 'Program Terkait' }}
                </dt>
                <dd style="font-size:14px; color:#0f172a;">{{ $keuangan->service?->title ?? '—' }}</dd>
            </div>
            @if($keuangan->proyekKlien)
            <div>
                <dt style="font-size:11px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.4px; margin-bottom:4px;">Proyek Klien Terkait</dt>
                <dd style="font-size:14px; color:#0f172a;">
                    <a href="{{ route('admin.keuangan.proyek.show', $keuangan->proyekKlien->id) }}" style="color:#bb0027; text-decoration:none; font-weight:600;">
                        {{ $keuangan->proyekKlien->nama_proyek }} ({{ $keuangan->proyekKlien->nama_klien }})
                    </a>
                </dd>
            </div>
            @endif
            @if($keuangan->volume && $keuangan->harga_satuan)
            <div>
                <dt style="font-size:11px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.4px; margin-bottom:4px;">Vol & Satuan</dt>
                <dd style="font-size:14px; color:#0f172a;">{{ $keuangan->volume }} {{ ucfirst($keuangan->satuan ?? 'paket') }} &times; Rp {{ number_format($keuangan->harga_satuan, 0, ',', '.') }}</dd>
            </div>
            @endif
            @if($keuangan->penerima)
            <div>
                <dt style="font-size:11px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.4px; margin-bottom:4px;">Penerima / Vendor</dt>
                <dd style="font-size:14px; color:#0f172a;">{{ $keuangan->penerima }}</dd>
            </div>
            @endif
            <div style="grid-column: span 2;">
                <dt style="font-size:11px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.4px; margin-bottom:4px;">Deskripsi</dt>
                <dd style="font-size:14px; color:#0f172a; font-weight:500;">{{ $keuangan->deskripsi ?: $keuangan->judul }}</dd>
            </div>
            <div>
                <dt style="font-size:11px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.4px; margin-bottom:4px;">Dicatat oleh</dt>
                <dd style="font-size:13px; color:#0f172a;">{{ $keuangan->createdBy?->nama ?? $keuangan->createdBy?->name ?? '—' }}</dd>
            </div>
            <div>
                <dt style="font-size:11px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.4px; margin-bottom:4px;">Dicatat pada</dt>
                <dd style="font-size:13px; color:#0f172a;">{{ $keuangan->created_at->translatedFormat('d F Y, H:i') }}</dd>
            </div>
        </dl>

        {{-- Bukti Foto / Dokumen --}}
        @if($keuangan->bukti)
        <div style="margin-top:20px; padding-top:20px; border-top:1px solid #f1f5f9;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
                <div style="font-size:11px; font-weight:700; color:#475569; text-transform:uppercase; letter-spacing:.4px; display:flex; align-items:center; gap:5px;">
                    <span class="material-symbols-outlined" style="font-size:16px; color:#bb0027;">photo_camera</span>
                    Bukti / Foto Pembayaran
                </div>
                <a href="{{ asset('storage/' . $keuangan->bukti) }}" target="_blank"
                   style="font-size:12px; font-weight:600; color:#4f46e5; text-decoration:none; display:inline-flex; align-items:center; gap:4px;">
                    <span class="material-symbols-outlined" style="font-size:15px;">open_in_new</span> Buka File Penuh
                </a>
            </div>
            @php $ext = strtolower(pathinfo($keuangan->bukti, PATHINFO_EXTENSION)); @endphp
            @if(in_array($ext, ['jpg','jpeg','png','webp']))
                <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:12px; padding:12px; text-align:center;">
                    <a href="{{ asset('storage/' . $keuangan->bukti) }}" target="_blank" title="Klik untuk memperbesar">
                        <img src="{{ asset('storage/' . $keuangan->bukti) }}" alt="Bukti Pembayaran"
                             style="max-width:100%; max-height:360px; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,0.06); object-fit:contain;">
                    </a>
                    <div style="font-size:11px; color:#64748b; margin-top:8px;">
                        {{ basename($keuangan->bukti) }} · Klik gambar untuk membuka ukuran penuh
                    </div>
                </div>
            @else
                <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:12px; padding:16px; display:flex; align-items:center; gap:12px;">
                    <div style="width:48px; height:48px; border-radius:8px; background:#fee2e2; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                        <span class="material-symbols-outlined" style="font-size:28px; color:#dc2626;">picture_as_pdf</span>
                    </div>
                    <div style="flex:1;">
                        <div style="font-size:13px; font-weight:600; color:#0f172a;">{{ basename($keuangan->bukti) }}</div>
                        <div style="font-size:11px; color:#64748b;">Dokumen PDF Bukti Pembayaran</div>
                    </div>
                    <a href="{{ asset('storage/' . $keuangan->bukti) }}" target="_blank"
                       class="btn btn-secondary btn-sm" style="display:inline-flex; align-items:center; gap:5px;">
                        <span class="material-symbols-outlined" style="font-size:16px;">download</span> Unduh PDF
                    </a>
                </div>
            @endif
        </div>
        @endif

        {{-- Tandai Lunas --}}
        @if($keuangan->status === 'pending')
        <div style="margin-top:20px; padding-top:20px; border-top:1px solid #f1f5f9;">
            <form method="POST" action="{{ route('admin.keuangan.tandai-lunas', $keuangan) }}">
                @csrf
                <button type="submit" class="btn btn-primary"
                    style="background:#16a34a; border-color:#16a34a; display:inline-flex; align-items:center; gap:6px;"
                    onclick="return confirm('Tandai transaksi ini sebagai Lunas?')">
                    <span class="material-symbols-outlined" style="font-size:16px;">check_circle</span>
                    Tandai Lunas
                </button>
            </form>
        </div>
        @endif
    </div>
</div>
@endsection

