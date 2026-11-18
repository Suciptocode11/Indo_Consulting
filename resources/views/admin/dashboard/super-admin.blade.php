@extends('admin.layouts.app')

@section('title', 'Dashboard Super Admin')
@section('page-title', 'Dashboard Super Admin')

@push('styles')
<style>
    .dash-hero {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        border-radius: 16px;
        padding: 24px 28px;
        color: #fff;
        margin-bottom: 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
        box-shadow: 0 10px 25px -5px rgba(15,23,42,0.2);
    }
    .dash-hero-title {
        font-size: 20px;
        font-weight: 800;
        margin: 0 0 4px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .dash-hero-badge {
        font-size: 11px;
        font-weight: 700;
        background: #bb0027;
        color: #fff;
        padding: 3px 10px;
        border-radius: 20px;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }
    .dash-hero-sub {
        font-size: 13px;
        color: #94a3b8;
        margin: 0;
    }

    /* KPI Keuangan */
    .keu-kpi-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(210px, 1fr));
        gap: 14px;
        margin-bottom: 24px;
    }
    .keu-kpi {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 16px 18px;
        position: relative;
        overflow: hidden;
    }
    .keu-kpi::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
    }
    .keu-kpi.contract::before { background: linear-gradient(90deg, #6366f1, #4f46e5); }
    .keu-kpi.in::before       { background: linear-gradient(90deg, #22c55e, #16a34a); }
    .keu-kpi.out::before      { background: linear-gradient(90deg, #ef4444, #dc2626); }
    .keu-kpi.pip::before      { background: linear-gradient(90deg, #f59e0b, #d97706); }
    .keu-kpi.net::before      { background: linear-gradient(90deg, #3b82f6, #2563eb); }

    .keu-kpi-label { font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px; }
    .keu-kpi-val   { font-size: 20px; font-weight: 800; color: #0f172a; line-height: 1.1; }
    .keu-kpi-sub   { font-size: 11px; color: #94a3b8; margin-top: 6px; display: flex; align-items: center; gap: 4px; }

    /* Operational Grid */
    .ops-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 12px;
        margin-bottom: 24px;
    }
    .ops-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 14px 16px;
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
        transition: all .15s;
    }
    .ops-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0,0,0,0.04);
        border-color: #cbd5e1;
    }
    .ops-icon {
        width: 40px; height: 40px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        color: #fff;
    }
    .ops-val { font-size: 18px; font-weight: 800; color: #0f172a; line-height: 1.1; }
    .ops-label { font-size: 11px; color: #64748b; font-weight: 600; margin-top: 2px; }

    /* Dual Table */
    .dual-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        margin-bottom: 24px;
    }
    @media (max-width: 900px) {
        .dual-grid { grid-template-columns: 1fr; }
    }
    .panel-box {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        overflow: hidden;
    }
    .panel-head {
        padding: 14px 18px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .panel-title {
        font-size: 13px;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .panel-body { padding: 0; }

    /* Quick Actions */
    .btn-quick-act {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 14px;
        border-radius: 8px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        color: #334155;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        transition: all .15s;
    }
    .btn-quick-act:hover {
        background: #f1f5f9;
        color: #0f172a;
        border-color: #cbd5e1;
    }
</style>
@endpush

@section('content')
<div>
    {{-- Hero Greeting --}}
    <div class="dash-hero">
        <div>
            <h1 class="dash-hero-title">
                Selamat Datang, {{ Auth::user()->nama ?? 'Administrator' }}!
                <span class="dash-hero-badge">Super Admin</span>
            </h1>
            <p class="dash-hero-sub">Ikhtisar eksekutif komprehensif atas operasional website dan kesehatan keuangan PT Indo Consulting</p>
        </div>
        <div style="display:flex; gap:8px;">
            <a href="{{ route('admin.keuangan.index') }}" class="btn btn-primary" style="background:#bb0027; border-color:#bb0027; font-size:12px; padding:7px 14px;">
                <span class="material-symbols-outlined" style="font-size:16px;">account_balance_wallet</span> Buku Kas Umum
            </a>
            <a href="{{ route('admin.keuangan.program.index') }}" class="btn btn-secondary" style="font-size:12px; padding:7px 14px;">
                <span class="material-symbols-outlined" style="font-size:16px;">history_edu</span> Keuangan Program
            </a>
        </div>
    </div>

    {{-- Section Title 1: Ringkasan Finansial --}}
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
        <h2 style="font-size:14px; font-weight:800; color:#0f172a; text-transform:uppercase; letter-spacing:0.5px; margin:0; display:flex; align-items:center; gap:6px;">
            <span class="material-symbols-outlined" style="font-size:18px; color:#bb0027;">payments</span>
            Ringkasan Keuangan Perusahaan
        </h2>
        <a href="{{ route('admin.keuangan.index') }}" style="font-size:12px; font-weight:600; color:#4f46e5; text-decoration:none;">
            Buka Kas &rarr;
        </a>
    </div>

    {{-- 5 Financial KPI Cards (Nilai Kontrak -> Pemasukan -> Pengeluaran -> Piutang -> Selisih) --}}
    <div class="keu-kpi-grid">
        <div class="keu-kpi contract">
            <div class="keu-kpi-label">Nilai Kontrak SPK</div>
            <div class="keu-kpi-val">Rp {{ number_format($totalNilaiKontrak, 0, ',', '.') }}</div>
            <div class="keu-kpi-sub">
                <span class="material-symbols-outlined" style="font-size:13px; color:#6366f1;">handshake</span>
                Seluruh proyek klien
            </div>
        </div>
        <div class="keu-kpi in">
            <div class="keu-kpi-label">Total Pemasukan</div>
            <div class="keu-kpi-val" style="color:#16a34a;">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</div>
            <div class="keu-kpi-sub">
                <span class="material-symbols-outlined" style="font-size:13px; color:#16a34a;">arrow_upward</span>
                Kas masuk tercairkan
            </div>
        </div>
        <div class="keu-kpi out">
            <div class="keu-kpi-label">Total Pengeluaran</div>
            <div class="keu-kpi-val" style="color:#dc2626;">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</div>
            <div class="keu-kpi-sub">
                <span class="material-symbols-outlined" style="font-size:13px; color:#dc2626;">arrow_downward</span>
                Beban operasional kas
            </div>
        </div>
        <div class="keu-kpi pip">
            <div class="keu-kpi-label">Piutang</div>
            <div class="keu-kpi-val" style="color:#d97706;">Rp {{ number_format($totalPiutang, 0, ',', '.') }}</div>
            <div class="keu-kpi-sub">
                <span class="material-symbols-outlined" style="font-size:13px; color:#d97706;">schedule</span>
                Belum lunas / tertagih
            </div>
        </div>
        <div class="keu-kpi net">
            <div class="keu-kpi-label">Selisih (Laba Bersih)</div>
            <div class="keu-kpi-val" style="color:{{ $totalSelisih >= 0 ? '#2563eb' : '#dc2626' }};">
                {{ $totalSelisih < 0 ? '-' : '' }}Rp {{ number_format(abs($totalSelisih), 0, ',', '.') }}
            </div>
            <div class="keu-kpi-sub">
                <span class="material-symbols-outlined" style="font-size:13px; color:{{ $totalSelisih >= 0 ? '#2563eb' : '#dc2626' }};">
                    {{ $totalSelisih >= 0 ? 'trending_up' : 'trending_down' }}
                </span>
                Net cash flow
            </div>
        </div>
    </div>

    {{-- Section Title 2: Ringkasan Konten & Operasional --}}
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
        <h2 style="font-size:14px; font-weight:800; color:#0f172a; text-transform:uppercase; letter-spacing:0.5px; margin:0; display:flex; align-items:center; gap:6px;">
            <span class="material-symbols-outlined" style="font-size:18px; color:#4f46e5;">dashboard_customize</span>
            Operasional Website & Leads
        </h2>
    </div>

    {{-- Operational Stats Grid --}}
    <div class="ops-grid">
        <a href="{{ route('admin.pendaftaran.index') }}" class="ops-card">
            <div class="ops-icon" style="background:#f59e0b;"><span class="material-symbols-outlined">how_to_reg</span></div>
            <div>
                <div class="ops-val">{{ $stats['pendaftaran_pending'] }}</div>
                <div class="ops-label">Pelamar Baru</div>
            </div>
        </a>
        <a href="{{ route('admin.partner-submissions.index') }}" class="ops-card">
            <div class="ops-icon" style="background:#06b6d4;"><span class="material-symbols-outlined">domain_add</span></div>
            <div>
                <div class="ops-val">{{ $stats['partner_pending'] }}</div>
                <div class="ops-label">Pengajuan Mitra</div>
            </div>
        </a>
        <a href="{{ route('admin.keuangan.program.index') }}" class="ops-card">
            <div class="ops-icon" style="background:#4f46e5;"><span class="material-symbols-outlined">handshake</span></div>
            <div>
                <div class="ops-val">{{ $stats['kontrak_aktif'] }}</div>
                <div class="ops-label">Kontrak Aktif</div>
            </div>
        </a>
        <a href="{{ route('admin.services.index') }}" class="ops-card">
            <div class="ops-icon" style="background:#2563eb;"><span class="material-symbols-outlined">school</span></div>
            <div>
                <div class="ops-val">{{ $stats['services'] }}</div>
                <div class="ops-label">Layanan Konsultan</div>
            </div>
        </a>
        <a href="{{ route('admin.projects.index') }}" class="ops-card">
            <div class="ops-icon" style="background:#7c3aed;"><span class="material-symbols-outlined">work</span></div>
            <div>
                <div class="ops-val">{{ $stats['projects'] }}</div>
                <div class="ops-label">Portofolio Web</div>
            </div>
        </a>
        <a href="{{ route('admin.blog.index') }}" class="ops-card">
            <div class="ops-icon" style="background:#d97706;"><span class="material-symbols-outlined">newspaper</span></div>
            <div>
                <div class="ops-val">{{ $stats['blogs'] }}</div>
                <div class="ops-label">Berita & Acara</div>
            </div>
        </a>
        <a href="{{ route('admin.clients.index') }}" class="ops-card">
            <div class="ops-icon" style="background:#16a34a;"><span class="material-symbols-outlined">verified</span></div>
            <div>
                <div class="ops-val">{{ $stats['clients'] }}</div>
                <div class="ops-label">Klien & Mitra</div>
            </div>
        </a>
        <a href="{{ route('admin.members.index') }}" class="ops-card">
            <div class="ops-icon" style="background:#0891b2;"><span class="material-symbols-outlined">groups</span></div>
            <div>
                <div class="ops-val">{{ $stats['members'] }}</div>
                <div class="ops-label">Tim Pakar</div>
            </div>
        </a>
    </div>

    {{-- Dual Tables: Transaksi Terkini & Pendaftaran Terkini --}}
    <div class="dual-grid">
        {{-- Panel Kiri: Transaksi Kas Terkini --}}
        <div class="panel-box">
            <div class="panel-head">
                <h3 class="panel-title">
                    <span class="material-symbols-outlined" style="font-size:18px; color:#16a34a;">receipt_long</span>
                    Transaksi Kas Terbaru
                </h3>
                <a href="{{ route('admin.keuangan.index') }}" style="font-size:12px; font-weight:600; color:#4f46e5; text-decoration:none;">
                    Lihat Semua
                </a>
            </div>
            <div class="panel-body">
                @if($recentTransaksi->isEmpty())
                    <div style="padding:24px; text-align:center; color:#94a3b8; font-size:12px;">Belum ada transaksi kas dicatat.</div>
                @else
                    <div style="overflow-x:auto;">
                        <table style="width:100%; min-width:450px; border-collapse:collapse; font-size:12px;">
                            <tbody>
                                @foreach($recentTransaksi as $rt)
                                    <tr style="border-bottom:1px solid #f1f5f9;">
                                        <td style="padding:10px 14px; font-family:monospace; color:#64748b; white-space:nowrap;">
                                            {{ $rt->kode_transaksi }}
                                        </td>
                                        <td style="padding:10px 14px;">
                                            <div style="font-weight:600; color:#0f172a;">{{ Str::limit($rt->deskripsi ?: $rt->judul, 36) }}</div>
                                            <div style="font-size:10px; color:#94a3b8;">{{ $rt->tanggal->format('d/m/Y') }}</div>
                                        </td>
                                        <td style="padding:10px 14px; text-align:right; font-weight:700; white-space:nowrap; color:{{ $rt->tipe === 'pemasukan' ? '#16a34a' : '#dc2626' }};">
                                            {{ $rt->tipe === 'pemasukan' ? '+' : '-' }}Rp {{ number_format($rt->nominal, 0, ',', '.') }}
                                        </td>
                                        <td style="padding:10px 14px; text-align:center; white-space:nowrap;">
                                            <span class="badge {{ $rt->status === 'lunas' ? 'badge-success' : 'badge-warning' }}" style="font-size:10px; padding:2px 7px;">
                                                {{ $rt->status === 'lunas' ? 'Lunas' : 'Piutang' }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        {{-- Panel Kanan: Pendaftaran Karir Terbaru --}}
        <div class="panel-box">
            <div class="panel-head">
                <h3 class="panel-title">
                    <span class="material-symbols-outlined" style="font-size:18px; color:#f59e0b;">how_to_reg</span>
                    Pelamar Karir Terbaru
                </h3>
                <a href="{{ route('admin.pendaftaran.index') }}" style="font-size:12px; font-weight:600; color:#4f46e5; text-decoration:none;">
                    Lihat Semua
                </a>
            </div>
            <div class="panel-body">
                @if($recentPendaftaran->isEmpty())
                    <div style="padding:24px; text-align:center; color:#94a3b8; font-size:12px;">Belum ada pendaftaran masuk.</div>
                @else
                    <div style="overflow-x:auto;">
                        <table style="width:100%; min-width:450px; border-collapse:collapse; font-size:12px;">
                            <tbody>
                                @foreach($recentPendaftaran as $rp)
                                    <tr style="border-bottom:1px solid #f1f5f9;">
                                        <td style="padding:10px 14px;">
                                            <div style="font-weight:600; color:#0f172a;">{{ $rp->nama }}</div>
                                            <div style="font-size:10px; color:#94a3b8;">{{ $rp->email }} • {{ $rp->no_hp ?? '-' }}</div>
                                        </td>
                                        <td style="padding:10px 14px; color:#475569; white-space:nowrap;">
                                            {{ $rp->posisi ?? 'Umum' }}
                                        </td>
                                        <td style="padding:10px 14px; text-align:center; white-space:nowrap;">
                                            <span class="badge {{ $rp->status === 'pending' ? 'badge-warning' : ($rp->status === 'approved' ? 'badge-success' : 'badge-danger') }}" style="font-size:10px; padding:2px 7px;">
                                                {{ ucfirst($rp->status) }}
                                            </span>
                                        </td>
                                        <td style="padding:10px 14px; text-align:right; white-space:nowrap;">
                                            <a href="{{ route('admin.pendaftaran.show', $rp->id) }}" class="btn-action btn-action-primary" style="font-size:11px; padding:3px 8px;">
                                                Detail
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
    </div>

    {{-- Quick Access Section --}}
    <div class="card" style="padding:18px 22px;">
        <h3 style="font-size:13px; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.5px; margin:0 0 12px;">
            Akses Cepat Pengelolaan Sistem
        </h3>
        <div style="display:flex; flex-wrap:wrap; gap:8px;">
            <a href="{{ route('admin.keuangan.create') }}" class="btn-quick-act">
                <span class="material-symbols-outlined" style="font-size:16px; color:#16a34a;">add_circle</span> Tambah Transaksi Kas
            </a>
            <button type="button" onclick="openModalTambahKontrak()" class="btn-quick-act" style="cursor:pointer; border:1px solid #c7d2fe; background:#eef2ff; color:#4338ca;">
                <span class="material-symbols-outlined" style="font-size:16px; color:#4f46e5;">post_add</span> Tambah Kontrak Klien
            </button>
            <a href="{{ route('admin.blog.create') }}" class="btn-quick-act">
                <span class="material-symbols-outlined" style="font-size:16px; color:#d97706;">edit_note</span> Tulis Berita Baru
            </a>
            <a href="{{ route('admin.projects.create') }}" class="btn-quick-act">
                <span class="material-symbols-outlined" style="font-size:16px; color:#7c3aed;">add_photo_alternate</span> Tambah Portofolio
            </a>
            <a href="{{ route('admin.services.index') }}" class="btn-quick-act">
                <span class="material-symbols-outlined" style="font-size:16px; color:#2563eb;">school</span> Program Layanan
            </a>
            <a href="{{ route('admin.pengaturan.edit') }}" class="btn-quick-act">
                <span class="material-symbols-outlined" style="font-size:16px; color:#475569;">settings</span> Pengaturan Website
            </a>
        </div>
    </div>
</div>
@endsection

