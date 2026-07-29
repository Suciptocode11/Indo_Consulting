@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background: #2563eb;">
            <span class="material-symbols-outlined">school</span>
        </div>
        <div class="stat-value">{{ $stats['services'] }}</div>
        <div class="stat-label">Program/Layanan</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: #7c3aed;">
            <span class="material-symbols-outlined">work</span>
        </div>
        <div class="stat-value">{{ $stats['projects'] }}</div>
        <div class="stat-label">Portfolio/Proyek</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: #059669;">
            <span class="material-symbols-outlined">handshake</span>
        </div>
        <div class="stat-value">{{ $stats['clients'] }}</div>
        <div class="stat-label">Mitra/Klien</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: #d97706;">
            <span class="material-symbols-outlined">newspaper</span>
        </div>
        <div class="stat-value">{{ $stats['blogs'] }}</div>
        <div class="stat-label">Berita/Acara</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: #dc2626;">
            <span class="material-symbols-outlined">star</span>
        </div>
        <div class="stat-value">{{ $stats['reviews'] }}</div>
        <div class="stat-label">Testimoni</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: #0891b2;">
            <span class="material-symbols-outlined">groups</span>
        </div>
        <div class="stat-value">{{ $stats['members'] }}</div>
        <div class="stat-label">Expert/Team</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: #4f46e5;">
            <span class="material-symbols-outlined">help</span>
        </div>
        <div class="stat-value">{{ $stats['faqs'] }}</div>
        <div class="stat-label">FAQ</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: #be185d;">
            <span class="material-symbols-outlined">photo_library</span>
        </div>
        <div class="stat-value">{{ $stats['albums'] }}</div>
        <div class="stat-label">Gallery Album</div>
    </div>
</div>

<div class="card">
    <h3 style="font-size: 16px; font-weight: 600; margin-bottom: 16px; color: #020220;">Akses Cepat</h3>
    <div style="display: flex; flex-wrap: wrap; gap: 10px;">
        <a href="{{ route('admin.pengaturan.edit') }}" class="btn btn-secondary">
            <span class="material-symbols-outlined">settings</span> Pengaturan
        </a>
        <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">
            <span class="material-symbols-outlined">school</span> Program
        </a>
        <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary">
            <span class="material-symbols-outlined">work</span> Portfolio
        </a>
        <a href="{{ route('admin.blog.index') }}" class="btn btn-secondary">
            <span class="material-symbols-outlined">newspaper</span> Berita
        </a>
        <a href="{{ route('admin.members.index') }}" class="btn btn-secondary">
            <span class="material-symbols-outlined">groups</span> Expert
        </a>
        <a href="{{ route('admin.social-media.index') }}" class="btn btn-secondary">
            <span class="material-symbols-outlined">share</span> Sosial Media
        </a>
    </div>
</div>
@endsection
