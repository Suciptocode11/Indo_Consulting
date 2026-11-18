@extends('admin.layouts.app')

@section('title', 'Manajemen Keuangan')
@section('page-title', 'Manajemen Keuangan')

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
        padding: 20px 22px;
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
    .keu-kpi.in::before  { background: linear-gradient(90deg, #22c55e, #16a34a); }
    .keu-kpi.out::before { background: linear-gradient(90deg, #ef4444, #dc2626); }
    .keu-kpi.net::before { background: linear-gradient(90deg, #3b82f6, #2563eb); }
    .keu-kpi.pip::before { background: linear-gradient(90deg, #f59e0b, #d97706); }
    .keu-kpi-icon {
        width: 38px; height: 38px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 14px;
    }
    .keu-kpi-icon .material-symbols-outlined { font-size: 20px; color: #fff; }
    .keu-kpi.in  .keu-kpi-icon { background: #22c55e; }
    .keu-kpi.out .keu-kpi-icon { background: #ef4444; }
    .keu-kpi.net .keu-kpi-icon { background: #3b82f6; }
    .keu-kpi.pip .keu-kpi-icon { background: #f59e0b; }
    .keu-kpi-label { font-size: 11px; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px; }
    .keu-kpi-value { font-size: 22px; font-weight: 700; color: #0f172a; line-height: 1.1; word-break: break-word; }

    /* ── Percentage Pills ────────────────────────────────────────── */
    .pct-pill {
        display: inline-flex;
        align-items: center;
        gap: 3px;
        padding: 3px 8px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.3px;
    }
    .pct-pill-green {
        background: #dcfce7;
        color: #15803d;
        border: 1px solid #bbf7d0;
    }
    .pct-pill-red {
        background: #fee2e2;
        color: #b91c1c;
        border: 1px solid #fecaca;
    }
    .pct-pill-blue {
        background: #dbeafe;
        color: #1d4ed8;
        border: 1px solid #bfdbfe;
    }
    .pct-pill-amber {
        background: #fef3c7;
        color: #b45309;
        border: 1px solid #fde68a;
    }
    .keu-kpi-sub {
        font-size: 11px;
        color: #64748b;
        margin-top: 8px;
        display: flex;
        align-items: center;
        gap: 4px;
        flex-wrap: wrap;
    }

    /* ── Filter Bar ──────────────────────────────────────────────── */
    .filter-bar {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 16px 20px;
        margin-bottom: 20px;
    }
    .filter-row {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        align-items: flex-end;
    }
    .filter-group { display: flex; flex-direction: column; gap: 4px; }
    .filter-group label { font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.4px; }
    .filter-group select,
    .filter-group input[type="date"],
    .filter-group input[type="month"],
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
    .filter-group select:focus,
    .filter-group input:focus {
        outline: none;
        border-color: #bb0027;
        background: #fff;
    }

    /* ── Breakdown Section ───────────────────────────────────────── */
    .breakdown-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        margin-bottom: 24px;
    }
    @media (max-width: 768px) {
        .breakdown-grid { grid-template-columns: 1fr; }
        .keu-kpi-grid { grid-template-columns: 1fr 1fr; }
        .filter-row { flex-direction: column; }
    }
    .breakdown-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 18px 20px;
    }
    .breakdown-title {
        font-size: 13px; font-weight: 600; color: #334155;
        margin-bottom: 14px;
        display: flex; align-items: center; gap: 6px;
    }
    .breakdown-title .material-symbols-outlined { font-size: 17px; color: #94a3b8; }
    .breakdown-item {
        display: flex; align-items: center; gap: 10px;
        margin-bottom: 10px;
    }
    .breakdown-bar-wrap { flex: 1; height: 6px; background: #f1f5f9; border-radius: 4px; overflow: hidden; }
    .breakdown-bar { height: 100%; border-radius: 4px; }
    .breakdown-bar.in  { background: linear-gradient(90deg, #22c55e, #16a34a); }
    .breakdown-bar.out { background: linear-gradient(90deg, #f59e0b, #d97706); }
    .breakdown-name { font-size: 12px; color: #334155; min-width: 120px; max-width: 140px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .breakdown-val  { font-size: 12px; font-weight: 600; color: #0f172a; white-space: nowrap; }

    /* ── Status / Tipe Badges ────────────────────────────────────── */
    .badge-lunas      { background: #dcfce7; color: #16a34a; border: 1px solid #bbf7d0; }
    .badge-pending    { background: #fef9c3; color: #a16207; border: 1px solid #fef08a; }
    .badge-pemasukan  { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
    .badge-pengeluaran{ background: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; }
    .nominal-in  { color: #16a34a; font-weight: 600; }
    .nominal-out { color: #dc2626; font-weight: 600; }

    /* ── Filter Mode Tabs ────────────────────────────────────────── */
    .filter-tabs {
        display: flex; gap: 4px;
        background: #f1f5f9;
        border-radius: 8px;
        padding: 3px;
    }
    .filter-tab {
        padding: 5px 14px;
        border-radius: 6px;
        font-size: 12px; font-weight: 600;
        color: #64748b;
        cursor: pointer;
        border: none;
        background: transparent;
        font-family: 'Outfit', sans-serif;
        transition: all 0.15s;
    }
    .filter-tab.active {
        background: #fff;
        color: #bb0027;
        box-shadow: 0 1px 4px rgba(0,0,0,0.08);
    }

    /* ── Search spinner indicator ────────────────────────────────── */
    .search-wrap { position: relative; }
    .search-wrap .search-spin {
        position: absolute; right: 10px; top: 50%; transform: translateY(-50%);
        width: 14px; height: 14px;
        border: 2px solid #e2e8f0;
        border-top-color: #bb0027;
        border-radius: 50%;
        animation: spin 0.6s linear infinite;
        display: none;
    }
    @keyframes spin { to { transform: translateY(-50%) rotate(360deg); } }
</style>
@endpush

@section('content')

{{-- ─── Top Action Bar ──────────────────────────────────────────── --}}
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; flex-wrap:wrap; gap:10px;">
    <div>
        <div style="font-size:13px; color:#64748b;">
            Periode: <strong>{{ \Carbon\Carbon::parse($dateStart)->translatedFormat('d F Y') }}</strong>
            @if($dateStart !== $dateEnd)
                s/d <strong>{{ \Carbon\Carbon::parse($dateEnd)->translatedFormat('d F Y') }}</strong>
            @endif
        </div>
    </div>
    <div style="display:flex; gap:8px; flex-wrap:wrap; align-items:center;">
        {{-- Dropdown Ekspor --}}
        <div class="dropdown-export" style="position:relative; display:inline-block;">
            <button type="button" class="btn btn-secondary" id="btnExportDropdown" onclick="toggleExportMenu(event)"
                    style="display:inline-flex; align-items:center; gap:6px; font-size:13px; font-weight:600; background:#fff; border-color:#cbd5e1; color:#0f172a; cursor:pointer;"
                    title="Opsi Ekspor Laporan">
                <span class="material-symbols-outlined" style="font-size:18px; color:#bb0027;">download</span>
                <span>Ekspor</span>
                <span class="material-symbols-outlined" style="font-size:16px; margin-left:2px;">arrow_drop_down</span>
            </button>
            <div id="exportMenu" class="export-menu-dropdown" style="display:none; position:absolute; right:0; top:calc(100% + 4px); background:#fff; border:1px solid #e2e8f0; border-radius:10px; box-shadow:0 10px 25px rgba(0,0,0,0.1); min-width:220px; z-index:100; overflow:hidden;">
                <a href="{{ route('admin.keuangan.export-excel', request()->query()) }}"
                   style="display:flex; align-items:center; gap:10px; padding:10px 14px; text-decoration:none; font-size:13px; color:#1e293b; font-weight:600; transition:background .15s;">
                    <span class="material-symbols-outlined" style="font-size:18px; color:#16a34a;">table_view</span>
                    <span>Ekspor Excel (.xls)</span>
                </a>
                <a href="{{ route('admin.keuangan.export-pdf', request()->query()) }}" target="_blank"
                   style="display:flex; align-items:center; gap:10px; padding:10px 14px; text-decoration:none; font-size:13px; color:#1e293b; font-weight:600; border-top:1px solid #f1f5f9; transition:background .15s;">
                    <span class="material-symbols-outlined" style="font-size:18px; color:#dc2626;">picture_as_pdf</span>
                    <span>Ekspor PDF / Cetak Laporan</span>
                </a>
                <a href="{{ route('admin.keuangan.export', request()->query()) }}"
                   style="display:flex; align-items:center; gap:10px; padding:10px 14px; text-decoration:none; font-size:13px; color:#64748b; font-weight:500; border-top:1px solid #f1f5f9; transition:background .15s;">
                    <span class="material-symbols-outlined" style="font-size:18px; color:#64748b;">text_snippet</span>
                    <span>Unduh CSV</span>
                </a>
            </div>
        </div>

        <a href="{{ route('admin.keuangan.kategori.index') }}"
           class="btn btn-secondary"
           style="display:inline-flex; align-items:center; gap:6px; font-size:13px;">
            <span class="material-symbols-outlined" style="font-size:16px;">category</span>
            Kelola Kategori
        </a>
        <a href="{{ route('admin.keuangan.kontrak.create') }}"
           class="btn btn-secondary"
           style="display:inline-flex; align-items:center; gap:6px; font-size:13px; color:#4338ca; border-color:#c7d2fe; background:#eef2ff;"
           title="Daftarkan kontrak klien baru">
            <span class="material-symbols-outlined" style="font-size:17px; color:#4f46e5;">handshake</span>
            Kontrak Klien Baru
        </a>
        <a href="{{ route('admin.keuangan.create') }}" class="btn btn-primary"
           style="display:inline-flex; align-items:center; gap:6px;">
            <span class="material-symbols-outlined" style="font-size:16px;">add</span>
            Tambah Transaksi
        </a>
    </div>
</div>

{{-- ─── KPI Cards: 1. Pemasukan -> 2. Pengeluaran -> 3. Piutang -> 4. Selisih ─── --}}
<div class="keu-kpi-grid">
    {{-- 1. Total Pemasukan --}}
    <div class="keu-kpi in">
        <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:12px;">
            <div class="keu-kpi-icon" style="margin-bottom:0;"><span class="material-symbols-outlined">trending_up</span></div>
            <span class="pct-pill pct-pill-green" title="Persentase pemasukan lunas dari total potensi tagihan">
                {{ $pctPemasukanLunas }}% Lunas
            </span>
        </div>
        <div class="keu-kpi-label">Total Pemasukan</div>
        <div class="keu-kpi-value">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</div>
        <div class="keu-kpi-sub">
            <span>{{ $pctArusMasuk }}% porsi kas</span> · <span>{{ $pctPemasukanLunas }}% tertagih</span>
        </div>
    </div>

    {{-- 2. Total Pengeluaran --}}
    <div class="keu-kpi out">
        <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:12px;">
            <div class="keu-kpi-icon" style="margin-bottom:0;"><span class="material-symbols-outlined">trending_down</span></div>
            <span class="pct-pill pct-pill-red" title="Rasio beban pengeluaran terhadap pemasukan">
                {{ $pctRasioBeban }}% Beban
            </span>
        </div>
        <div class="keu-kpi-label">Total Pengeluaran</div>
        <div class="keu-kpi-value">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</div>
        <div class="keu-kpi-sub">
            <span>{{ $pctArusKeluar }}% porsi kas</span> · <span>{{ $pctRasioBeban }}% dari pemasukan</span>
        </div>
    </div>

    {{-- 3. Piutang (Posisi di Kiri Selisih) --}}
    <div class="keu-kpi pip">
        <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:12px;">
            <div class="keu-kpi-icon" style="margin-bottom:0;"><span class="material-symbols-outlined">pending_actions</span></div>
            <span class="pct-pill pct-pill-amber" title="Persentase piutang belum tertagih dari total pemasukan">
                {{ $pctPiutang }}% Tertunda
            </span>
        </div>
        <div class="keu-kpi-label">Piutang</div>
        <div class="keu-kpi-value" style="font-size:17px;">
            <span style="color:#d97706; font-weight:700;">+Rp {{ number_format($totalPiutang, 0, ',', '.') }}</span>
        </div>
        <div class="keu-kpi-sub">
            @if(isset($piutangProyek) && $piutangProyek > 0)
                <span style="color:#d97706; font-weight:600;">Rp {{ number_format($piutangProyek, 0, ',', '.') }} dari kontrak</span>
            @else
                <span>{{ $pctPiutang }}% belum tertagih</span>
            @endif
        </div>
    </div>

    {{-- 4. Selisih (Posisi di Paling Kanan) --}}
    <div class="keu-kpi net">
        <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:12px;">
            <div class="keu-kpi-icon" style="margin-bottom:0;"><span class="material-symbols-outlined">account_balance_wallet</span></div>
            <span class="pct-pill {{ $netSaldo >= 0 ? 'pct-pill-blue' : 'pct-pill-red' }}" title="Margin laba bersih terhadap pemasukan">
                {{ $pctMargin >= 0 ? '+' : '' }}{{ $pctMargin }}% Margin
            </span>
        </div>
        <div class="keu-kpi-label">Selisih</div>
        <div class="keu-kpi-value" style="color: {{ $netSaldo >= 0 ? '#16a34a' : '#dc2626' }}">
            {{ $netSaldo >= 0 ? '' : '-' }}Rp {{ number_format(abs($netSaldo), 0, ',', '.') }}
        </div>
        <div class="keu-kpi-sub">
            <span>{{ $pctMargin }}% margin kas</span>
        </div>
    </div>
</div>

{{-- ─── Filter Bar (Auto-Submit) ───────────────────────────────── --}}
<div class="filter-bar">
    <form method="GET" id="filterForm" action="{{ route('admin.keuangan.index') }}">
        <div class="filter-row">

            {{-- Periode Dropdown --}}
            <div class="filter-group">
                <label>Periode</label>
                <select name="filter_mode" id="filter_mode" onchange="switchModeDropdown(this.value)"
                        style="padding:7px 12px; border:1px solid #cbd5e1; border-radius:8px; font-family:'Outfit',sans-serif; font-size:13px; font-weight:600; color:#0f172a; background:#fff; min-width:140px;">
                    <option value="bulanan" {{ $filterMode === 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                    <option value="range_bulan" {{ $filterMode === 'range_bulan' ? 'selected' : '' }}>Rentang Bulan</option>
                    <option value="harian" {{ $filterMode === 'harian' ? 'selected' : '' }}>Harian</option>
                    <option value="range_hari" {{ $filterMode === 'range_hari' ? 'selected' : '' }}>Rentang Hari</option>
                    <option value="tahunan" {{ $filterMode === 'tahunan' ? 'selected' : '' }}>Tahunan</option>
                    <option value="semua" {{ $filterMode === 'semua' ? 'selected' : '' }}>Semua Periode</option>
                </select>
            </div>

            {{-- Date Pickers --}}
            <div class="filter-group" id="wrap_harian" style="{{ $filterMode === 'harian' ? '' : 'display:none' }}">
                <label>Tanggal</label>
                <input type="date" name="filter_date" id="filter_date" value="{{ $filterDate }}"
                    onchange="autoSubmit()">
            </div>
            <div class="filter-group" id="wrap_range_hari" style="{{ $filterMode === 'range_hari' ? '' : 'display:none' }}; display:{{ $filterMode === 'range_hari' ? 'flex' : 'none' }}; flex-direction:row; gap:6px; align-items:flex-end;">
                <div>
                    <label style="display:block;font-size:11px;font-weight:600;color:#64748b;margin-bottom:4px;">Dari Tanggal</label>
                    <input type="date" name="date_start" id="date_start" value="{{ $dateStartCustom }}" onchange="autoSubmit()">
                </div>
                <div>
                    <label style="display:block;font-size:11px;font-weight:600;color:#64748b;margin-bottom:4px;">Sampai Tanggal</label>
                    <input type="date" name="date_end" id="date_end" value="{{ $dateEndCustom }}" onchange="autoSubmit()">
                </div>
            </div>
            <div class="filter-group" id="wrap_bulanan" style="{{ $filterMode === 'bulanan' ? '' : 'display:none' }}">
                <label>Bulan</label>
                <input type="month" name="filter_month" id="filter_month" value="{{ $filterMonth }}"
                    onchange="autoSubmit()">
            </div>
            <div class="filter-group" id="wrap_range_bulan" style="{{ $filterMode === 'range_bulan' ? '' : 'display:none' }}; display:{{ $filterMode === 'range_bulan' ? 'flex' : 'none' }}; flex-direction:row; gap:6px; align-items:flex-end;">
                <div>
                    <label style="display:block;font-size:11px;font-weight:600;color:#64748b;margin-bottom:4px;">Dari Bulan</label>
                    <input type="month" name="month_start" id="month_start" value="{{ $monthStart }}" onchange="autoSubmit()">
                </div>
                <div>
                    <label style="display:block;font-size:11px;font-weight:600;color:#64748b;margin-bottom:4px;">Sampai Bulan</label>
                    <input type="month" name="month_end" id="month_end" value="{{ $monthEnd }}" onchange="autoSubmit()">
                </div>
            </div>
            <div class="filter-group" id="wrap_tahunan" style="{{ $filterMode === 'tahunan' ? '' : 'display:none' }}">
                <label>Tahun</label>
                <select name="filter_year" id="filter_year" onchange="autoSubmit()">
                    @for($y = now()->year; $y >= now()->year - 5; $y--)
                        <option value="{{ $y }}" {{ $filterYear == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>

            {{-- Transaksi (sebelumnya Tipe) --}}
            <div class="filter-group">
                <label>Transaksi</label>
                <select name="tipe" onchange="autoSubmit()">
                    <option value="">Semua Transaksi</option>
                    <option value="pemasukan"   {{ $filterTipe === 'pemasukan'   ? 'selected' : '' }}>Pemasukan</option>
                    <option value="pengeluaran" {{ $filterTipe === 'pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
                </select>
            </div>

            {{-- Status --}}
            <div class="filter-group">
                <label>Status</label>
                <select name="status" onchange="autoSubmit()">
                    <option value="">Semua Status</option>
                    <option value="lunas"   {{ $filterStatus === 'lunas'   ? 'selected' : '' }}>Lunas</option>
                    <option value="pending" {{ $filterStatus === 'pending' || $filterStatus === 'piutang' ? 'selected' : '' }}>Piutang</option>
                </select>
            </div>

            {{-- Program --}}
            <div class="filter-group">
                <label>Program</label>
                <select name="service_id" onchange="autoSubmit()">
                    <option value="">Semua Program</option>
                    @foreach($services as $svc)
                        <option value="{{ $svc->id }}" {{ $filterService == $svc->id ? 'selected' : '' }}>
                            {{ $svc->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Search --}}
            <div class="filter-group search-wrap" style="flex:1; min-width:160px;">
                <label>Search</label>
                <input type="text" name="search" id="searchInput"
                    value="{{ $search }}"
                    placeholder="Search kode, deskripsi..."
                    autocomplete="off">
                <div class="search-spin" id="searchSpin"></div>
            </div>

            {{-- Reset only --}}
            <div class="filter-group">
                <label>&nbsp;</label>
                <a href="{{ route('admin.keuangan.index') }}" class="btn btn-secondary btn-sm"
                   style="display:inline-flex; align-items:center; gap:5px; white-space:nowrap;">
                    <span class="material-symbols-outlined" style="font-size:14px;">restart_alt</span> Reset
                </a>
            </div>
        </div>
    </form>
</div>

{{-- ─── Breakdown Charts ────────────────────────────────────────── --}}
@if($breakdownService->count() > 0 || $breakdownKategori->count() > 0)
<div class="breakdown-grid">
    <div class="breakdown-card">
        <div class="breakdown-title">
            <span class="material-symbols-outlined">bar_chart</span>
            Pemasukan per Program Layanan (Lunas)
        </div>
        @if($breakdownService->count() > 0)
            @php $maxIn = $breakdownService->max('total'); @endphp
            @foreach($breakdownService as $bs)
            <div class="breakdown-item">
                <div class="breakdown-name" title="{{ $bs->service_title }}">{{ $bs->service_title }}</div>
                <div class="breakdown-bar-wrap">
                    <div class="breakdown-bar in" style="width:{{ $maxIn > 0 ? round(($bs->total/$maxIn)*100) : 0 }}%"></div>
                </div>
                <div class="breakdown-val">{{ number_format($bs->total,0,',','.') }}</div>
            </div>
            @endforeach
        @else
            <div style="font-size:13px; color:#94a3b8; padding:10px 0;">Belum ada data pemasukan lunas per program.</div>
        @endif
    </div>

    <div class="breakdown-card">
        <div class="breakdown-title">
            <span class="material-symbols-outlined">donut_small</span>
            Pengeluaran per Kategori (Lunas)
        </div>
        @if($breakdownKategori->count() > 0)
            @php $maxOut = $breakdownKategori->max('total'); @endphp
            @foreach($breakdownKategori as $bk)
            <div class="breakdown-item">
                <div class="breakdown-name" title="{{ $bk->kategori_nama }}">{{ $bk->kategori_nama }}</div>
                <div class="breakdown-bar-wrap">
                    <div class="breakdown-bar out" style="width:{{ $maxOut > 0 ? round(($bk->total/$maxOut)*100) : 0 }}%"></div>
                </div>
                <div class="breakdown-val">{{ number_format($bk->total,0,',','.') }}</div>
            </div>
            @endforeach
        @else
            <div style="font-size:13px; color:#94a3b8; padding:10px 0;">Belum ada data pengeluaran lunas per kategori.</div>
        @endif
    </div>
</div>
@endif

{{-- ─── Transactions Table ──────────────────────────────────────── --}}
<div class="card" style="padding:0; overflow:hidden;">
    <div style="padding:16px 20px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; justify-content:space-between;">
        <span style="font-size:14px; font-weight:600; color:#334155;">
            Daftar Transaksi
            <span style="font-size:12px; color:#94a3b8; font-weight:400; margin-left:6px;">
                {{ $transaksis->total() }} transaksi ditemukan
            </span>
        </span>
    </div>
    <div style="overflow-x:auto;">
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width:130px;">Kode</th>
                    <th style="width:90px;">Tanggal</th>
                    <th style="width:100px;">Transaksi</th>
                    <th>Deskripsi</th>
                    <th>Program</th>
                    <th style="text-align:right; width:140px; white-space:nowrap;">Nominal</th>
                    <th style="width:90px; white-space:nowrap;">Metode</th>
                    <th style="width:120px; white-space:nowrap;">Status</th>
                    <th style="width:145px; white-space:nowrap;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksis as $trx)
                <tr>
                    <td>
                        <a href="{{ route('admin.keuangan.show', $trx) }}"
                           style="font-size:11px; font-family:monospace; color:#bb0027; text-decoration:none; font-weight:600;">
                            {{ $trx->kode_transaksi }}
                        </a>
                    </td>
                    <td style="font-size:12px; color:#64748b;">{{ $trx->tanggal->format('d/m/Y') }}</td>
                    <td>
                        <span class="badge {{ $trx->tipe === 'pemasukan' ? 'badge-pemasukan' : 'badge-pengeluaran' }}"
                              style="font-size:11px; padding:3px 8px; border-radius:6px; display:inline-flex; align-items:center; gap:3px;">
                            <span class="material-symbols-outlined" style="font-size:12px;">
                                {{ $trx->tipe === 'pemasukan' ? 'arrow_downward' : 'arrow_upward' }}
                            </span>
                            {{ $trx->tipe === 'pemasukan' ? 'Masuk' : 'Keluar' }}
                        </span>
                    </td>
                    <td>
                        <div style="font-size:13px; font-weight:600; color:#0f172a;">{{ Str::limit($trx->deskripsi ?: $trx->judul, 45) }}</div>
                        <div style="font-size:11px; color:#94a3b8; display:flex; gap:6px; flex-wrap:wrap; margin-top:2px;">
                            <span>{{ $trx->kategori?->nama ?? '—' }}</span>
                            @if($trx->penerima)
                                <span style="color:#64748b;">· {{ Str::limit($trx->penerima, 25) }}</span>
                            @endif
                            @if($trx->proyekKlien)
                                <a href="{{ route('admin.keuangan.kontrak.show', $trx->proyekKlien->id) }}" style="color:#4f46e5; text-decoration:none; font-weight:600;" title="Buka Detail Kontrak Klien">
                                    · [{{ $trx->proyekKlien->kode_proyek }}] {{ Str::limit($trx->proyekKlien->nama_klien, 18) }}
                                </a>
                            @endif
                            @if($trx->bukti)
                                <a href="{{ asset('storage/'.$trx->bukti) }}" target="_blank"
                                   style="color:#0284c7; text-decoration:none; font-weight:600; display:inline-flex; align-items:center; gap:2px;" title="Lihat Foto / Dokumen Bukti">
                                    · <span class="material-symbols-outlined" style="font-size:13px;">photo_camera</span> Bukti
                                </a>
                            @endif
                        </div>
                    </td>
                    <td style="font-size:12px; color:#64748b;">{{ $trx->service?->title ?? '—' }}</td>
                    <td style="text-align:right; font-size:13px; white-space:nowrap;" class="{{ $trx->tipe === 'pemasukan' ? 'nominal-in' : 'nominal-out' }}">
                        {{ $trx->tipe === 'pemasukan' ? '+' : '-' }}Rp {{ number_format($trx->nominal, 0, ',', '.') }}
                    </td>
                    <td style="font-size:11px; color:#64748b;">{{ $trx->metode_pembayaran }}</td>
                    <td>
                        @if($trx->status === 'lunas')
                            <span class="badge badge-lunas" style="font-size:11px; padding:3px 8px; border-radius:6px; display:inline-flex; align-items:center; gap:3px;">
                                <span class="material-symbols-outlined" style="font-size:12px;">check_circle</span> Lunas
                            </span>
                        @else
                            <div style="display:flex; flex-direction:column; gap:4px; align-items:flex-start;">
                                <span class="badge badge-pending" style="font-size:11px; padding:3px 8px; border-radius:6px; display:inline-flex; align-items:center; gap:3px;">
                                    <span class="material-symbols-outlined" style="font-size:12px;">schedule</span> Piutang
                                </span>
                                <form method="POST" action="{{ route('admin.keuangan.tandai-lunas', $trx) }}">
                                    @csrf
                                    <button type="submit"
                                        style="font-size:10px; color:#16a34a; background:none; border:none; cursor:pointer; font-family:'Outfit',sans-serif; padding:0; text-decoration:underline;"
                                        onclick="return confirm('Tandai transaksi ini sebagai Lunas?')">
                                        ✓ Tandai Lunas
                                    </button>
                                </form>
                            </div>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex; gap:5px;">
                            <a href="{{ route('admin.keuangan.show', $trx) }}" class="btn btn-secondary btn-sm" title="Detail">
                                <span class="material-symbols-outlined">visibility</span>
                            </a>
                            <a href="{{ route('admin.keuangan.edit', $trx) }}" class="btn btn-secondary btn-sm" title="Edit">
                                <span class="material-symbols-outlined">edit</span>
                            </a>
                            <form method="POST" action="{{ route('admin.keuangan.destroy', $trx) }}"
                                  onsubmit="return confirm('Yakin hapus transaksi [{{ $trx->kode_transaksi }}]?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                    <span class="material-symbols-outlined">delete</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" style="text-align:center; padding:48px; color:#94a3b8;">
                        <span class="material-symbols-outlined" style="font-size:36px; display:block; margin-bottom:8px; opacity:.4;">receipt_long</span>
                        Belum ada transaksi pada periode ini.
                        <div style="margin-top:8px;">
                            <a href="{{ route('admin.keuangan.create') }}" style="color:#bb0027; text-decoration:none; font-weight:600;">
                                + Tambah transaksi pertama
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div style="margin-top:16px;">
    {{ $transaksis->links() }}
</div>

@endsection

@push('scripts')
<script>
(function () {
    const form       = document.getElementById('filterForm');
    const modeInput  = document.getElementById('filter_mode');
    const searchInput= document.getElementById('searchInput');
    const searchSpin = document.getElementById('searchSpin');
    let searchTimer  = null;

    // ── Auto-submit helper ────────────────────────────────────
    window.autoSubmit = function () {
        form.submit();
    };

    // ── Periode Dropdown switching ────────────────────────────
    window.switchModeDropdown = function (mode) {
        modeInput.value = mode;

        // Show/hide date pickers
        ['harian', 'range_hari', 'bulanan', 'range_bulan', 'tahunan'].forEach(m => {
            const el = document.getElementById('wrap_' + m);
            if (el) {
                if (m === mode) {
                    el.style.display = (m === 'range_hari' || m === 'range_bulan') ? 'flex' : '';
                } else {
                    el.style.display = 'none';
                }
            }
        });

        // Auto-submit immediately except for custom range
        if (mode !== 'range_hari' && mode !== 'range_bulan') {
            form.submit();
        }
    };

    // ── Export Dropdown Toggle ────────────────────────────────
    window.toggleExportMenu = function(e) {
        e.stopPropagation();
        const menu = document.getElementById('exportMenu');
        if (menu) {
            menu.style.display = (menu.style.display === 'none' || menu.style.display === '') ? 'block' : 'none';
        }
    };

    document.addEventListener('click', function(e) {
        const menu = document.getElementById('exportMenu');
        if (menu && !e.target.closest('.dropdown-export')) {
            menu.style.display = 'none';
        }
    });

    // ── Search with debounce (700ms) ──────────────────────────
    searchInput.addEventListener('input', function () {
        clearTimeout(searchTimer);
        searchSpin.style.display = 'block';
        searchTimer = setTimeout(function () {
            form.submit();
        }, 700);
    });

    // Enter key on search submits immediately
    searchInput.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            clearTimeout(searchTimer);
            form.submit();
        }
    });
})();
</script>
@endpush
