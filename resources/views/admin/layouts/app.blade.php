<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - Indo Consulting</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('styles')
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Outfit', sans-serif;
            background: #f8fafc;
            color: #1e293b;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 260px;
            height: 100vh;
            background: #040614;
            color: white;
            overflow-y: auto;
            z-index: 40;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            box-shadow: 2px 0 16px rgba(0, 0, 0, 0.15);
        }
        .sidebar::-webkit-scrollbar {
            width: 5px;
        }
        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }
        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.12);
            border-radius: 4px;
        }
        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.24);
        }
        .sidebar-header {
            padding: 18px 18px 14px;
            border-bottom: 1px solid rgba(255,255,255,0.07);
        }
        .sidebar-brand-block {
            display: flex;
            flex-direction: column;
            gap: 12px;
            text-decoration: none;
            align-items: center;
        }
        .sidebar-logo-img {
            max-height: 50px;
            width: auto;
            max-width: 100%;
            object-fit: contain;
            display: block;
            filter: brightness(0) invert(0.88);
            transition: all 0.2s ease;
        }
        .sidebar-brand-block:hover .sidebar-logo-img {
            filter: brightness(0) invert(1);
            transform: scale(1.02);
        }
        .sidebar-header-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            padding: 0 2px;
        }
        .sidebar-header-meta .badge-role {
            font-size: 10px;
            font-weight: 700;
            color: #fb7185;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .sidebar-header-meta .badge-role::before {
            content: '';
            display: inline-block;
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #ef4444;
            box-shadow: 0 0 6px #ef4444;
        }
        .sidebar-header-meta .portal-tag {
            font-size: 10px;
            color: rgba(255,255,255,0.4);
            font-weight: 500;
        }
        .sidebar-nav {
            padding: 12px 0 32px;
            flex: 1;
        }
        .nav-section {
            padding: 14px 18px 5px;
            font-size: 10px;
            font-weight: 700;
            color: rgba(255,255,255,0.35);
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }
        .nav-section:first-child {
            padding-top: 2px;
        }
        .nav-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            padding: 8px 14px;
            margin: 2px 10px;
            border-radius: 8px;
            color: rgba(255,255,255,0.68);
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.15s ease-in-out;
        }
        .nav-item-content {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 0;
        }
        .nav-item:hover {
            background: rgba(255,255,255,0.07);
            color: #ffffff;
            transform: translateX(2px);
        }
        .nav-item.active {
            background: #bb0027;
            color: #ffffff;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(187, 0, 39, 0.4);
        }
        .nav-item .material-symbols-outlined {
            font-size: 19px;
            opacity: 0.85;
        }
        .nav-item:hover .material-symbols-outlined,
        .nav-item.active .material-symbols-outlined {
            opacity: 1;
        }
        .nav-badge-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 20px;
            height: 19px;
            padding: 0 6px;
            border-radius: 10px;
            font-size: 11px;
            font-weight: 700;
            background: #ef4444;
            color: #ffffff;
            box-shadow: 0 2px 6px rgba(239, 68, 68, 0.4);
        }
        .nav-item.active .nav-badge-pill {
            background: rgba(255,255,255,0.25);
            box-shadow: none;
        }

        /* Main Content */
        .main-content {
            margin-left: 260px;
            min-height: 100vh;
        }

        /* Topbar */
        .topbar {
            position: sticky;
            top: 0;
            background: white;
            border-bottom: 1px solid #e2e8f0;
            padding: 14px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 30;
        }
        .topbar-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .topbar-left h1 {
            font-size: 18px;
            font-weight: 600;
            color: #020220;
        }
        .topbar-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .topbar-user {
            font-size: 13px;
            color: #64748b;
        }
        .topbar-user strong {
            color: #020220;
        }
        .btn-logout {
            padding: 6px 14px;
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-family: 'Outfit', sans-serif;
            font-size: 12px;
            font-weight: 500;
            color: #64748b;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.15s;
        }
        .btn-logout:hover {
            background: #fee2e2;
            border-color: #fca5a5;
            color: #dc2626;
        }

        /* Content Area */
        .content {
            padding: 28px 32px;
        }

        /* Cards */
        .card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 24px;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 28px;
        }
        .stat-card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 20px;
        }
        .stat-card .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 12px;
        }
        .stat-card .stat-icon .material-symbols-outlined {
            font-size: 22px;
            color: white;
        }
        .stat-card .stat-value {
            font-size: 28px;
            font-weight: 700;
            color: #020220;
        }
        .stat-card .stat-label {
            font-size: 13px;
            color: #64748b;
            margin-top: 2px;
        }

        /* Table */
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }
        .data-table th {
            text-align: left;
            padding: 10px 14px;
            font-size: 12px;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            border-bottom: 1px solid #e2e8f0;
            background: #f8fafc;
        }
        .data-table td {
            padding: 12px 14px;
            font-size: 14px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }
        .data-table tr:hover td {
            background: #f8fafc;
        }

        /* Badges */
        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .badge-success {
            background: #dcfce7;
            color: #16a34a;
        }
        .badge-danger {
            background: #fee2e2;
            color: #dc2626;
        }
        .badge-warning {
            background: #fef3c7;
            color: #d97706;
        }
        .badge-info {
            background: #dbeafe;
            color: #2563eb;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 8px;
            font-family: 'Outfit', sans-serif;
            font-size: 13px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.15s;
        }
        .btn-primary {
            background: #020220;
            color: white;
        }
        .btn-primary:hover { opacity: 0.9; }
        .btn-secondary {
            background: #f1f5f9;
            color: #475569;
            border: 1px solid #e2e8f0;
        }
        .btn-secondary:hover { background: #e2e8f0; }
        .btn-danger {
            background: #fee2e2;
            color: #dc2626;
        }
        .btn-danger:hover { background: #fecaca; }
        .btn-success {
            background: #dcfce7;
            color: #16a34a;
        }
        .btn-success:hover { background: #bbf7d0; }
        .btn-sm {
            padding: 5px 10px;
            font-size: 12px;
        }
        .btn .material-symbols-outlined {
            font-size: 16px;
        }

        /* Forms */
        .form-group {
            margin-bottom: 18px;
        }
        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 6px;
        }
        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="password"],
        .form-group input[type="url"],
        .form-group input[type="number"],
        .form-group input[type="date"],
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-family: 'Outfit', sans-serif;
            font-size: 14px;
            color: #020220;
            background: white;
            outline: none;
            transition: border-color 0.15s;
        }
        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            border-color: #020220;
            box-shadow: 0 0 0 3px rgba(2,2,32,0.06);
        }
        .form-group textarea {
            min-height: 100px;
            resize: vertical;
        }
        .form-group .help {
            font-size: 12px;
            color: #94a3b8;
            margin-top: 4px;
        }
        .form-group .error-msg {
            font-size: 12px;
            color: #dc2626;
            margin-top: 4px;
        }
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        /* Flash Messages */
        .flash-success {
            background: #dcfce7;
            border: 1px solid #bbf7d0;
            color: #166534;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .flash-error {
            background: #fee2e2;
            border: 1px solid #fecaca;
            color: #991b1b;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        /* Quick Modal */
        .quick-modal-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(2px);
            z-index: 999;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }
        .quick-modal-card {
            background: white;
            border-radius: 12px;
            width: 100%;
            max-width: 440px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            padding: 22px;
            animation: modalPop 0.2s cubic-bezier(0.32, 0.72, 0, 1);
        }
        @keyframes modalPop {
            from { transform: scale(0.95); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
        .quick-modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
            padding-bottom: 12px;
            border-bottom: 1px solid #f1f5f9;
        }
        .btn-quick-add {
            font-size: 12px;
            color: #bb0027;
            background: none;
            border: none;
            cursor: pointer;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 2px 6px;
            border-radius: 4px;
            transition: all 0.15s;
        }
        .btn-quick-add:hover {
            background: rgba(187, 0, 39, 0.08);
        }

        /* Mobile Sidebar Toggle */
        .sidebar-toggle {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px;
        }
        .sidebar-toggle .material-symbols-outlined {
            font-size: 24px;
            color: #475569;
        }
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.4);
            z-index: 35;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.open {
                transform: translateX(0);
            }
            .sidebar-overlay.open {
                display: block;
            }
            .main-content {
                margin-left: 0;
            }
            .sidebar-toggle {
                display: block;
            }
            .topbar {
                padding: 14px 16px;
            }
            .content {
                padding: 20px 16px;
            }
            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body x-data="{ sidebarOpen: false }">

    <!-- Sidebar Overlay (Mobile) -->
    <div class="sidebar-overlay" :class="{ open: sidebarOpen }" @click="sidebarOpen = false"></div>

    <!-- Sidebar -->
    <aside class="sidebar" :class="{ open: sidebarOpen }">
        <div class="sidebar-header">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-brand-block" title="Kembali ke Dashboard">
                @if(!empty($pengaturan?->logo))
                    <img src="{{ asset('storage/' . $pengaturan->logo) }}" alt="{{ $pengaturan->company ?? 'Indo Consulting' }}" class="sidebar-logo-img">
                @else
                    <img src="{{ asset('images/logo.png') }}" alt="Indo Consulting" class="sidebar-logo-img">
                @endif
                <div class="sidebar-header-meta">
                    <span class="badge-role">Back Office</span>
                    <span class="portal-tag">Admin Panel</span>
                </div>
            </a>
        </div>
        <nav class="sidebar-nav">
            <!-- 1. Navigasi Utama -->
            <div class="nav-section">Utama</div>
            <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <div class="nav-item-content">
                    <span class="material-symbols-outlined">dashboard</span>
                    <span>Dashboard</span>
                </div>
            </a>

            <!-- 2. Data Masuk / Inbox -->
            <div class="nav-section">Data Masuk & Leads</div>
            <a href="{{ route('admin.pendaftaran.index') }}" class="nav-item {{ request()->routeIs('admin.pendaftaran.*') ? 'active' : '' }}">
                <div class="nav-item-content">
                    <span class="material-symbols-outlined">how_to_reg</span>
                    <span>Pendaftaran Karir</span>
                </div>
                @if(!empty($pendingPendaftaranCount) && $pendingPendaftaranCount > 0)
                    <span class="nav-badge-pill" title="{{ $pendingPendaftaranCount }} Pendaftaran Baru">{{ $pendingPendaftaranCount }}</span>
                @endif
            </a>
            <a href="{{ route('admin.partner-submissions.index') }}" class="nav-item {{ request()->routeIs('admin.partner-submissions.*') ? 'active' : '' }}">
                <div class="nav-item-content">
                    <span class="material-symbols-outlined">domain_add</span>
                    <span>Pengajuan Mitra</span>
                </div>
                @if(!empty($pendingPartnerCount) && $pendingPartnerCount > 0)
                    <span class="nav-badge-pill" title="{{ $pendingPartnerCount }} Pengajuan Mitra Baru">{{ $pendingPartnerCount }}</span>
                @endif
            </a>

            <!-- 3. Layanan & Portofolio -->
            <div class="nav-section">Layanan & Portofolio</div>
            <a href="{{ route('admin.services.index') }}" class="nav-item {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                <div class="nav-item-content">
                    <span class="material-symbols-outlined">school</span>
                    <span>Program & Layanan</span>
                </div>
            </a>
            <a href="{{ route('admin.projects.index') }}" class="nav-item {{ request()->routeIs('admin.projects.*', 'admin.kategori-project.*') ? 'active' : '' }}">
                <div class="nav-item-content">
                    <span class="material-symbols-outlined">work</span>
                    <span>Portofolio Proyek</span>
                </div>
            </a>
            <a href="{{ route('admin.clients.index') }}" class="nav-item {{ request()->routeIs('admin.clients.*') ? 'active' : '' }}">
                <div class="nav-item-content">
                    <span class="material-symbols-outlined">verified</span>
                    <span>Daftar Klien & Mitra</span>
                </div>
            </a>

            <!-- 4. Profil Perusahaan -->
            <div class="nav-section">Profil Perusahaan</div>
            <a href="{{ route('admin.members.index') }}" class="nav-item {{ request()->routeIs('admin.members.*') ? 'active' : '' }}">
                <div class="nav-item-content">
                    <span class="material-symbols-outlined">groups</span>
                    <span>Tim Pakar (Our Expert)</span>
                </div>
            </a>
            <a href="{{ route('admin.visi-misi.index') }}" class="nav-item {{ request()->routeIs('admin.visi-misi.*') ? 'active' : '' }}">
                <div class="nav-item-content">
                    <span class="material-symbols-outlined">flag</span>
                    <span>Visi & Misi</span>
                </div>
            </a>
            <a href="{{ route('admin.keunggulan.index') }}" class="nav-item {{ request()->routeIs('admin.keunggulan.*') ? 'active' : '' }}">
                <div class="nav-item-content">
                    <span class="material-symbols-outlined">emoji_events</span>
                    <span>Keunggulan (Why Us)</span>
                </div>
            </a>
            <a href="{{ route('admin.page-contents.index') }}" class="nav-item {{ request()->routeIs('admin.page-contents.*') ? 'active' : '' }}">
                <div class="nav-item-content">
                    <span class="material-symbols-outlined">web</span>
                    <span>Konten Halaman</span>
                </div>
            </a>

            <!-- 5. Publikasi & Media -->
            <div class="nav-section">Publikasi & Media</div>
            <a href="{{ route('admin.blog.index') }}" class="nav-item {{ request()->routeIs('admin.blog.*') ? 'active' : '' }}">
                <div class="nav-item-content">
                    <span class="material-symbols-outlined">newspaper</span>
                    <span>Berita & Acara</span>
                </div>
            </a>
            <a href="{{ route('admin.gallery.index') }}" class="nav-item {{ request()->routeIs('admin.gallery.*') ? 'active' : '' }}">
                <div class="nav-item-content">
                    <span class="material-symbols-outlined">photo_library</span>
                    <span>Galeri Media</span>
                </div>
            </a>
            <a href="{{ route('admin.reviews.index') }}" class="nav-item {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
                <div class="nav-item-content">
                    <span class="material-symbols-outlined">star</span>
                    <span>Testimoni Klien</span>
                </div>
            </a>
            <a href="{{ route('admin.faqs.index') }}" class="nav-item {{ request()->routeIs('admin.faqs.*') ? 'active' : '' }}">
                <div class="nav-item-content">
                    <span class="material-symbols-outlined">quiz</span>
                    <span>Tanya Jawab (FAQ)</span>
                </div>
            </a>

            <!-- 6. Pengaturan & Sistem -->
            <div class="nav-section">Pengaturan & Sistem</div>
            <a href="{{ route('admin.pengaturan.edit') }}" class="nav-item {{ request()->routeIs('admin.pengaturan.*') ? 'active' : '' }}">
                <div class="nav-item-content">
                    <span class="material-symbols-outlined">settings</span>
                    <span>Pengaturan Website</span>
                </div>
            </a>
            <a href="{{ route('admin.social-media.index') }}" class="nav-item {{ request()->routeIs('admin.social-media.*') ? 'active' : '' }}">
                <div class="nav-item-content">
                    <span class="material-symbols-outlined">share</span>
                    <span>Media Sosial</span>
                </div>
            </a>
            <a href="{{ route('admin.logout') }}" class="nav-item" style="margin-top: 10px; color: #fca5a5;" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <div class="nav-item-content">
                    <span class="material-symbols-outlined" style="color: #f87171;">logout</span>
                    <span style="color: #fca5a5;">Keluar (Logout)</span>
                </div>
            </a>
        </nav>
        <form id="logout-form" method="POST" action="{{ route('admin.logout') }}" style="display:none;">
            @csrf
        </form>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Topbar -->
        <header class="topbar">
            <div class="topbar-left">
                <button class="sidebar-toggle" @click="sidebarOpen = !sidebarOpen">
                    <span class="material-symbols-outlined">menu</span>
                </button>
                <h1>@yield('page-title', 'Dashboard')</h1>
            </div>
            <div class="topbar-right">
                <a href="{{ route('home') }}" target="_blank" class="btn btn-secondary btn-sm" style="display: inline-flex; align-items: center; gap: 6px;">
                    <span class="material-symbols-outlined" style="font-size: 16px;">open_in_new</span>
                    <span>Lihat Website</span>
                </a>
                <span class="topbar-user">Halo, <strong>{{ Auth::user()->nama ?? 'Admin' }}</strong></span>
                <button type="button" class="btn-logout" onclick="document.getElementById('logout-form').submit();" title="Keluar">
                    Keluar
                </button>
            </div>
        </header>

        <!-- Content -->
        <div class="content">
            @if(session('success'))
                <div class="flash-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="flash-error">{{ session('error') }}</div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- Universal Quick Add Category Modal -->
    <div id="quickCategoryModal" class="quick-modal-backdrop" style="display: none;">
        <div class="quick-modal-card">
            <div class="quick-modal-header">
                <h3 id="quickCategoryTitle" style="font-size: 16px; font-weight: 600; color: #0f172a; margin: 0;">Tambah Kategori Baru</h3>
                <button type="button" onclick="closeQuickCategoryModal()" style="background: none; border: none; font-size: 20px; color: #94a3b8; cursor: pointer; line-height: 1;">&times;</button>
            </div>
            <form id="quickCategoryForm" onsubmit="submitQuickCategory(event)">
                <div class="form-group" style="margin-bottom: 16px;">
                    <label id="quickCategoryLabel" style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">Nama Kategori *</label>
                    <input type="text" id="quickCategoryInput" placeholder="Masukkan nama..." required style="width: 100%; padding: 10px 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-family: 'Outfit', sans-serif; font-size: 14px;">
                    <div id="quickCategoryError" style="color: #dc2626; font-size: 12px; margin-top: 4px; display: none;"></div>
                </div>
                <div style="display: flex; justify-content: flex-end; gap: 8px; margin-top: 20px;">
                    <button type="button" class="btn btn-secondary" onclick="closeQuickCategoryModal()">Batal</button>
                    <button type="submit" id="quickCategorySubmitBtn" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- jQuery for Summernote --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Init Summernote on all .summernote elements
            document.querySelectorAll('.summernote').forEach(function(el) {
                $(el).summernote({
                    height: 200,
                    minHeight: 100,
                    maxHeight: 400,
                    placeholder: 'Tulis konten di sini...',
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'italic', 'underline', 'strikethrough']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture']],
                        ['view', ['fullscreen', 'codeview']]
                    ],
                    callbacks: {
                        onImageUpload: function(files) {
                            // Upload gambar via AJAX
                            var editor = $(this);
                            var file = files[0];
                            var formData = new FormData();
                            formData.append('file', file);
                            formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

                            fetch('/admin/upload-image', {
                                method: 'POST',
                                body: formData
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.url) {
                                    editor.summernote('insertImage', data.url);
                                }
                            })
                            .catch(err => console.error('Upload error:', err));
                        }
                    }
                });
            });
        });

        /* ===== Universal Quick Add Category Modal Logic ===== */
        let activeQuickType = null;
        let activeTargetSelect = null;

        function openQuickCategoryModal(type, targetSelectName = 'id_category') {
            activeQuickType = type;
            activeTargetSelect = document.querySelector(`select[name="${targetSelectName}"]`);
            
            const titleEl = document.getElementById('quickCategoryTitle');
            const labelEl = document.getElementById('quickCategoryLabel');
            const inputEl = document.getElementById('quickCategoryInput');
            const errorEl = document.getElementById('quickCategoryError');
            
            inputEl.value = '';
            errorEl.style.display = 'none';
            errorEl.textContent = '';
            
            if (type === 'project') {
                titleEl.textContent = 'Tambah Kategori Proyek Baru';
                labelEl.textContent = 'Nama Kategori Proyek *';
                inputEl.placeholder = 'Contoh: Konsultasi Keuangan & Pajak';
            } else if (type === 'blog') {
                titleEl.textContent = 'Tambah Kategori Berita Baru';
                labelEl.textContent = 'Nama Kategori Berita *';
                inputEl.placeholder = 'Contoh: Press Release / Workshop';
            } else if (type === 'sector') {
                titleEl.textContent = 'Tambah Sektor Klien Baru';
                labelEl.textContent = 'Nama Sektor / Industri *';
                inputEl.placeholder = 'Contoh: Manufaktur / Otomotif';
            }
            
            document.getElementById('quickCategoryModal').style.display = 'flex';
            setTimeout(() => inputEl.focus(), 50);
        }

        function closeQuickCategoryModal() {
            document.getElementById('quickCategoryModal').style.display = 'none';
        }

        // Close on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeQuickCategoryModal();
        });

        async function submitQuickCategory(event) {
            event.preventDefault();
            const inputEl = document.getElementById('quickCategoryInput');
            const errorEl = document.getElementById('quickCategoryError');
            const submitBtn = document.getElementById('quickCategorySubmitBtn');
            const val = inputEl.value.trim();
            
            if (!val) return;

            // Handle client sector (client-side select option)
            if (activeQuickType === 'sector') {
                if (activeTargetSelect) {
                    const opt = document.createElement('option');
                    opt.value = val;
                    opt.textContent = val;
                    opt.selected = true;
                    activeTargetSelect.appendChild(opt);
                }
                closeQuickCategoryModal();
                return;
            }

            // Handle server-side categories (Project & Blog)
            let endpoint = '';
            if (activeQuickType === 'project') {
                endpoint = "{{ route('admin.kategori-project.quick-store') }}";
            } else if (activeQuickType === 'blog') {
                endpoint = "{{ route('admin.kategori-blog.quick-store') }}";
            }

            submitBtn.disabled = true;
            submitBtn.textContent = 'Menyimpan...';
            errorEl.style.display = 'none';

            try {
                const response = await fetch(endpoint, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ title: val })
                });

                const res = await response.json();

                if (response.ok && res.success) {
                    if (activeTargetSelect) {
                        const opt = document.createElement('option');
                        opt.value = res.data.id;
                        opt.textContent = res.data.title;
                        opt.selected = true;
                        activeTargetSelect.appendChild(opt);
                    }
                    closeQuickCategoryModal();
                } else {
                    errorEl.textContent = res.message || (res.errors ? Object.values(res.errors)[0][0] : 'Gagal menyimpan kategori');
                    errorEl.style.display = 'block';
                }
            } catch (err) {
                console.error(err);
                errorEl.textContent = 'Terjadi kesalahan sistem. Coba lagi.';
                errorEl.style.display = 'block';
            } finally {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Simpan';
            }
        }
    </script>

    @yield('scripts')
    @stack('scripts')
</body>
</html>
