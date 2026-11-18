@extends('admin.layouts.app')

@section('title', 'Detail Kontrak Klien - ' . $proyek->nama_proyek)
@section('page-title', 'Detail Kontrak Klien')

@push('styles')
<style>
    /* ── Header & Info Card ──────────────────────────────────────── */
    .proj-hero {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 24px 28px;
        margin-bottom: 24px;
        position: relative;
    }
    .proj-hero-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 16px;
        flex-wrap: wrap;
    }
    .proj-code-badge {
        font-family: monospace;
        font-size: 11px;
        font-weight: 700;
        padding: 3px 8px;
        background: #f1f5f9;
        color: #475569;
        border-radius: 6px;
        display: inline-block;
        margin-bottom: 6px;
    }
    .proj-hero-title {
        font-size: 20px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 8px;
        line-height: 1.25;
    }
    .proj-hero-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
        font-size: 13px;
        color: #64748b;
    }
    .proj-meta-item {
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .proj-meta-item .material-symbols-outlined { font-size: 16px; color: #94a3b8; }
    
    .proj-hero-actions {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    /* ── KPI Cards ───────────────────────────────────────────────── */
    .keu-kpi-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 14px; margin-bottom: 24px; }
    .keu-kpi { background: #fff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 18px 20px; position: relative; overflow: hidden; }
    .keu-kpi::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; border-radius: 14px 14px 0 0; }
    .keu-kpi.contract::before { background: linear-gradient(90deg, #6366f1, #4f46e5); }
    .keu-kpi.in::before       { background: linear-gradient(90deg, #22c55e, #16a34a); }
    .keu-kpi.pip::before      { background: linear-gradient(90deg, #f59e0b, #d97706); }
    .keu-kpi.out::before      { background: linear-gradient(90deg, #ef4444, #dc2626); }
    .keu-kpi.net::before      { background: linear-gradient(90deg, #3b82f6, #2563eb); }
    
    .keu-kpi-label { font-size: 11px; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px; }
    .keu-kpi-value { font-size: 20px; font-weight: 700; color: #0f172a; line-height: 1.1; word-break: break-word; }
    .keu-kpi-sub   { font-size: 11px; color: #64748b; margin-top: 8px; display: flex; align-items: center; gap: 4px; flex-wrap: wrap; }

    /* ── Percentage Pills ────────────────────────────────────────── */
    .pct-pill {
        display: inline-flex; align-items: center; gap: 3px;
        padding: 2px 7px; border-radius: 20px; font-size: 11px; font-weight: 700;
    }
    .pct-pill-green  { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
    .pct-pill-red    { background: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; }
    .pct-pill-amber  { background: #fef3c7; color: #b45309; border: 1px solid #fde68a; }
    .pct-pill-blue   { background: #dbeafe; color: #1d4ed8; border: 1px solid #bfdbfe; }
    .pct-pill-purple { background: #ede9fe; color: #6d28d9; border: 1px solid #ddd6fe; }

    /* Progress bar */
    .progress-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 16px 20px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
    }
    .progress-bar-wrap { flex: 1; min-width: 200px; }
    .progress-bar-track { height: 10px; background: #f1f5f9; border-radius: 20px; overflow: hidden; }
    .progress-bar-fill  { height: 100%; border-radius: 20px; background: linear-gradient(90deg, #22c55e, #16a34a); transition: width .5s ease; }

    /* ── Action Buttons ──────────────────────────────────────────── */
    .btn-quick-in {
        display: inline-flex; align-items: center; justify-content: center; gap: 6px;
        padding: 9px 20px; border-radius: 10px;
        background: #16a34a; color: #fff; font-size: 13px; font-weight: 700;
        border: none; cursor: pointer; transition: all .15s;
        box-shadow: 0 1px 2px rgba(22, 163, 74, 0.2);
    }
    .btn-quick-in:hover {
        background: #15803d;
        box-shadow: 0 4px 12px rgba(22, 163, 74, 0.3);
    }
    .btn-quick-out {
        display: inline-flex; align-items: center; justify-content: center; gap: 6px;
        padding: 9px 20px; border-radius: 10px;
        background: #dc2626; color: #fff; font-size: 13px; font-weight: 700;
        border: none; cursor: pointer; transition: all .15s;
        box-shadow: 0 1px 2px rgba(220, 38, 38, 0.2);
    }
    .btn-quick-out:hover {
        background: #b91c1c;
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
    }
    .btn-secondary {
        display: inline-flex; align-items: center; gap: 5px; padding: 7px 14px; border-radius: 9px;
        background: #f1f5f9; color: #475569; font-size: 12px; font-weight: 600; text-decoration: none; border: 1px solid #e2e8f0;
        transition: background .15s; cursor: pointer;
    }
    .btn-secondary:hover { background: #e2e8f0; color: #0f172a; }

    /* ── Tables ──────────────────────────────────────────────────── */
    .table-section {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        overflow: hidden;
        margin-bottom: 24px;
    }
    .table-section-header {
        padding: 16px 20px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }
    .table-section-title {
        font-size: 15px;
        font-weight: 700;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .table-section table { width: 100%; min-width: 880px; border-collapse: collapse; }
    .table-responsive { width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; }
    .table-section thead th {
        background: #f8fafc; padding: 11px 16px; text-align: left;
        font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;
        border-bottom: 1px solid #e2e8f0; white-space: nowrap;
    }
    .table-section tbody tr { border-bottom: 1px solid #f1f5f9; transition: background .15s; }
    .table-section tbody tr:last-child { border-bottom: none; }
    .table-section tbody tr:hover { background: #fafafa; }
    .table-section td { padding: 12px 16px; font-size: 13px; color: #334155; vertical-align: middle; }

    .badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 9px; border-radius: 20px; font-size: 11px; font-weight: 700; }
    .badge-green  { background: #dcfce7; color: #15803d; }
    .badge-blue   { background: #dbeafe; color: #1d4ed8; }
    .badge-amber  { background: #fef3c7; color: #b45309; }
    .badge-red    { background: #fee2e2; color: #b91c1c; }
    .badge-gray   { background: #f1f5f9; color: #64748b; }

    /* Modal Backdrop */
    .modal-overlay {
        position: fixed; inset: 0; background: rgba(15,23,42,.6);
        display: flex; align-items: center; justify-content: center; z-index: 9999;
        backdrop-filter: blur(4px);
        padding: 16px;
    }
    .modal-box {
        background: #fff; border-radius: 16px; width: 100%; max-width: 620px;
        max-height: calc(100vh - 40px);
        box-shadow: 0 25px 50px -12px rgba(0,0,0,.3);
        display: flex; flex-direction: column;
        overflow: hidden;
        margin: auto;
        animation: modalFadeIn .18s ease-out;
    }
    .modal-box form {
        display: flex;
        flex-direction: column;
        max-height: calc(100vh - 40px);
        height: 100%;
        min-height: 0;
        overflow: hidden;
        margin: 0;
    }
    @keyframes modalFadeIn {
        from { opacity: 0; transform: scale(0.97); }
        to { opacity: 1; transform: scale(1); }
    }
    .modal-head {
        padding: 16px 22px; border-bottom: 1px solid #e2e8f0;
        display: flex; justify-content: space-between; align-items: center;
        flex-shrink: 0;
        background: #fff;
    }
    .modal-head h3 {
        margin: 0; font-size: 16px; font-weight: 700; color: #0f172a;
        display: flex; align-items: center; gap: 8px;
    }
    .modal-close {
        width: 32px; height: 32px; border-radius: 8px; background: #f1f5f9; border: none;
        cursor: pointer; color: #64748b; font-size: 18px;
        display: flex; align-items: center; justify-content: center;
        transition: all .15s; line-height: 1;
    }
    .modal-close:hover { background: #fee2e2; color: #dc2626; }
    .modal-body {
        padding: 20px 22px;
        overflow-y: auto;
        flex: 1 1 auto;
        min-height: 0;
        max-height: calc(100vh - 160px);
        overscroll-behavior: contain;
    }
    .modal-body::-webkit-scrollbar { width: 6px; }
    .modal-body::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
    .modal-foot {
        padding: 14px 22px; background: #f8fafc; border-top: 1px solid #e2e8f0;
        display: flex; justify-content: flex-end; align-items: center; gap: 10px;
        flex-shrink: 0;
        box-shadow: 0 -4px 12px rgba(0,0,0,0.03);
    }
    .modal-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px 14px;
        margin-bottom: 12px;
    }
    @media (max-width: 600px) {
        .modal-grid-2 { grid-template-columns: 1fr; }
    }
    .modal-body .form-group { display: flex; flex-direction: column; gap: 5px; margin-bottom: 12px; }
    .modal-body label { font-size: 11px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.3px; }
    .modal-body .form-control {
        padding: 9px 12px; border: 1px solid #cbd5e1; border-radius: 8px;
        font-family: 'Outfit', sans-serif; font-size: 13px; color: #0f172a;
        transition: border-color .15s, box-shadow .15s;
    }
    .modal-body .form-control:focus {
        outline: none; border-color: #bb0027; box-shadow: 0 0 0 3px rgba(187,0,39,.1);
    }
    .input-group-rp {
        display: flex;
        align-items: stretch;
        width: 100%;
    }
    .input-group-addon-rp {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0 14px;
        background: #f1f5f9;
        color: #475569;
        font-weight: 700;
        font-size: 13px;
        border: 1px solid #cbd5e1;
        border-right: none;
        border-radius: 8px 0 0 8px;
        user-select: none;
        flex-shrink: 0;
    }
    .input-group-field-rp {
        flex: 1;
        border-radius: 0 8px 8px 0 !important;
        border: 1px solid #cbd5e1;
        padding: 9px 12px;
        font-size: 13px;
        font-family: 'Outfit', sans-serif;
        outline: none;
        background: #fff;
        color: #0f172a;
        font-weight: 600;
        transition: border-color .15s, box-shadow .15s;
        width: 100%;
    }
    .input-group-field-rp:focus {
        border-color: #bb0027;
        box-shadow: 0 0 0 3px rgba(187,0,39,.1);
    }
    .modal-foot {
        padding: 14px 22px; background: #f8fafc; border-top: 1px solid #e2e8f0;
        display: flex; justify-content: flex-end; gap: 10px;
        flex-shrink: 0;
    }
</style>
@endpush

@section('content')
<div>
    {{-- Alerts --}}
    @if(session('success'))
        <div style="background:#dcfce7;border:1px solid #bbf7d0;color:#15803d;padding:12px 16px;border-radius:10px;margin-bottom:20px;font-size:13px;display:flex;align-items:center;gap:8px;">
            <span class="material-symbols-outlined" style="font-size:18px;">check_circle</span>
            {{ session('success') }}
        </div>
    @endif

    {{-- Breadcrumb & Back --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
        <div style="font-size:12px;color:#94a3b8;display:flex;align-items:center;gap:6px;">
            <a href="{{ route('admin.keuangan.program.index') }}#daftar-kontrak" style="color:#64748b;text-decoration:none;">Keuangan Program & Kontrak</a>
            <span>/</span>
            <span style="color:#0f172a;font-weight:600;">{{ Str::limit($proyek->nama_proyek, 40) }}</span>
        </div>
        <a href="{{ route('admin.keuangan.program.index') }}#daftar-kontrak" class="btn-secondary">
            <span class="material-symbols-outlined" style="font-size:16px;">arrow_back</span>
            Daftar Kontrak
        </a>
    </div>

    {{-- Proyek Hero Card --}}
    <div class="proj-hero">
        <div class="proj-hero-top">
            <div style="flex:1;">
                <div class="proj-code-badge">{{ $proyek->kode_proyek }}</div>
                <h1 class="proj-hero-title">{{ $proyek->nama_proyek }}</h1>
                <div class="proj-hero-meta">
                    <span class="proj-meta-item">
                        <span class="material-symbols-outlined">domain</span>
                        <strong>{{ $proyek->nama_klien }}</strong>
                    </span>
                    @if($proyek->pic)
                    <span class="proj-meta-item">
                        <span class="material-symbols-outlined">person</span>
                        PIC: <strong>{{ $proyek->pic }}</strong>
                    </span>
                    @endif
                    @if($proyek->kontak_klien)
                    <span class="proj-meta-item">
                        <span class="material-symbols-outlined">contact_phone</span>
                        {{ $proyek->kontak_klien }}
                    </span>
                    @endif
                    @if($proyek->service)
                    <span class="proj-meta-item">
                        <span class="material-symbols-outlined">library_books</span>
                        {{ $proyek->service->title }}
                    </span>
                    @endif
                    <span class="proj-meta-item">
                        <span class="material-symbols-outlined">calendar_today</span>
                        {{ $proyek->tanggal_mulai ? $proyek->tanggal_mulai->format('d M Y') : '-' }}
                        @if($proyek->tanggal_selesai)
                            s/d {{ $proyek->tanggal_selesai->format('d M Y') }}
                        @endif
                    </span>
                    <span class="proj-meta-item">
                        @php $badge = $proyek->status_badge; @endphp
                        <span class="badge {{ $badge['class'] }}">
                            <span class="material-symbols-outlined" style="font-size:12px;">{{ $badge['icon'] }}</span>
                            {{ $badge['label'] }}
                        </span>
                    </span>
                </div>
                @if($proyek->keterangan)
                    <div style="margin-top:12px;font-size:12px;color:#64748b;background:#f8fafc;padding:10px 14px;border-radius:8px;border-left:3px solid #cbd5e1;">
                        {{ $proyek->keterangan }}
                    </div>
                @endif
            </div>

            <div class="proj-hero-actions">
                <a href="{{ route('admin.keuangan.kontrak.edit', $proyek->id) }}" class="btn-secondary">
                    <span class="material-symbols-outlined" style="font-size:15px;">edit</span>
                    Edit Kontrak
                </a>
                <form method="POST" action="{{ route('admin.keuangan.kontrak.destroy', $proyek->id) }}"
                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus kontrak klien ini? Transaksi pembayaran terkait akan tetap disimpan di buku kas umum.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-secondary" style="color:#dc2626;cursor:pointer;">
                        <span class="material-symbols-outlined" style="font-size:15px;">delete</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Financial KPI Cards (5 Cards) --}}
    @php
        $inflow   = $proyek->total_pemasukan;
        $outflow  = $proyek->total_pengeluaran;
        $sisa     = $proyek->sisa_tagihan;
        $laba     = $proyek->laba_bersih;
        $progress = $proyek->progress_pembayaran;
        $pctSisa  = (float)$proyek->nilai_kontrak > 0 ? round(($sisa / (float)$proyek->nilai_kontrak) * 100, 1) : 0;
        $pctOut   = $inflow > 0 ? round(($outflow / $inflow) * 100, 1) : 0;
        $pctLaba  = $inflow > 0 ? round(($laba / $inflow) * 100, 1) : 0;
    @endphp
    <div class="keu-kpi-grid">
        <div class="keu-kpi contract">
            <div class="keu-kpi-label">Nilai Kontrak</div>
            <div class="keu-kpi-value">Rp {{ number_format($proyek->nilai_kontrak, 0, ',', '.') }}</div>
            <div class="keu-kpi-sub">
                <span class="pct-pill pct-pill-purple">
                    <span class="material-symbols-outlined" style="font-size:12px;">handshake</span>
                    100% Target
                </span>
                <span>Nilai komitmen SPK</span>
            </div>
        </div>
        <div class="keu-kpi in">
            <div class="keu-kpi-label">Uang Diterima</div>
            <div class="keu-kpi-value" style="color:#16a34a;">Rp {{ number_format($inflow, 0, ',', '.') }}</div>
            <div class="keu-kpi-sub">
                <span class="pct-pill pct-pill-green">
                    <span class="material-symbols-outlined" style="font-size:12px;">arrow_upward</span>
                    {{ $progress }}%
                </span>
                <span>tercairkan dari kontrak</span>
            </div>
        </div>
        <div class="keu-kpi out">
            <div class="keu-kpi-label">Pengeluaran</div>
            <div class="keu-kpi-value" style="color:#dc2626;">Rp {{ number_format($outflow, 0, ',', '.') }}</div>
            <div class="keu-kpi-sub">
                <span class="pct-pill pct-pill-red">
                    <span class="material-symbols-outlined" style="font-size:12px;">arrow_downward</span>
                    {{ $pctOut }}%
                </span>
                <span>rasio biaya operasional</span>
            </div>
        </div>
        <div class="keu-kpi pip">
            <div class="keu-kpi-label">Piutang</div>
            <div class="keu-kpi-value" style="color:#d97706;">Rp {{ number_format($sisa, 0, ',', '.') }}</div>
            <div class="keu-kpi-sub">
                <span class="pct-pill pct-pill-amber">
                    <span class="material-symbols-outlined" style="font-size:12px;">schedule</span>
                    {{ $pctSisa }}%
                </span>
                <span>belum dilunasi klien</span>
            </div>
        </div>
        <div class="keu-kpi net">
            <div class="keu-kpi-label">Selisih</div>
            <div class="keu-kpi-value" style="color:{{ $laba >= 0 ? '#2563eb' : '#dc2626' }};">
                {{ $laba < 0 ? '-' : '' }}Rp {{ number_format(abs($laba), 0, ',', '.') }}
            </div>
            <div class="keu-kpi-sub">
                <span class="pct-pill {{ $laba >= 0 ? 'pct-pill-blue' : 'pct-pill-red' }}">
                    <span class="material-symbols-outlined" style="font-size:12px;">{{ $laba >= 0 ? 'trending_up' : 'trending_down' }}</span>
                    {{ number_format(abs($pctLaba), 1) }}%
                </span>
                <span>margin kas penugasan</span>
            </div>
        </div>
    </div>

    {{-- Progress Bar Pembayaran & Quick Action Buttons --}}
    <div class="progress-card">
        <div class="progress-bar-wrap">
            <div style="display:flex;justify-content:space-between;font-size:12px;font-weight:600;margin-bottom:6px;color:#334155;">
                <span>Realisasi Pembayaran Termin Klien</span>
                <span>{{ $progress }}% (Rp {{ number_format($inflow, 0, ',', '.') }} / Rp {{ number_format($proyek->nilai_kontrak, 0, ',', '.') }})</span>
            </div>
            <div class="progress-bar-track">
                <div class="progress-bar-fill" style="width: {{ $progress }}%;"></div>
            </div>
        </div>
        <div style="display:flex;gap:10px;">
            <button type="button" class="btn-quick-in" onclick="openModal('modalInflow')">
                <span class="material-symbols-outlined" style="font-size:18px;">add_circle</span>
                + Pemasukan
            </button>
            <button type="button" class="btn-quick-out" onclick="openModal('modalOutflow')">
                <span class="material-symbols-outlined" style="font-size:18px;">remove_circle</span>
                + Pengeluaran
            </button>
        </div>
    </div>

    {{-- Bagian 1: Pemasukan --}}
    <div class="table-section">
        <div class="table-section-header">
            <div class="table-section-title">
                <span class="material-symbols-outlined" style="color:#22c55e;">payments</span>
                Pemasukan
            </div>
            <div style="font-size:12px;color:#64748b;">
                Total: <strong style="color:#16a34a;">Rp {{ number_format($inflow, 0, ',', '.') }}</strong> ({{ $pemasukanList->count() }} transaksi)
            </div>
        </div>

        @if($pemasukanList->isEmpty())
            <div style="text-align:center;padding:40px 20px;color:#94a3b8;font-size:13px;">
                <span class="material-symbols-outlined" style="font-size:36px;display:block;margin-bottom:6px;">receipt_long</span>
                Belum ada transaksi pembayaran masuk yang dicatat untuk kontrak ini.
            </div>
        @else
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th style="white-space:nowrap;">Kode</th>
                            <th style="white-space:nowrap;">Tanggal</th>
                            <th style="min-width:200px;">Deskripsi</th>
                            <th style="white-space:nowrap;">Kategori Pos</th>
                            <th style="white-space:nowrap;">Metode</th>
                            <th style="text-align:right; white-space:nowrap;">Nominal</th>
                            <th style="text-align:center; white-space:nowrap;">Status</th>
                            <th style="text-align:center; white-space:nowrap;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pemasukanList as $t)
                            <tr>
                                <td style="font-family:monospace;font-size:12px;color:#64748b;white-space:nowrap;">{{ $t->kode_transaksi }}</td>
                                <td style="white-space:nowrap;">{{ \Carbon\Carbon::parse($t->tanggal)->format('d/m/Y') }}</td>
                                <td>
                                    <div style="font-weight:600;color:#0f172a;">{{ $t->deskripsi ?: $t->judul }}</div>
                                    @if($t->keterangan)
                                        <div style="font-size:11px;color:#94a3b8;">{{ Str::limit($t->keterangan, 50) }}</div>
                                    @endif
                                    @if($t->bukti)
                                        <div style="margin-top:3px;">
                                            <a href="{{ asset('storage/'.$t->bukti) }}" target="_blank"
                                               style="display:inline-flex; align-items:center; gap:3px; font-size:10px; font-weight:700; color:#15803d; background:#dcfce7; border:1px solid #bbf7d0; padding:1px 6px; border-radius:4px; text-decoration:none;">
                                                <span class="material-symbols-outlined" style="font-size:12px;">photo_camera</span> Bukti Transfer
                                            </a>
                                        </div>
                                    @endif
                                </td>
                                <td style="white-space:nowrap;"><span class="badge badge-gray">{{ $t->kategori?->nama ?? '—' }}</span></td>
                                <td style="white-space:nowrap;">{{ $t->metode_pembayaran }}</td>
                                <td style="text-align:right;font-weight:700;color:#16a34a;white-space:nowrap;">
                                    Rp {{ number_format($t->nominal, 0, ',', '.') }}
                                </td>
                                <td style="text-align:center;white-space:nowrap;">
                                    @if($t->status === 'lunas')
                                        <span class="badge badge-green">Lunas</span>
                                    @else
                                        <span class="badge badge-amber">Piutang</span>
                                    @endif
                                </td>
                                <td style="text-align:center;white-space:nowrap;">
                                    <a href="{{ route('admin.keuangan.show', $t->id) }}" class="btn-secondary" style="padding:3px 8px;font-size:11px;">
                                        <span class="material-symbols-outlined" style="font-size:13px;">open_in_new</span> Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- Bagian 2: Pengeluaran --}}
    <div class="table-section">
        <div class="table-section-header">
            <div class="table-section-title">
                <span class="material-symbols-outlined" style="color:#ef4444;">receipt</span>
                Pengeluaran
            </div>
            <div style="font-size:12px;color:#64748b;">
                Total: <strong style="color:#dc2626;">Rp {{ number_format($outflow, 0, ',', '.') }}</strong> ({{ $pengeluaranList->count() }} transaksi)
            </div>
        </div>

        @if($pengeluaranList->isEmpty())
            <div style="text-align:center;padding:40px 20px;color:#94a3b8;font-size:13px;">
                <span class="material-symbols-outlined" style="font-size:36px;display:block;margin-bottom:6px;">receipt</span>
                Belum ada biaya pengeluaran yang dicatat untuk kontrak ini.
            </div>
        @else
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th style="white-space:nowrap;">Kode</th>
                            <th style="white-space:nowrap;">Tanggal</th>
                            <th style="min-width:200px;">Deskripsi</th>
                            <th style="white-space:nowrap;">Penerima / Vendor</th>
                            <th style="white-space:nowrap;">Kategori Pos</th>
                            <th style="white-space:nowrap;">Metode</th>
                            <th style="text-align:right; white-space:nowrap;">Nominal</th>
                            <th style="text-align:center; white-space:nowrap;">Status</th>
                            <th style="text-align:center; white-space:nowrap;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pengeluaranList as $t)
                            <tr>
                                <td style="font-family:monospace;font-size:12px;color:#64748b;white-space:nowrap;">{{ $t->kode_transaksi }}</td>
                                <td style="white-space:nowrap;">{{ \Carbon\Carbon::parse($t->tanggal)->format('d/m/Y') }}</td>
                                <td>
                                    <div style="font-weight:600;color:#0f172a;">{{ $t->deskripsi ?: $t->judul }}</div>
                                    @if($t->keterangan)
                                        <div style="font-size:11px;color:#94a3b8;">{{ Str::limit($t->keterangan, 50) }}</div>
                                    @endif
                                    @if($t->bukti)
                                        <div style="margin-top:3px;">
                                            <a href="{{ asset('storage/'.$t->bukti) }}" target="_blank"
                                               style="display:inline-flex; align-items:center; gap:3px; font-size:10px; font-weight:700; color:#15803d; background:#dcfce7; border:1px solid #bbf7d0; padding:1px 6px; border-radius:4px; text-decoration:none;">
                                                <span class="material-symbols-outlined" style="font-size:12px;">photo_camera</span> Bukti Transfer
                                            </a>
                                        </div>
                                    @endif
                                </td>
                                <td style="white-space:nowrap;">{{ $t->penerima ?? '—' }}</td>
                                <td style="white-space:nowrap;"><span class="badge badge-gray">{{ $t->kategori?->nama ?? '—' }}</span></td>
                                <td style="white-space:nowrap;">{{ $t->metode_pembayaran }}</td>
                                <td style="text-align:right;font-weight:700;color:#dc2626;white-space:nowrap;">
                                    Rp {{ number_format($t->nominal, 0, ',', '.') }}
                                </td>
                                <td style="text-align:center;white-space:nowrap;">
                                    @if($t->status === 'lunas')
                                        <span class="badge badge-green">Lunas</span>
                                    @else
                                        <span class="badge badge-amber">Piutang</span>
                                    @endif
                                </td>
                                <td style="text-align:center;white-space:nowrap;">
                                    <a href="{{ route('admin.keuangan.show', $t->id) }}" class="btn-secondary" style="padding:3px 8px;font-size:11px;">
                                        <span class="material-symbols-outlined" style="font-size:13px;">open_in_new</span> Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

{{-- MODAL: Pemasukan --}}
<div id="modalInflow" class="modal-overlay" style="display:none;">
    <div class="modal-box">
        <form method="POST" action="{{ route('admin.keuangan.kontrak.quick-transaksi', $proyek->id) }}" enctype="multipart/form-data" id="formInflow">
            @csrf
            <input type="hidden" name="tipe" value="pemasukan">
            <input type="hidden" name="metode_pembayaran" value="Transfer Bank">
            <input type="hidden" name="status" value="lunas">
            
            <div class="modal-head">
                <h3>
                    <span class="material-symbols-outlined" style="color:#22c55e; font-size:20px;">payments</span>
                    Pemasukan
                </h3>
                <button type="button" class="modal-close" onclick="closeModal('modalInflow')">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="modal-grid-2">
                    <div class="form-group">
                        <label>Tanggal Transaksi *</label>
                        <input type="date" name="tanggal" class="form-control datepicker" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Kategori *</label>
                        <select name="kategori_id" class="form-control" required>
                            @foreach($kategoriPemasukan as $kat)
                                <option value="{{ $kat->id }}">{{ $kat->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Deskripsi Transaksi --}}
                <div class="form-group">
                    <label>Deskripsi <span class="req">*</span></label>
                    <input type="text" name="deskripsi" class="form-control"
                           placeholder="Contoh: Pembayaran Termin 1, DP Kontrak, Pelunasan"
                           value="Pembayaran Termin - {{ $proyek->nama_proyek }}" required autocomplete="off">
                </div>

                {{-- Vol & Satuan --}}
                <div class="modal-grid-2">
                    <div class="form-group">
                        <label>Volume</label>
                        <input type="number" name="volume" id="inflow_volume" class="form-control" min="0.01" step="any" value="1" oninput="calcInflow()">
                    </div>
                    <div class="form-group">
                        <label>Satuan</label>
                        <select name="satuan" class="form-control">
                            @foreach(['paket', 'sesi', 'peserta', 'orang', 'dokumen', 'hari', 'bulan', 'unit'] as $sat)
                                <option value="{{ $sat }}">{{ ucfirst($sat) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Harga Satuan (Rp) --}}
                <div class="form-group">
                    <label>Harga Satuan <span class="req">*</span></label>
                    <div class="input-group-rp">
                        <span class="input-group-addon-rp">Rp</span>
                        <input type="text" id="inflow_harga_display" class="input-group-field-rp" placeholder="Contoh: 500.000" autocomplete="off" required oninput="onInflowHargaInput(this)">
                    </div>
                    <input type="hidden" name="harga_satuan" id="inflow_harga_val" value="0">
                </div>

                {{-- Total Transaksi (Otomatis) --}}
                <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; padding:12px 16px; margin-bottom:14px;">
                    <div style="font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase;">Total Transaksi (Otomatis)</div>
                    <div style="font-size:20px; font-weight:800; color:#0f172a; font-family:'Outfit',sans-serif;" id="inflow_total_display">Rp 0</div>
                    <input type="hidden" name="nominal" id="inflow_nominal_val" value="0">
                </div>

                {{-- Upload Bukti Transaksi --}}
                @include('admin.keuangan.partials.file-upload', [
                    'name' => 'bukti',
                    'id' => 'bukti_inflow',
                    'label' => 'Bukti Transaksi',
                    'help' => 'PDF, JPG, PNG (Maksimal 5MB)',
                ])
            </div>
            <div class="modal-foot">
                <button type="button" class="btn-secondary" onclick="closeModal('modalInflow')">Batal</button>
                <button type="submit" name="save_and_add" value="1"
                    style="padding:9px 18px; border-radius:9px; font-size:13px; font-weight:700;
                           color:#16a34a; background:#fff; border:1px solid #16a34a; cursor:pointer;
                           display:inline-flex; align-items:center; gap:6px; font-family:'Outfit',sans-serif; transition:background .15s;">
                    <span class="material-symbols-outlined" style="font-size:16px; color:#16a34a;">add_circle</span> Simpan & Tambah
                </button>
                <button type="submit" class="btn-quick-in">
                    <span class="material-symbols-outlined" style="font-size:16px;">save</span> Simpan Pemasukan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL: Pengeluaran --}}
<div id="modalOutflow" class="modal-overlay" style="display:none;">
    <div class="modal-box">
        <form method="POST" action="{{ route('admin.keuangan.kontrak.quick-transaksi', $proyek->id) }}" enctype="multipart/form-data" id="formOutflow">
            @csrf
            <input type="hidden" name="tipe" value="pengeluaran">
            <input type="hidden" name="metode_pembayaran" value="Transfer Bank">
            <input type="hidden" name="status" value="lunas">

            <div class="modal-head">
                <h3>
                    <span class="material-symbols-outlined" style="color:#ef4444; font-size:20px;">receipt</span>
                    Pengeluaran
                </h3>
                <button type="button" class="modal-close" onclick="closeModal('modalOutflow')">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="modal-grid-2">
                    <div class="form-group">
                        <label>Tanggal Transaksi *</label>
                        <input type="date" name="tanggal" class="form-control datepicker" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Kategori *</label>
                        <select name="kategori_id" class="form-control" required>
                            @foreach($kategoriPengeluaran as $kat)
                                <option value="{{ $kat->id }}">{{ $kat->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Deskripsi Transaksi --}}
                <div class="form-group">
                    <label>Deskripsi <span class="req">*</span></label>
                    <input type="text" name="deskripsi" class="form-control"
                           placeholder="Contoh: Honor Ahli, Biaya Lapangan, ATK, Cetak Dokumen"
                           value="Pengeluaran - {{ $proyek->nama_proyek }}" required autocomplete="off">
                </div>

                {{-- Vol & Satuan --}}
                <div class="modal-grid-2">
                    <div class="form-group">
                        <label>Volume</label>
                        <input type="number" name="volume" id="outflow_volume" class="form-control" min="0.01" step="any" value="1" oninput="calcOutflow()">
                    </div>
                    <div class="form-group">
                        <label>Satuan</label>
                        <select name="satuan" class="form-control">
                            @foreach(['paket', 'sesi', 'peserta', 'orang', 'dokumen', 'hari', 'bulan', 'unit'] as $sat)
                                <option value="{{ $sat }}">{{ ucfirst($sat) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Harga Satuan (Rp) --}}
                <div class="form-group">
                    <label>Harga Satuan <span class="req">*</span></label>
                    <div class="input-group-rp">
                        <span class="input-group-addon-rp">Rp</span>
                        <input type="text" id="outflow_harga_display" class="input-group-field-rp" placeholder="Contoh: 500.000" autocomplete="off" required oninput="onOutflowHargaInput(this)">
                    </div>
                    <input type="hidden" name="harga_satuan" id="outflow_harga_val" value="0">
                </div>

                {{-- Total Transaksi (Otomatis) --}}
                <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; padding:12px 16px; margin-bottom:14px;">
                    <div style="font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase;">Total Transaksi (Otomatis)</div>
                    <div style="font-size:20px; font-weight:800; color:#0f172a; font-family:'Outfit',sans-serif;" id="outflow_total_display">Rp 0</div>
                    <input type="hidden" name="nominal" id="outflow_nominal_val" value="0">
                </div>

                {{-- Upload Bukti Transaksi --}}
                @include('admin.keuangan.partials.file-upload', [
                    'name' => 'bukti',
                    'id' => 'bukti_outflow',
                    'label' => 'Bukti Transaksi',
                    'help' => 'PDF, JPG, PNG (Maksimal 5MB)',
                ])
            </div>
            <div class="modal-foot">
                <button type="button" class="btn-secondary" onclick="closeModal('modalOutflow')">Batal</button>
                <button type="submit" name="save_and_add" value="1"
                    style="padding:9px 18px; border-radius:9px; font-size:13px; font-weight:700;
                           color:#ef4444; background:#fff; border:1px solid #ef4444; cursor:pointer;
                           display:inline-flex; align-items:center; gap:6px; font-family:'Outfit',sans-serif; transition:background .15s;">
                    <span class="material-symbols-outlined" style="font-size:16px; color:#ef4444;">add_circle</span> Simpan & Tambah
                </button>
                <button type="submit" class="btn-quick-out">
                    <span class="material-symbols-outlined" style="font-size:16px;">save</span> Simpan Pengeluaran
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openModal(id) {
        const modal = document.getElementById(id);
        if (!modal) return;
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        if (window.initDatepickers) {
            window.initDatepickers(modal);
        }
    }
    function closeModal(id) {
        document.getElementById(id).style.display = 'none';
        document.body.style.overflow = '';
    }
    window.addEventListener('click', function(e) {
        if (e.target.classList.contains('modal-overlay')) {
            e.target.style.display = 'none';
            document.body.style.overflow = '';
        }
    });

    function formatRibuan(num) {
        if (!num && num !== 0) return '0';
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function cleanNumber(str) {
        if (!str) return 0;
        return parseFloat(str.toString().replace(/\./g, "").replace(/,/g, ".")) || 0;
    }

    // Inflow Calculation
    window.calcInflow = function() {
        const vol = parseFloat(document.getElementById('inflow_volume').value) || 0;
        const harga = cleanNumber(document.getElementById('inflow_harga_val').value);
        const total = Math.round(vol * harga);
        document.getElementById('inflow_total_display').textContent = 'Rp ' + formatRibuan(total);
        document.getElementById('inflow_nominal_val').value = total;
    };

    window.onInflowHargaInput = function(input) {
        let raw = input.value.replace(/\D/g, "");
        document.getElementById('inflow_harga_val').value = raw || 0;
        input.value = raw ? formatRibuan(raw) : "";
        calcInflow();
    };

    // Outflow Calculation
    window.calcOutflow = function() {
        const vol = parseFloat(document.getElementById('outflow_volume').value) || 0;
        const harga = cleanNumber(document.getElementById('outflow_harga_val').value);
        const total = Math.round(vol * harga);
        document.getElementById('outflow_total_display').textContent = 'Rp ' + formatRibuan(total);
        document.getElementById('outflow_nominal_val').value = total;
    };

    window.onOutflowHargaInput = function(input) {
        let raw = input.value.replace(/\D/g, "");
        document.getElementById('outflow_harga_val').value = raw || 0;
        input.value = raw ? formatRibuan(raw) : "";
        calcOutflow();
    };

    @if(session('reopen_modal'))
    document.addEventListener('DOMContentLoaded', function() {
        openModal("{{ session('reopen_modal') }}");
    });
    @endif
</script>
@endpush
