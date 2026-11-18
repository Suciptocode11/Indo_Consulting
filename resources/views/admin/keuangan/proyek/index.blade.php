@extends('admin.layouts.app')

@section('title', 'Proyek Klien')
@section('page-title', 'Proyek Klien')

@push('styles')
<style>
    /* ── KPI Cards ───────────────────────────────────────────────── */
    .keu-kpi-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 16px; margin-bottom: 24px; }
    .keu-kpi { background: #fff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 20px 22px; position: relative; overflow: hidden; }
    .keu-kpi::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; border-radius: 14px 14px 0 0; }
    .keu-kpi.contract::before { background: linear-gradient(90deg, #6366f1, #4f46e5); }
    .keu-kpi.in::before       { background: linear-gradient(90deg, #22c55e, #16a34a); }
    .keu-kpi.pip::before      { background: linear-gradient(90deg, #f59e0b, #d97706); }
    .keu-kpi.net::before      { background: linear-gradient(90deg, #3b82f6, #2563eb); }
    
    .keu-kpi-icon { width: 38px; height: 38px; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 14px; }
    .keu-kpi-icon .material-symbols-outlined { font-size: 20px; color: #fff; }
    .keu-kpi.contract .keu-kpi-icon { background: #6366f1; }
    .keu-kpi.in       .keu-kpi-icon { background: #22c55e; }
    .keu-kpi.pip      .keu-kpi-icon { background: #f59e0b; }
    .keu-kpi.net      .keu-kpi-icon { background: #3b82f6; }
    
    .keu-kpi-label { font-size: 11px; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px; }
    .keu-kpi-value { font-size: 22px; font-weight: 700; color: #0f172a; line-height: 1.1; word-break: break-word; }
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
    .filter-bar { background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 16px 20px; margin-bottom: 20px; }
    .filter-row { display: flex; flex-wrap: wrap; gap: 10px; align-items: flex-end; }
    .filter-group { display: flex; flex-direction: column; gap: 4px; }
    .filter-group label { font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.4px; }
    .filter-group select, .filter-group input[type="text"] {
        padding: 7px 12px; border: 1px solid #e2e8f0; border-radius: 8px;
        font-family: 'Outfit', sans-serif; font-size: 13px; color: #0f172a; background: #f8fafc; cursor: pointer;
    }
    .filter-group select:focus, .filter-group input:focus { outline: none; border-color: #bb0027; box-shadow: 0 0 0 3px rgba(187,0,39,.08); }

    /* ── Table & Cards ───────────────────────────────────────────── */
    .table-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 16px; overflow: hidden; }
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
    .table-card table { width: 100%; min-width: 1000px; border-collapse: collapse; }
    .table-card thead th { background: #f8fafc; padding: 12px 16px; text-align: left; font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid #e2e8f0; white-space: nowrap; }
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
        background: #fafafa;
    }
    .table-card tbody tr { border-bottom: 1px solid #f1f5f9; transition: background .15s; }
    .table-card tbody tr:last-child { border-bottom: none; }
    .table-card tbody tr:hover { background: #fafafa; }
    .table-card td { padding: 13px 16px; font-size: 13px; color: #334155; vertical-align: middle; }

    .proj-title { font-weight: 700; color: #0f172a; text-decoration: none; display: inline-block; }
    .proj-title:hover { color: #bb0027; }
    .proj-client { font-size: 12px; color: #64748b; margin-top: 2px; display: flex; align-items: center; gap: 4px; }
    .proj-code   { display: inline-block; font-family: monospace; font-size: 11px; font-weight: 600; padding: 1px 6px; background: #f1f5f9; color: #475569; border-radius: 5px; margin-bottom: 3px; }

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
        display: inline-flex; align-items: center; gap: 7px;
        padding: 9px 18px; border-radius: 10px; background: #bb0027; color: #fff;
        font-weight: 600; font-size: 13px; text-decoration: none; transition: background .15s;
    }
    .btn-add:hover { background: #9a0020; color: #fff; }

    .empty-state { text-align: center; padding: 60px 20px; color: #94a3b8; }
    .empty-state .material-symbols-outlined { font-size: 52px; display: block; margin-bottom: 12px; color: #cbd5e1; }
    .empty-state h3 { font-size: 16px; font-weight: 700; color: #475569; margin: 0 0 6px; }
    .empty-state p { font-size: 13px; color: #94a3b8; margin: 0 0 16px; }
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
            <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">Proyek Klien</h1>
            <p style="font-size:13px;color:#64748b;margin:4px 0 0;">Kelola kontrak klien, realisasi pembayaran termin, dan biaya operasional per proyek</p>
        </div>
        <a href="{{ route('admin.keuangan.proyek.create') }}" class="btn-add">
            <span class="material-symbols-outlined" style="font-size:18px;">add_circle</span>
            Tambah Proyek Klien
        </a>
    </div>

    {{-- KPI Cards (5 Cards) --}}
    @php
        $pctIn  = $totalNilaiKontrak > 0 ? round(($totalPemasukan / $totalNilaiKontrak) * 100, 1) : 0;
        $pctPip = $totalNilaiKontrak > 0 ? round(($totalSisaTagihan / $totalNilaiKontrak) * 100, 1) : 0;
        $pctOut = $totalPemasukan > 0 ? round(($totalPengeluaran / $totalPemasukan) * 100, 1) : 0;
        $pctNet = $totalPemasukan > 0 ? round(($totalLabaBersih / $totalPemasukan) * 100, 1) : 0;
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
                <span>Seluruh proyek klien</span>
            </div>
        </div>
        <div class="keu-kpi in">
            <div class="keu-kpi-icon"><span class="material-symbols-outlined">payments</span></div>
            <div class="keu-kpi-label">Uang Diterima (Termin)</div>
            <div class="keu-kpi-value" style="color:#16a34a;">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</div>
            <div class="keu-kpi-sub">
                <span class="pct-pill pct-pill-green">
                    <span class="material-symbols-outlined" style="font-size:12px;">arrow_upward</span>
                    {{ $pctIn }}%
                </span>
                <span>tercairkan dari kontrak</span>
            </div>
        </div>
        <div class="keu-kpi" style="border-top:3px solid #ef4444;">
            <div class="keu-kpi-icon" style="background:#ef4444;"><span class="material-symbols-outlined">receipt</span></div>
            <div class="keu-kpi-label">Beban Biaya Proyek</div>
            <div class="keu-kpi-value" style="color:#dc2626;">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</div>
            <div class="keu-kpi-sub">
                <span class="pct-pill pct-pill-red">
                    <span class="material-symbols-outlined" style="font-size:12px;">arrow_downward</span>
                    {{ $pctOut }}%
                </span>
                <span>rasio biaya operasional</span>
            </div>
        </div>
        <div class="keu-kpi pip">
            <div class="keu-kpi-icon"><span class="material-symbols-outlined">pending_actions</span></div>
            <div class="keu-kpi-label">Piutang</div>
            <div class="keu-kpi-value" style="color:#d97706;">Rp {{ number_format($totalSisaTagihan, 0, ',', '.') }}</div>
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
            <div class="keu-kpi-value {{ $totalLabaBersih >= 0 ? '' : 'text-red' }}" style="color:{{ $totalLabaBersih >= 0 ? '#2563eb' : '#dc2626' }};">
                {{ $totalLabaBersih < 0 ? '-' : '' }}Rp {{ number_format(abs($totalLabaBersih), 0, ',', '.') }}
            </div>
            <div class="keu-kpi-sub">
                <span class="pct-pill {{ $totalLabaBersih >= 0 ? 'pct-pill-blue' : 'pct-pill-red' }}">
                    <span class="material-symbols-outlined" style="font-size:12px;">{{ $totalLabaBersih >= 0 ? 'trending_up' : 'trending_down' }}</span>
                    {{ number_format(abs($pctNet), 1) }}%
                </span>
                <span>margin bersih keuntungan</span>
            </div>
        </div>
    </div>

    {{-- Filter Bar --}}
    <div class="filter-bar">
        {{-- Quick Filter Tabs --}}
        <div style="display:flex;gap:6px;margin-bottom:14px;flex-wrap:wrap;align-items:center;">
            <a href="{{ route('admin.keuangan.proyek.index', array_merge(request()->query(), ['status' => ''])) }}"
               class="btn-action {{ empty($status) ? 'btn-primary' : 'btn-action-primary' }}" style="padding:5px 12px;border-radius:20px;font-size:12px;">
               Semua Proyek
            </a>
            <a href="{{ route('admin.keuangan.proyek.index', array_merge(request()->query(), ['status' => 'piutang'])) }}"
               class="btn-action" style="padding:5px 12px;border-radius:20px;font-size:12px;color:{{ $status === 'piutang' ? '#fff' : '#b45309' }};border:1px solid #fde68a;background:{{ $status === 'piutang' ? '#d97706' : '#fffbeb' }};font-weight:700;">
               <span class="material-symbols-outlined" style="font-size:15px;">pending_actions</span>
               Piutang (Belum Lunas)
            </a>
            <a href="{{ route('admin.keuangan.proyek.index', array_merge(request()->query(), ['status' => 'berjalan'])) }}"
               class="btn-action {{ $status === 'berjalan' ? 'btn-primary' : 'btn-action-primary' }}" style="padding:5px 12px;border-radius:20px;font-size:12px;">
               Sedang Berjalan
            </a>
            <a href="{{ route('admin.keuangan.proyek.index', array_merge(request()->query(), ['status' => 'lunas'])) }}"
               class="btn-action" style="padding:5px 12px;border-radius:20px;font-size:12px;color:{{ $status === 'lunas' ? '#fff' : '#15803d' }};border:1px solid #bbf7d0;background:{{ $status === 'lunas' ? '#16a34a' : '#f0fdf4' }};font-weight:700;">
               <span class="material-symbols-outlined" style="font-size:15px;">check_circle</span>
               Lunas
            </a>
            <a href="{{ route('admin.keuangan.proyek.index', array_merge(request()->query(), ['status' => 'selesai'])) }}"
               class="btn-action {{ $status === 'selesai' ? 'btn-primary' : 'btn-action-primary' }}" style="padding:5px 12px;border-radius:20px;font-size:12px;">
               Selesai
            </a>
        </div>

        <form method="GET" action="{{ route('admin.keuangan.proyek.index') }}" id="filterForm">
            <div class="filter-row">
                <div class="filter-group" style="flex:1;min-width:200px;">
                    <label>Search</label>
                    <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama proyek, klien, kode..." onchange="document.getElementById('filterForm').submit()">
                </div>
                <div class="filter-group">
                    <label>Status & Piutang</label>
                    <select name="status" onchange="document.getElementById('filterForm').submit()">
                        <option value="">Semua Status</option>
                        <option value="piutang"  {{ $status === 'piutang'  ? 'selected' : '' }}>Piutang (Belum Lunas)</option>
                        <option value="berjalan" {{ $status === 'berjalan' ? 'selected' : '' }}>Berjalan</option>
                        <option value="lunas"    {{ $status === 'lunas'    ? 'selected' : '' }}>Lunas</option>
                        <option value="selesai"  {{ $status === 'selesai'  ? 'selected' : '' }}>Selesai</option>
                        <option value="pending"  {{ $status === 'pending'  ? 'selected' : '' }}>Pending</option>
                        <option value="batal"    {{ $status === 'batal'    ? 'selected' : '' }}>Batal</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label>Program Layanan</label>
                    <select name="service_id" onchange="document.getElementById('filterForm').submit()">
                        <option value="">Semua Program</option>
                        @foreach($services as $s)
                            <option value="{{ $s->id }}" {{ $serviceId == $s->id ? 'selected' : '' }}>{{ $s->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-group">
                    <label>Tahun</label>
                    <select name="tahun" onchange="document.getElementById('filterForm').submit()">
                        <option value="">Semua Tahun</option>
                        @foreach($tahunList as $t)
                            <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>{{ $t }}</option>
                        @endforeach
                    </select>
                </div>
                @if($search || $status || $serviceId || $tahun)
                <div class="filter-group" style="justify-content:flex-end;">
                    <a href="{{ route('admin.keuangan.proyek.index') }}" style="font-size:12px;color:#dc2626;text-decoration:none;padding:8px 0;display:inline-flex;align-items:center;gap:3px;">
                        <span class="material-symbols-outlined" style="font-size:15px;">close</span> Reset
                    </a>
                </div>
                @endif
            </div>
        </form>
    </div>

    {{-- Projects Table --}}
    @if($proyeks->isEmpty())
        <div class="table-card">
            <div class="empty-state">
                <span class="material-symbols-outlined">handshake</span>
                <h3>Belum Ada Proyek Klien</h3>
                <p>Mulai tambahkan proyek klien baru untuk melacak nilai kontrak, termin pembayaran, dan biaya proyek.</p>
                <a href="{{ route('admin.keuangan.proyek.create') }}" class="btn-add">
                    <span class="material-symbols-outlined" style="font-size:18px;">add_circle</span>
                    Tambah Proyek Pertama
                </a>
            </div>
        </div>
    @else
        <div class="table-card">
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Proyek & Klien</th>
                            <th>Layanan</th>
                            <th style="text-align:right;">Nilai Kontrak</th>
                            <th>Progress Termin</th>
                            <th style="text-align:right;">Pengeluaran</th>
                            <th style="text-align:right;">Selisih</th>
                            <th style="text-align:center;">Status</th>
                            <th class="col-actions" style="text-align:center;">Aksi</th>
                        </tr>
                    </thead>
                <tbody>
                    @foreach($proyeks as $i => $proj)
                        @php
                            $inflow   = $proj->total_pemasukan;
                            $outflow  = $proj->total_pengeluaran;
                            $sisa     = $proj->sisa_tagihan;
                            $laba     = $proj->laba_bersih;
                            $progress = $proj->progress_pembayaran;
                            $badge    = $proj->status_badge;
                        @endphp
                        <tr>
                            <td style="color:#94a3b8;font-weight:600;">{{ $i + 1 }}</td>
                            <td>
                                <div class="proj-code">{{ $proj->kode_proyek }}</div>
                                <div>
                                    <a href="{{ route('admin.keuangan.proyek.show', $proj->id) }}" class="proj-title">
                                        {{ $proj->nama_proyek }}
                                    </a>
                                </div>
                                <div class="proj-client">
                                    <span class="material-symbols-outlined" style="font-size:13px;color:#94a3b8;">domain</span>
                                    <span>{{ $proj->nama_klien }}</span>
                                    @if($proj->kontak_klien)
                                        <span style="color:#cbd5e1;">•</span>
                                        <span style="color:#94a3b8;">{{ $proj->kontak_klien }}</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @if($proj->service)
                                    <span class="badge badge-gray">{{ Str::limit($proj->service->title, 26) }}</span>
                                @else
                                    <span style="color:#cbd5e1;">—</span>
                                @endif
                            </td>
                            <td style="text-align:right;font-weight:700;color:#0f172a;">
                                Rp {{ number_format($proj->nilai_kontrak, 0, ',', '.') }}
                            </td>
                            <td>
                                <div style="display:flex;justify-content:space-between;font-size:11px;color:#64748b;margin-bottom:2px;">
                                    <span>Rp {{ number_format($inflow, 0, ',', '.') }}</span>
                                    <span style="font-weight:700;">{{ $progress }}%</span>
                                </div>
                                <div class="prog-wrap">
                                    <div class="prog-track">
                                        <div class="prog-fill" style="width: {{ $progress }}%;"></div>
                                    </div>
                                </div>
                                @if($sisa > 0)
                                    <div style="font-size:10px;color:#d97706;margin-top:3px;">
                                        Sisa: Rp {{ number_format($sisa, 0, ',', '.') }}
                                    </div>
                                @endif
                            </td>
                            <td style="text-align:right;color:#dc2626;font-weight:600;">
                                @if($outflow > 0)
                                    Rp {{ number_format($outflow, 0, ',', '.') }}
                                @else
                                    <span style="color:#cbd5e1;">Rp 0</span>
                                @endif
                            </td>
                            <td style="text-align:right;font-weight:700;color:{{ $laba >= 0 ? '#16a34a' : '#dc2626' }};">
                                {{ $laba < 0 ? '-' : '' }}Rp {{ number_format(abs($laba), 0, ',', '.') }}
                            </td>
                            <td style="text-align:center;">
                                <span class="badge {{ $badge['class'] }}">
                                    <span class="material-symbols-outlined" style="font-size:12px;">{{ $badge['icon'] }}</span>
                                    {{ $badge['label'] }}
                                </span>
                            </td>
                            <td class="col-actions" style="text-align:center;white-space:nowrap;">
                                <div style="display:inline-flex;gap:4px;">
                                    <a href="{{ route('admin.keuangan.proyek.show', $proj->id) }}" class="btn-action btn-action-primary" title="Detail & Pembayaran">
                                        <span class="material-symbols-outlined" style="font-size:15px;">visibility</span>
                                        Detail
                                    </a>
                                    <a href="{{ route('admin.keuangan.proyek.edit', $proj->id) }}" class="btn-action btn-action-primary" title="Edit Proyek">
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
        <div style="margin-top:12px;font-size:12px;color:#94a3b8;text-align:right;">
            Total {{ $proyeks->count() }} proyek klien ditemukan
        </div>
    @endif
</div>
@endsection
