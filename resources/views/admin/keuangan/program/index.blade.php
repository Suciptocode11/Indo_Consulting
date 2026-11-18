@extends('admin.layouts.app')

@section('title', 'Keuangan Program & Kontrak Klien')
@section('page-title', 'Keuangan Program & Kontrak Klien')

@push('styles')
<style>
    /* ── KPI Cards ───────────────────────────────────────────────── */
    .keu-kpi-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(210px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }
    .keu-kpi {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 18px 20px;
        position: relative;
        overflow: hidden;
    }
    .keu-kpi::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        border-radius: 14px 14px 0 0;
    }
    .keu-kpi.contract::before { background: linear-gradient(90deg, #6366f1, #4f46e5); }
    .keu-kpi.in::before       { background: linear-gradient(90deg, #22c55e, #16a34a); }
    .keu-kpi.pip::before      { background: linear-gradient(90deg, #f59e0b, #d97706); }
    .keu-kpi.out::before      { background: linear-gradient(90deg, #ef4444, #dc2626); }
    .keu-kpi.net::before      { background: linear-gradient(90deg, #3b82f6, #2563eb); }
    
    .keu-kpi-icon {
        width: 38px; height: 38px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 12px;
    }
    .keu-kpi-icon .material-symbols-outlined { font-size: 20px; color: #fff; }
    .keu-kpi.contract .keu-kpi-icon { background: #6366f1; }
    .keu-kpi.in       .keu-kpi-icon { background: #22c55e; }
    .keu-kpi.pip      .keu-kpi-icon { background: #f59e0b; }
    .keu-kpi.out      .keu-kpi-icon { background: #ef4444; }
    .keu-kpi.net      .keu-kpi-icon { background: #3b82f6; }
    
    .keu-kpi-label { font-size: 11px; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px; }
    .keu-kpi-value { font-size: 21px; font-weight: 700; color: #0f172a; line-height: 1.1; word-break: break-word; }
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

    /* ── Filter Bar ──────────────────────────────────────────────── */
    .filter-bar {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 14px 18px;
        margin-bottom: 20px;
    }
    .filter-row { display: flex; flex-wrap: wrap; gap: 10px; align-items: flex-end; }
    .filter-group { display: flex; flex-direction: column; gap: 4px; }
    .filter-group label { font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.4px; }
    .filter-group select,
    .filter-group input[type="text"] {
        padding: 7px 12px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-family: 'Outfit', sans-serif;
        font-size: 13px;
        color: #0f172a;
        background: #f8fafc;
        cursor: pointer;
    }
    .filter-group select:focus, .filter-group input:focus { outline: none; border-color: #bb0027; box-shadow: 0 0 0 3px rgba(187,0,39,.08); }

    /* ── Section Title ───────────────────────────────────────────── */
    .section-header-wrap {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 28px 0 16px;
        flex-wrap: wrap;
        gap: 10px;
    }
    .section-title {
        font-size: 17px;
        font-weight: 800;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 0;
    }
    .section-title .material-symbols-outlined { color: #bb0027; font-size: 22px; }

    /* ── Program Cards Grid ──────────────────────────────────────── */
    .program-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 16px;
        margin-bottom: 32px;
    }
    .prog-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        overflow: hidden;
        transition: box-shadow .2s, transform .2s;
    }
    .prog-card:hover { box-shadow: 0 8px 24px rgba(0,0,0,.06); transform: translateY(-2px); }
    .prog-card-header {
        padding: 16px 18px 12px;
        display: flex;
        align-items: flex-start;
        gap: 12px;
        border-bottom: 1px solid #f1f5f9;
    }
    .prog-icon {
        width: 42px; height: 42px;
        border-radius: 11px;
        background: linear-gradient(135deg, #bb0027, #e01040);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .prog-icon .material-symbols-outlined { font-size: 20px; color: #fff; }
    .prog-title { font-size: 14px; font-weight: 700; color: #0f172a; line-height: 1.3; }
    .prog-subtitle { font-size: 12px; color: #64748b; margin-top: 2px; }

    .prog-card-body { padding: 14px 18px; }
    .prog-row { display: flex; justify-content: space-between; align-items: center; padding: 6px 0; border-bottom: 1px solid #f1f5f9; }
    .prog-row:last-child { border-bottom: none; }
    .prog-row-label { font-size: 12px; color: #64748b; display: flex; align-items: center; gap: 5px; }
    .prog-row-label .material-symbols-outlined { font-size: 15px; }
    .prog-row-value { font-size: 13px; font-weight: 700; color: #0f172a; }
    .text-green { color: #16a34a; }
    .text-red   { color: #dc2626; }
    .text-blue  { color: #2563eb; }
    .text-amber { color: #d97706; }

    /* Bar ratio */
    .prog-bar-wrap { margin: 12px 0 4px; }
    .prog-bar-label { display: flex; justify-content: space-between; font-size: 11px; color: #64748b; margin-bottom: 4px; }
    .prog-bar-track { height: 6px; background: #f1f5f9; border-radius: 20px; overflow: hidden; }
    .prog-bar-fill  { height: 100%; border-radius: 20px; transition: width .5s ease; }
    .bar-green { background: linear-gradient(90deg, #22c55e, #16a34a); }
    .bar-red   { background: linear-gradient(90deg, #ef4444, #dc2626); }
    .bar-blue  { background: linear-gradient(90deg, #3b82f6, #2563eb); }

    .prog-card-footer {
        padding: 10px 18px; background: #f8fafc; border-top: 1px solid #f1f5f9;
        display: flex; align-items: center; justify-content: space-between;
    }

    /* ── Table & Badges for Kontrak Klien ────────────────────────── */
    .table-card { 
        background: #fff; 
        border: 1px solid #e2e8f0; 
        border-radius: 16px; 
        overflow: hidden; 
        box-shadow: 0 1px 3px rgba(0,0,0,0.03);
    }
    .table-responsive {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: thin;
        scrollbar-color: #cbd5e1 #f1f5f9;
    }
    .table-responsive::-webkit-scrollbar {
        height: 7px;
    }
    .table-responsive::-webkit-scrollbar-track {
        background: #f1f5f9;
    }
    .table-responsive::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }
    .table-responsive::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
    .table-card table { 
        width: 100%; 
        min-width: 1100px; 
        border-collapse: collapse; 
    }
    .table-card thead th {
        background: #f8fafc; 
        padding: 13px 16px; 
        text-align: left;
        font-size: 11px; 
        font-weight: 700; 
        color: #64748b; 
        text-transform: uppercase; 
        letter-spacing: 0.5px;
        border-bottom: 1px solid #e2e8f0; 
        white-space: nowrap;
    }
    .table-card thead th.col-actions,
    .table-card tbody td.col-actions {
        position: sticky;
        right: 0;
        background: #fff;
        z-index: 2;
        box-shadow: -5px 0 10px -2px rgba(15, 23, 42, 0.07);
    }
    .table-card thead th.col-actions {
        background: #f8fafc;
        z-index: 3;
    }
    .table-card tbody tr:hover td.col-actions {
        background: #fafbfc;
    }
    .table-card tbody tr { 
        border-bottom: 1px solid #f1f5f9; 
        transition: background .15s; 
    }
    .table-card tbody tr:last-child { 
        border-bottom: none; 
    }
    .table-card tbody tr:hover { 
        background: #fafbfc; 
    }
    .table-card td { 
        padding: 13px 16px; 
        font-size: 13px; 
        color: #334155; 
        vertical-align: middle; 
    }

    .contract-title { 
        font-weight: 700; 
        color: #0f172a; 
        text-decoration: none; 
        line-height: 1.4;
        display: inline-block;
    }
    .contract-title:hover { color: #bb0027; }
    .contract-client { 
        font-size: 12px; 
        color: #64748b; 
        margin-top: 5px; 
        display: flex; 
        align-items: center; 
        flex-wrap: wrap; 
        gap: 6px; 
        row-gap: 4px;
        line-height: 1.4;
    }
    .contract-client-name {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-weight: 600;
        color: #334155;
    }
    .contract-client-meta {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
    }
    .contract-code { 
        display: inline-block; 
        font-family: monospace; 
        font-size: 11px; 
        font-weight: 700; 
        padding: 2px 7px; 
        background: #f1f5f9; 
        color: #475569; 
        border-radius: 5px; 
        margin-bottom: 4px; 
        letter-spacing: 0.3px;
    }

    /* Progress bar */
    .prog-wrap { width: 110px; }
    .prog-track { height: 6px; background: #f1f5f9; border-radius: 10px; overflow: hidden; margin-top: 4px; }
    .prog-fill  { height: 100%; border-radius: 10px; background: linear-gradient(90deg, #22c55e, #16a34a); }

    /* Badges */
    .badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 9px; border-radius: 20px; font-size: 11px; font-weight: 700; }
    .badge-green  { background: #dcfce7; color: #15803d; }
    .badge-blue   { background: #dbeafe; color: #1d4ed8; }
    .badge-amber  { background: #fef3c7; color: #b45309; }
    .badge-red    { background: #fee2e2; color: #b91c1c; }
    .badge-gray   { background: #f1f5f9; color: #64748b; }

    .btn-action { display: inline-flex; align-items: center; gap: 4px; padding: 5px 10px; border-radius: 8px; font-size: 12px; font-weight: 600; text-decoration: none; transition: all .15s; }
    .btn-action-primary { background: #f8fafc; color: #334155; border: 1px solid #e2e8f0; }
    .btn-action-primary:hover { background: #f1f5f9; color: #0f172a; }

    .btn-add {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 9px 18px; border-radius: 10px; background: #4f46e5; color: #fff;
        font-weight: 600; font-size: 13px; text-decoration: none; transition: background .15s;
    }
    .btn-add:hover { background: #4338ca; color: #fff; }

    .btn-nav-outline {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 9px 16px; border-radius: 10px; font-size: 13px; font-weight: 600;
        color: #475569; background: #f1f5f9; text-decoration: none; transition: background .15s;
    }
    .btn-nav-outline:hover { background: #e2e8f0; }

    .empty-state { text-align: center; padding: 48px 20px; color: #94a3b8; }
    .empty-state .material-symbols-outlined { font-size: 48px; display: block; margin-bottom: 10px; color: #cbd5e1; }
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

    {{-- Page Header --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;flex-wrap:wrap;gap:12px;">
        <div>
            <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">Keuangan Program & Kontrak Klien</h1>
            <p style="font-size:13px;color:#64748b;margin:4px 0 0;">Pemantauan P&L program layanan konsultan dan realisasi termin kontrak klien</p>
        </div>
        <div style="display:flex;gap:10px;flex-wrap:wrap;">
            <a href="{{ route('admin.services.create') }}" class="btn-nav-outline" style="background:#eef2ff; color:#4338ca; border:1px solid #c7d2fe;" title="Tambah Program Layanan Baru">
                <span class="material-symbols-outlined" style="font-size:17px; color:#4f46e5;">school</span>
                Tambah Program Layanan
            </a>
            <button type="button" onclick="openModalTambahKontrak()" class="btn-add" style="cursor:pointer; border:none; font-family:inherit;">
                <span class="material-symbols-outlined" style="font-size:18px;">add_circle</span>
                Tambah Kontrak Klien Baru
            </button>
            <a href="{{ route('admin.keuangan.index') }}" class="btn-nav-outline">
                <span class="material-symbols-outlined" style="font-size:17px;">account_balance_wallet</span>
                Buku Kas Umum
            </a>
        </div>
    </div>

    {{-- KPI Overview (5 Cards) --}}
    @php
        $pctIn  = $totalNilaiKontrak > 0 ? round(($totalPemasukanKontrak / $totalNilaiKontrak) * 100, 1) : 0;
        $pctPip = $totalNilaiKontrak > 0 ? round(($totalSisaPiutangKontrak / $totalNilaiKontrak) * 100, 1) : 0;
        $pctOut = $totalPemasukanKontrak > 0 ? round(($totalPengeluaranKontrak / $totalPemasukanKontrak) * 100, 1) : 0;
        $pctNet = $totalPemasukanKontrak > 0 ? round(($totalLabaKontrak / $totalPemasukanKontrak) * 100, 1) : 0;
    @endphp
    <div class="keu-kpi-grid">
        <div class="keu-kpi contract">
            <div class="keu-kpi-icon"><span class="material-symbols-outlined">description</span></div>
            <div class="keu-kpi-label">Total Nilai Kontrak</div>
            <div class="keu-kpi-value">Rp {{ number_format($totalNilaiKontrak, 0, ',', '.') }}</div>
            <div class="keu-kpi-sub">
                <span class="pct-pill pct-pill-purple">
                    <span class="material-symbols-outlined" style="font-size:12px;">handshake</span>
                    100% Target
                </span>
                <span>Seluruh kontrak klien</span>
            </div>
        </div>
        <div class="keu-kpi in">
            <div class="keu-kpi-icon"><span class="material-symbols-outlined">payments</span></div>
            <div class="keu-kpi-label">Pemasukan</div>
            <div class="keu-kpi-value" style="color:#16a34a;">Rp {{ number_format($totalPemasukanKontrak, 0, ',', '.') }}</div>
            <div class="keu-kpi-sub">
                <span class="pct-pill pct-pill-green">
                    <span class="material-symbols-outlined" style="font-size:12px;">arrow_upward</span>
                    {{ $pctIn }}%
                </span>
                <span>tercairkan dari kontrak</span>
            </div>
        </div>
        <div class="keu-kpi out">
            <div class="keu-kpi-icon"><span class="material-symbols-outlined">receipt</span></div>
            <div class="keu-kpi-label">Pengeluaran</div>
            <div class="keu-kpi-value" style="color:#dc2626;">Rp {{ number_format($totalPengeluaranKontrak, 0, ',', '.') }}</div>
            <div class="keu-kpi-sub">
                <span class="pct-pill pct-pill-red">
                    <span class="material-symbols-outlined" style="font-size:12px;">arrow_downward</span>
                    {{ $pctOut }}%
                </span>
                <span>biaya operasional penugasan</span>
            </div>
        </div>
        <div class="keu-kpi pip">
            <div class="keu-kpi-icon"><span class="material-symbols-outlined">pending_actions</span></div>
            <div class="keu-kpi-label">Piutang</div>
            <div class="keu-kpi-value" style="color:#d97706;">Rp {{ number_format($totalSisaPiutangKontrak, 0, ',', '.') }}</div>
            <div class="keu-kpi-sub">
                <span class="pct-pill pct-pill-amber">
                    <span class="material-symbols-outlined" style="font-size:12px;">schedule</span>
                    {{ $pctPip }}%
                </span>
                <span>belum dilunasi klien</span>
            </div>
        </div>
        <div class="keu-kpi net">
            <div class="keu-kpi-icon"><span class="material-symbols-outlined">account_balance</span></div>
            <div class="keu-kpi-label">Selisih</div>
            <div class="keu-kpi-value {{ $totalLabaKontrak >= 0 ? '' : 'text-red' }}" style="color:{{ $totalLabaKontrak >= 0 ? '#2563eb' : '#dc2626' }};">
                {{ $totalLabaKontrak < 0 ? '-' : '' }}Rp {{ number_format(abs($totalLabaKontrak), 0, ',', '.') }}
            </div>
            <div class="keu-kpi-sub">
                <span class="pct-pill {{ $totalLabaKontrak >= 0 ? 'pct-pill-blue' : 'pct-pill-red' }}">
                    <span class="material-symbols-outlined" style="font-size:12px;">{{ $totalLabaKontrak >= 0 ? 'trending_up' : 'trending_down' }}</span>
                    {{ number_format(abs($pctNet), 1) }}%
                </span>
                <span>margin bersih keuntungan</span>
            </div>
        </div>
    </div>

    {{-- ─── BAGIAN 1: KARTU PROGRAM LAYANAN ──────────────────────── --}}
    <div class="section-header-wrap">
        <div>
            <h2 class="section-title">
                <span class="material-symbols-outlined">category</span>
                Ikhtisar Program Layanan
            </h2>
            <div style="font-size:12px; color:#64748b; margin-top:2px;">Ringkasan keuangan berdasarkan bidang layanan keahlian</div>
        </div>

        {{-- Filter Periode Program --}}
        <form method="GET" action="{{ route('admin.keuangan.program.index') }}" id="filterProgramForm">
            <div style="display:flex; gap:8px;">
                <select name="tahun" style="padding:6px 12px; border:1px solid #e2e8f0; border-radius:8px; font-size:12px; background:#fff;" onchange="document.getElementById('filterProgramForm').submit()">
                    @foreach($tahunList as $t)
                        <option value="{{ $t }}" {{ $t == $tahun ? 'selected' : '' }}>Tahun {{ $t }}</option>
                    @endforeach
                </select>
                <select name="bulan" style="padding:6px 12px; border:1px solid #e2e8f0; border-radius:8px; font-size:12px; background:#fff;" onchange="document.getElementById('filterProgramForm').submit()">
                    <option value="">Semua Bulan</option>
                    @foreach(['01'=>'Jan','02'=>'Feb','03'=>'Mar','04'=>'Apr','05'=>'Mei','06'=>'Jun','07'=>'Jul','08'=>'Agu','09'=>'Sep','10'=>'Okt','11'=>'Nov','12'=>'Des'] as $m=>$label)
                        <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>

    @if($programData->isEmpty())
        <div class="empty-state">
            <span class="material-symbols-outlined">library_books</span>
            <p>Tidak ada data program layanan.</p>
        </div>
    @else
        <div class="program-grid">
            @foreach($programData as $prog)
                @php
                    $pctBeban   = $prog->pemasukan > 0 ? min(100, ($prog->pengeluaran / $prog->pemasukan) * 100) : 0;
                    $pctMarginW = $prog->pemasukan > 0 ? min(100, ($prog->margin / $prog->pemasukan) * 100) : 0;
                @endphp
                <div class="prog-card">
                    <div class="prog-card-header">
                        <div class="prog-icon">
                            <span class="material-symbols-outlined">
                                @php
                                    $icons = ['business_center','school','payments','gavel','library_books','lightbulb'];
                                    echo $icons[($prog->id - 1) % count($icons)];
                                @endphp
                            </span>
                        </div>
                        <div style="flex:1;">
                            <div class="prog-title">{{ $prog->title }}</div>
                            <div style="margin-top:4px;">
                                @if(($prog->kontrakAktif ?? 0) > 0)
                                    <span class="badge badge-blue" style="font-size:10px; padding:2px 7px;">
                                        <span class="material-symbols-outlined" style="font-size:11px;">handshake</span>
                                        {{ $prog->kontrakAktif }} Kontrak Aktif
                                    </span>
                                @else
                                    <span class="badge badge-gray" style="font-size:10px; padding:2px 7px;">Belum ada kontrak aktif</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="prog-card-body">
                        <div class="prog-row">
                            <span class="prog-row-label">
                                <span class="material-symbols-outlined" style="color:#22c55e;">trending_up</span>
                                Pemasukan
                            </span>
                            <span class="prog-row-value text-green">Rp {{ number_format($prog->pemasukan, 0, ',', '.') }}</span>
                        </div>
                        <div class="prog-row">
                            <span class="prog-row-label">
                                <span class="material-symbols-outlined" style="color:#ef4444;">trending_down</span>
                                Pengeluaran
                            </span>
                            <span class="prog-row-value text-red">Rp {{ number_format($prog->pengeluaran, 0, ',', '.') }}</span>
                        </div>
                        <div class="prog-row">
                            <span class="prog-row-label">
                                <span class="material-symbols-outlined" style="color:#3b82f6;">account_balance</span>
                                Margin / Laba
                            </span>
                            <span class="prog-row-value {{ $prog->margin >= 0 ? 'text-green' : 'text-red' }}">
                                {{ $prog->margin >= 0 ? '' : '-' }}Rp {{ number_format(abs($prog->margin), 0, ',', '.') }}
                            </span>
                        </div>
                        @if($prog->piutang > 0)
                        <div class="prog-row">
                            <span class="prog-row-label">
                                <span class="material-symbols-outlined" style="color:#d97706;">pending_actions</span>
                                Sisa Piutang Kontrak
                            </span>
                            <span class="prog-row-value text-amber">Rp {{ number_format($prog->piutang, 0, ',', '.') }}</span>
                        </div>
                        @endif

                        {{-- Margin ratio bar --}}
                        @if($prog->pemasukan > 0)
                        <div class="prog-bar-wrap">
                            <div class="prog-bar-label">
                                <span>Rasio Beban</span>
                                <span>{{ number_format($pctBeban, 1) }}%</span>
                            </div>
                            <div class="prog-bar-track">
                                <div class="prog-bar-fill {{ $pctBeban > 80 ? 'bar-red' : ($pctBeban > 50 ? 'bar-blue' : 'bar-green') }}"
                                     style="width: {{ $pctBeban }}%"></div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="prog-card-footer">
                        <span style="font-size:11px; color:#64748b; display:flex; align-items:center; gap:4px;">
                            <span class="material-symbols-outlined" style="font-size:14px;">receipt_long</span>
                            {{ $prog->jumlahTransaksi }} transaksi
                        </span>
                        <a href="{{ route('admin.keuangan.program.index', ['kontrak_service' => $prog->id]) }}#daftar-kontrak"
                           style="font-size:12px; font-weight:600; color:#4f46e5; text-decoration:none; display:inline-flex; align-items:center; gap:2px;">
                            Lihat Kontrak
                            <span class="material-symbols-outlined" style="font-size:14px;">arrow_downward</span>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    {{-- ─── BAGIAN 2: DAFTAR KONTRAK KLIEN ──────────────────────── --}}
    <div id="daftar-kontrak" class="section-header-wrap" style="margin-top:36px; padding-top:20px; border-top:1px solid #e2e8f0;">
        <div>
            <h2 class="section-title">
                <span class="material-symbols-outlined" style="color:#4f46e5;">handshake</span>
                Daftar Kontrak Klien
                <span style="font-size:13px; font-weight:600; color:#64748b; background:#eef2ff; color:#4f46e5; padding:2px 8px; border-radius:20px; margin-left:6px;">
                    {{ $kontraks->count() }} Kontrak
                </span>
            </h2>
            <div style="font-size:12px; color:#64748b; margin-top:2px;">Rincian kesepakatan kontrak kerja sama, termin pembayaran, dan biaya operasional penugasan</div>
        </div>
        <button type="button" onclick="openModalTambahKontrak()" class="btn-add" style="cursor:pointer; border:none; font-family:inherit;">
            <span class="material-symbols-outlined" style="font-size:17px;">add_circle</span>
            Tambah Kontrak Klien
        </button>
    </div>

    {{-- Filter Bar Kontrak --}}
    <div class="filter-bar">
        {{-- Quick Tabs Filter Kontrak --}}
        <div style="display:flex;gap:6px;margin-bottom:14px;flex-wrap:wrap;align-items:center;">
            <a href="{{ route('admin.keuangan.program.index', array_merge(request()->query(), ['kontrak_status' => ''])) }}#daftar-kontrak"
               class="btn-action {{ empty($kontrakStatus) ? 'btn-primary' : 'btn-action-primary' }}" style="padding:5px 12px;border-radius:20px;font-size:12px;text-decoration:none;display:inline-flex;align-items:center;gap:4px;">
               Semua Kontrak
            </a>
            <a href="{{ route('admin.keuangan.program.index', array_merge(request()->query(), ['kontrak_status' => 'piutang'])) }}#daftar-kontrak"
               class="btn-action" style="padding:5px 12px;border-radius:20px;font-size:12px;text-decoration:none;display:inline-flex;align-items:center;gap:4px;color:{{ $kontrakStatus === 'piutang' ? '#fff' : '#b45309' }};border:1px solid #fde68a;background:{{ $kontrakStatus === 'piutang' ? '#d97706' : '#fffbeb' }};font-weight:700;">
               <span class="material-symbols-outlined" style="font-size:15px;">pending_actions</span>
               Piutang (Belum Lunas)
            </a>
            <a href="{{ route('admin.keuangan.program.index', array_merge(request()->query(), ['kontrak_status' => 'berjalan'])) }}#daftar-kontrak"
               class="btn-action {{ $kontrakStatus === 'berjalan' ? 'btn-primary' : 'btn-action-primary' }}" style="padding:5px 12px;border-radius:20px;font-size:12px;text-decoration:none;display:inline-flex;align-items:center;gap:4px;">
               Sedang Berjalan
            </a>
            <a href="{{ route('admin.keuangan.program.index', array_merge(request()->query(), ['kontrak_status' => 'lunas'])) }}#daftar-kontrak"
               class="btn-action" style="padding:5px 12px;border-radius:20px;font-size:12px;text-decoration:none;display:inline-flex;align-items:center;gap:4px;color:{{ $kontrakStatus === 'lunas' ? '#fff' : '#15803d' }};border:1px solid #bbf7d0;background:{{ $kontrakStatus === 'lunas' ? '#16a34a' : '#f0fdf4' }};font-weight:700;">
               <span class="material-symbols-outlined" style="font-size:15px;">check_circle</span>
               Lunas
            </a>
            <a href="{{ route('admin.keuangan.program.index', array_merge(request()->query(), ['kontrak_status' => 'selesai'])) }}#daftar-kontrak"
               class="btn-action {{ $kontrakStatus === 'selesai' ? 'btn-primary' : 'btn-action-primary' }}" style="padding:5px 12px;border-radius:20px;font-size:12px;text-decoration:none;display:inline-flex;align-items:center;gap:4px;">
               Selesai
            </a>
        </div>

        <form method="GET" action="{{ route('admin.keuangan.program.index') }}#daftar-kontrak" id="filterKontrakForm">
            <div class="filter-row">
                <div class="filter-group" style="flex:1; min-width:200px;">
                    <label>Search</label>
                    <input type="text" name="kontrak_search" value="{{ $kontrakSearch }}" placeholder="Cari nama pekerjaan, klien, kode kontrak..." onchange="document.getElementById('filterKontrakForm').submit()">
                </div>
                <div class="filter-group">
                    <label>Status & Piutang</label>
                    <select name="kontrak_status" onchange="document.getElementById('filterKontrakForm').submit()">
                        <option value="">Semua Status</option>
                        <option value="piutang"  {{ $kontrakStatus === 'piutang'  ? 'selected' : '' }}>Piutang (Belum Lunas)</option>
                        <option value="berjalan" {{ $kontrakStatus === 'berjalan' ? 'selected' : '' }}>Berjalan</option>
                        <option value="lunas"    {{ $kontrakStatus === 'lunas'    ? 'selected' : '' }}>Lunas</option>
                        <option value="selesai"  {{ $kontrakStatus === 'selesai'  ? 'selected' : '' }}>Selesai</option>
                        <option value="pending"  {{ $kontrakStatus === 'pending'  ? 'selected' : '' }}>Pending</option>
                        <option value="batal"    {{ $kontrakStatus === 'batal'    ? 'selected' : '' }}>Batal</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label>Program Layanan</label>
                    <select name="kontrak_service" onchange="document.getElementById('filterKontrakForm').submit()">
                        <option value="">Semua Program Layanan</option>
                        @foreach($services as $s)
                            <option value="{{ $s->id }}" {{ $kontrakService == $s->id ? 'selected' : '' }}>{{ $s->title }}</option>
                        @endforeach
                    </select>
                </div>
                @if($kontrakSearch || $kontrakStatus || $kontrakService)
                <div class="filter-group" style="justify-content:flex-end;">
                    <a href="{{ route('admin.keuangan.program.index') }}#daftar-kontrak" style="font-size:12px; color:#dc2626; text-decoration:none; padding:8px 0; display:inline-flex; align-items:center; gap:3px;">
                        <span class="material-symbols-outlined" style="font-size:15px;">close</span> Reset Filter
                    </a>
                </div>
                @endif
            </div>
        </form>
    </div>

    {{-- Kontrak Klien Table --}}
    @if($kontraks->isEmpty())
        <div class="table-card">
            <div class="empty-state">
                <span class="material-symbols-outlined">handshake</span>
                <h3 style="font-size:16px; font-weight:700; color:#475569; margin:0 0 6px;">Belum Ada Kontrak Klien</h3>
                <p style="font-size:13px; color:#94a3b8; margin:0 0 16px;">Mulai tambahkan kontrak klien baru untuk memantau nilai kontrak, termin pembayaran, dan biaya operasional.</p>
                <button type="button" onclick="openModalTambahKontrak()" class="btn-add" style="cursor:pointer; border:none; font-family:inherit;">
                    <span class="material-symbols-outlined" style="font-size:18px;">add_circle</span>
                    Tambah Kontrak Pertama
                </button>
            </div>
        </div>
    @else
        <div class="table-card">
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th style="width:40px; text-align:center;">#</th>
                            <th style="min-width:280px;">Kontrak & Klien</th>
                            <th style="min-width:140px; white-space:nowrap;">Program Layanan</th>
                            <th style="text-align:right; min-width:130px; white-space:nowrap;">Nilai Kontrak</th>
                            <th style="min-width:130px; white-space:nowrap;">Pemasukan</th>
                            <th style="text-align:right; min-width:120px; white-space:nowrap;">Pengeluaran</th>
                            <th style="text-align:right; min-width:120px; white-space:nowrap;">Piutang</th>
                            <th style="text-align:right; min-width:120px; white-space:nowrap;">Selisih</th>
                            <th style="text-align:center; min-width:105px; white-space:nowrap;">Status</th>
                            <th class="col-actions" style="text-align:center; min-width:130px; width:130px; white-space:nowrap;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kontraks as $i => $ktr)
                            @php
                                $inflow   = $ktr->total_pemasukan;
                                $outflow  = $ktr->total_pengeluaran;
                                $sisa     = $ktr->sisa_tagihan;
                                $laba     = $ktr->laba_bersih;
                                $progress = $ktr->progress_pembayaran;
                                $badge    = $ktr->status_badge;
                            @endphp
                            <tr>
                                <td style="text-align:center; color:#94a3b8; font-weight:600;">{{ $i + 1 }}</td>
                                <td style="min-width:280px;">
                                    <div class="contract-code">{{ $ktr->kode_proyek }}</div>
                                    <div>
                                        <a href="{{ route('admin.keuangan.kontrak.show', $ktr->id) }}" class="contract-title">
                                            {{ $ktr->nama_proyek }}
                                        </a>
                                    </div>
                                    <div class="contract-client">
                                        <div class="contract-client-name">
                                            <span class="material-symbols-outlined" style="font-size:14px; color:#94a3b8; flex-shrink:0;">domain</span>
                                            <span>{{ $ktr->nama_klien }}</span>
                                        </div>
                                        @if($ktr->kontak_klien || $ktr->pic)
                                            <div class="contract-client-meta">
                                                @if($ktr->kontak_klien)
                                                    <span style="color:#64748b; font-size:11px; white-space:nowrap; display:inline-flex; align-items:center; gap:2px;">
                                                        <span class="material-symbols-outlined" style="font-size:12px; color:#94a3b8;">call</span>
                                                        {{ $ktr->kontak_klien }}
                                                    </span>
                                                @endif
                                                @if($ktr->pic)
                                                    <span style="color:#4f46e5; font-weight:600; background:#eef2ff; padding:1px 6px; border-radius:4px; font-size:11px; white-space:nowrap; display:inline-flex; align-items:center; gap:2px;">
                                                        <span class="material-symbols-outlined" style="font-size:12px; color:#6366f1;">person</span>
                                                        PIC: {{ $ktr->pic }}
                                                    </span>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td style="white-space:nowrap;">
                                    @if($ktr->service)
                                        <span class="badge badge-gray" style="white-space:nowrap; max-width:180px; overflow:hidden; text-overflow:ellipsis; display:inline-block; vertical-align:middle;" title="{{ $ktr->service->title }}">{{ Str::limit($ktr->service->title, 26) }}</span>
                                    @else
                                        <span style="color:#cbd5e1;">—</span>
                                    @endif
                                </td>
                                <td style="text-align:right; font-weight:700; color:#0f172a; white-space:nowrap;">
                                    Rp {{ number_format($ktr->nilai_kontrak, 0, ',', '.') }}
                                </td>
                                <td style="white-space:nowrap;">
                                    <div style="font-weight:700; color:#16a34a; font-size:13px; white-space:nowrap;">
                                        Rp {{ number_format($inflow, 0, ',', '.') }}
                                    </div>
                                    <div class="prog-wrap" style="margin-top:3px; width:110px;">
                                        <div class="prog-track">
                                            <div class="prog-fill" style="width: {{ $progress }}%;"></div>
                                        </div>
                                    </div>
                                    <div style="font-size:10px; color:#64748b; margin-top:2px; white-space:nowrap;">{{ $progress }}% tercairkan</div>
                                </td>
                                <td style="text-align:right; color:#dc2626; font-weight:600; white-space:nowrap;">
                                    @if($outflow > 0)
                                        Rp {{ number_format($outflow, 0, ',', '.') }}
                                    @else
                                        <span style="color:#cbd5e1;">Rp 0</span>
                                    @endif
                                </td>
                                <td style="text-align:right; font-weight:700; color:{{ $sisa > 0 ? '#d97706' : '#16a34a' }}; white-space:nowrap;">
                                    @if($sisa > 0)
                                        Rp {{ number_format($sisa, 0, ',', '.') }}
                                    @else
                                        <span style="color:#16a34a; font-size:11px; font-weight:700;">Lunas (Rp 0)</span>
                                    @endif
                                </td>
                                <td style="text-align:right; font-weight:700; color:{{ $laba >= 0 ? '#2563eb' : '#dc2626' }}; white-space:nowrap;">
                                    {{ $laba < 0 ? '-' : '' }}Rp {{ number_format(abs($laba), 0, ',', '.') }}
                                </td>
                                <td style="text-align:center; white-space:nowrap;">
                                    <span class="badge {{ $badge['class'] }}">
                                        <span class="material-symbols-outlined" style="font-size:12px;">{{ $badge['icon'] }}</span>
                                        {{ $badge['label'] }}
                                    </span>
                                </td>
                                <td class="col-actions" style="text-align:center; white-space:nowrap;">
                                    <div style="display:inline-flex; gap:6px; align-items:center;">
                                        <a href="{{ route('admin.keuangan.kontrak.show', $ktr->id) }}" class="btn-action btn-action-primary" title="Detail & Pembayaran">
                                            <span class="material-symbols-outlined" style="font-size:15px;">visibility</span>
                                            Detail
                                        </a>
                                        <a href="{{ route('admin.keuangan.kontrak.edit', $ktr->id) }}" class="btn-action btn-action-primary" title="Edit Kontrak">
                                            <span class="material-symbols-outlined" style="font-size:15px;">edit</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div style="margin-top:12px; font-size:12px; color:#94a3b8; text-align:right;">
            Total {{ $kontraks->count() }} kontrak klien terdaftar
        </div>
    @endif
</div>
@endsection
