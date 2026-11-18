@extends('admin.layouts.app')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Admin')

@push('styles')
<style>
    .dash-hero {
        background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
        border-radius: 16px;
        padding: 24px 28px;
        color: #fff;
        margin-bottom: 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
        box-shadow: 0 10px 25px -5px rgba(15,23,42,0.15);
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
        background: #2563eb;
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

    /* Leads Highlight Cards */
    .leads-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }
    .leads-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 18px 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        text-decoration: none;
        transition: all .15s;
    }
    .leads-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.05);
        border-color: #cbd5e1;
    }
    .leads-icon {
        width: 48px; height: 48px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        color: #fff;
    }
    .leads-val { font-size: 24px; font-weight: 800; color: #0f172a; line-height: 1.1; }
    .leads-label { font-size: 13px; color: #475569; font-weight: 700; margin-top: 2px; }
    .leads-sub { font-size: 11px; color: #94a3b8; margin-top: 4px; }

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
                Selamat Datang, {{ Auth::user()->nama ?? 'Admin Operasional' }}!
                <span class="dash-hero-badge">Admin</span>
            </h1>
            <p class="dash-hero-sub">Pusat pengelolaan publikasi web, portofolio galeri, dan pemantauan data pendaftaran leads masuk</p>
        </div>
        <div style="display:flex; gap:8px;">
            <a href="{{ route('admin.blog.create') }}" class="btn btn-primary" style="background:#bb0027; border-color:#bb0027; font-size:12px; padding:7px 14px;">
                <span class="material-symbols-outlined" style="font-size:16px;">edit_note</span> Tulis Berita
            </a>
            <a href="{{ route('admin.projects.create') }}" class="btn btn-secondary" style="font-size:12px; padding:7px 14px;">
                <span class="material-symbols-outlined" style="font-size:16px;">add_photo_alternate</span> Tambah Portofolio
            </a>
        </div>
    </div>

    {{-- Highlight Leads Cards --}}
    <div class="leads-grid">
        <a href="{{ route('admin.pendaftaran.index') }}" class="leads-card">
            <div class="leads-icon" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                <span class="material-symbols-outlined" style="font-size:24px;">how_to_reg</span>
            </div>
            <div>
                <div class="leads-val">{{ $stats['pendaftaran_pending'] }} <span style="font-size:13px; font-weight:400; color:#94a3b8;">/ {{ $stats['pendaftaran_total'] }}</span></div>
                <div class="leads-label">Pendaftaran Karir Baru</div>
                <div class="leads-sub">Menunggu review berkas pelamar</div>
            </div>
        </a>
        <a href="{{ route('admin.partner-submissions.index') }}" class="leads-card">
            <div class="leads-icon" style="background: linear-gradient(135deg, #06b6d4, #0891b2);">
                <span class="material-symbols-outlined" style="font-size:24px;">domain_add</span>
            </div>
            <div>
                <div class="leads-val">{{ $stats['partner_pending'] }} <span style="font-size:13px; font-weight:400; color:#94a3b8;">/ {{ $stats['partner_total'] }}</span></div>
                <div class="leads-label">Pengajuan Mitra Baru</div>
                <div class="leads-sub">Calon rekanan & instansi partner</div>
            </div>
        </a>
    </div>

    {{-- Section Title: Ringkasan Konten Website --}}
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
        <h2 style="font-size:14px; font-weight:800; color:#0f172a; text-transform:uppercase; letter-spacing:0.5px; margin:0; display:flex; align-items:center; gap:6px;">
            <span class="material-symbols-outlined" style="font-size:18px; color:#2563eb;">web</span>
            Konten & Modul Publikasi Web
        </h2>
    </div>

    {{-- Grid Konten Web --}}
    <div class="ops-grid">
        <a href="{{ route('admin.services.index') }}" class="ops-card">
            <div class="ops-icon" style="background:#2563eb;"><span class="material-symbols-outlined">school</span></div>
            <div>
                <div class="ops-val">{{ $stats['services'] }}</div>
                <div class="ops-label">Program Layanan</div>
            </div>
        </a>
        <a href="{{ route('admin.projects.index') }}" class="ops-card">
            <div class="ops-icon" style="background:#7c3aed;"><span class="material-symbols-outlined">work</span></div>
            <div>
                <div class="ops-val">{{ $stats['projects'] }}</div>
                <div class="ops-label">Portofolio Proyek</div>
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
                <div class="ops-label">Tim Pakar (Expert)</div>
            </div>
        </a>
        <a href="{{ route('admin.reviews.index') }}" class="ops-card">
            <div class="ops-icon" style="background:#dc2626;"><span class="material-symbols-outlined">star</span></div>
            <div>
                <div class="ops-val">{{ $stats['reviews'] }}</div>
                <div class="ops-label">Testimoni Klien</div>
            </div>
        </a>
        <a href="{{ route('admin.faqs.index') }}" class="ops-card">
            <div class="ops-icon" style="background:#4f46e5;"><span class="material-symbols-outlined">help</span></div>
            <div>
                <div class="ops-val">{{ $stats['faqs'] }}</div>
                <div class="ops-label">Tanya Jawab FAQ</div>
            </div>
        </a>
        <a href="{{ route('admin.gallery.index') }}" class="ops-card">
            <div class="ops-icon" style="background:#be185d;"><span class="material-symbols-outlined">photo_library</span></div>
            <div>
                <div class="ops-val">{{ $stats['albums'] }}</div>
                <div class="ops-label">Album Galeri</div>
            </div>
        </a>
    </div>

    {{-- Dual Tables: Pelamar Karir Terbaru & Pengajuan Mitra Terbaru --}}
    <div class="dual-grid">
        {{-- Panel Kiri: Pendaftaran Karir Terbaru --}}
        <div class="panel-box">
            <div class="panel-head">
                <h3 class="panel-title">
                    <span class="material-symbols-outlined" style="font-size:18px; color:#f59e0b;">how_to_reg</span>
                    Pelamar Karir Terbaru
                </h3>
                <a href="{{ route('admin.pendaftaran.index') }}" style="font-size:12px; font-weight:600; color:#4f46e5; text-decoration:none;">
                    Buka Inbox
                </a>
            </div>
            <div class="panel-body">
                @if($recentPendaftaran->isEmpty())
                    <div style="padding:24px; text-align:center; color:#94a3b8; font-size:12px;">Belum ada pendaftaran karir masuk.</div>
                @else
                    <div style="overflow-x:auto;">
                        <table style="width:100%; min-width:460px; border-collapse:collapse; font-size:12px;">
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

        {{-- Panel Kanan: Pengajuan Mitra Terbaru --}}
        <div class="panel-box">
            <div class="panel-head">
                <h3 class="panel-title">
                    <span class="material-symbols-outlined" style="font-size:18px; color:#06b6d4;">domain_add</span>
                    Pengajuan Mitra Terbaru
                </h3>
                <a href="{{ route('admin.partner-submissions.index') }}" style="font-size:12px; font-weight:600; color:#4f46e5; text-decoration:none;">
                    Buka Mitra
                </a>
            </div>
            <div class="panel-body">
                @if($recentPartners->isEmpty())
                    <div style="padding:24px; text-align:center; color:#94a3b8; font-size:12px;">Belum ada pengajuan mitra masuk.</div>
                @else
                    <div style="overflow-x:auto;">
                        <table style="width:100%; min-width:460px; border-collapse:collapse; font-size:12px;">
                            <tbody>
                                @foreach($recentPartners as $ps)
                                    <tr style="border-bottom:1px solid #f1f5f9;">
                                        <td style="padding:10px 14px;">
                                            <div style="font-weight:600; color:#0f172a;">{{ $ps->nama_instansi ?? $ps->nama }}</div>
                                            <div style="font-size:10px; color:#94a3b8;">{{ $ps->email }} • PIC: {{ $ps->pic ?? '-' }}</div>
                                        </td>
                                        <td style="padding:10px 14px; color:#475569;">
                                            {{ Str::limit($ps->bidang_kerjasama ?? $ps->pesan, 28) }}
                                        </td>
                                        <td style="padding:10px 14px; text-align:center; white-space:nowrap;">
                                            <span class="badge {{ $ps->status === 'pending' ? 'badge-warning' : ($ps->status === 'approved' ? 'badge-success' : 'badge-danger') }}" style="font-size:10px; padding:2px 7px;">
                                                {{ ucfirst($ps->status) }}
                                            </span>
                                        </td>
                                        <td style="padding:10px 14px; text-align:right; white-space:nowrap;">
                                            <a href="{{ route('admin.partner-submissions.show', $ps->id) }}" class="btn-action btn-action-primary" style="font-size:11px; padding:3px 8px;">
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

    {{-- Akses Cepat Admin --}}
    <div class="card" style="padding:18px 22px;">
        <h3 style="font-size:13px; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.5px; margin:0 0 12px;">
            Akses Cepat Pengelolaan Konten Website
        </h3>
        <div style="display:flex; flex-wrap:wrap; gap:8px;">
            <a href="{{ route('admin.blog.create') }}" class="btn-quick-act">
                <span class="material-symbols-outlined" style="font-size:16px; color:#d97706;">edit_note</span> Tulis Berita / Artikel Baru
            </a>
            <a href="{{ route('admin.projects.create') }}" class="btn-quick-act">
                <span class="material-symbols-outlined" style="font-size:16px; color:#7c3aed;">add_photo_alternate</span> Tambah Portofolio Galeri
            </a>
            <a href="{{ route('admin.services.create') }}" class="btn-quick-act">
                <span class="material-symbols-outlined" style="font-size:16px; color:#2563eb;">add_box</span> Tambah Program Layanan
            </a>
            <a href="{{ route('admin.members.create') }}" class="btn-quick-act">
                <span class="material-symbols-outlined" style="font-size:16px; color:#0891b2;">person_add</span> Tambah Tenaga Ahli
            </a>
            <a href="{{ route('admin.clients.create') }}" class="btn-quick-act">
                <span class="material-symbols-outlined" style="font-size:16px; color:#16a34a;">verified</span> Tambah Logo Klien
            </a>
            <a href="{{ route('admin.pengaturan.edit') }}" class="btn-quick-act">
                <span class="material-symbols-outlined" style="font-size:16px; color:#475569;">settings</span> Pengaturan Website
            </a>
        </div>
    </div>
</div>
@endsection

