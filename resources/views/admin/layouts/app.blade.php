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
            background: #020220;
            color: white;
            overflow-y: auto;
            z-index: 40;
            transition: transform 0.3s;
        }
        .sidebar-header {
            padding: 20px 20px 16px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }
        .sidebar-header h2 {
            font-size: 16px;
            font-weight: 600;
        }
        .sidebar-header span {
            font-size: 12px;
            color: rgba(255,255,255,0.5);
        }
        .sidebar-nav {
            padding: 12px 0;
        }
        .nav-section {
            padding: 8px 20px 4px;
            font-size: 11px;
            font-weight: 600;
            color: rgba(255,255,255,0.35);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 20px;
            color: rgba(255,255,255,0.65);
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.15s;
            border-left: 3px solid transparent;
        }
        .nav-item:hover {
            background: rgba(255,255,255,0.06);
            color: white;
        }
        .nav-item.active {
            background: rgba(255,255,255,0.1);
            color: white;
            border-left-color: #bb0027;
        }
        .nav-item .material-symbols-outlined {
            font-size: 20px;
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
            <h2>Indo Consulting</h2>
            <span>Admin Panel</span>
        </div>
        <nav class="sidebar-nav">
            <div class="nav-section">Menu Utama</div>
            <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <span class="material-symbols-outlined">dashboard</span> Dashboard
            </a>

            <div class="nav-section">Pengaturan</div>
            <a href="{{ route('admin.pengaturan.edit') }}" class="nav-item {{ request()->routeIs('admin.pengaturan.*') ? 'active' : '' }}">
                <span class="material-symbols-outlined">settings</span> Pengaturan
            </a>
            <a href="{{ route('admin.social-media.index') }}" class="nav-item {{ request()->routeIs('admin.social-media.*') ? 'active' : '' }}">
                <span class="material-symbols-outlined">share</span> Sosial Media
            </a>
            <a href="{{ route('admin.page-contents.index') }}" class="nav-item {{ request()->routeIs('admin.page-contents.*') ? 'active' : '' }}">
                <span class="material-symbols-outlined">edit_note</span> Konten Halaman
            </a>

            <div class="nav-section">Konten Utama</div>
            <a href="{{ route('admin.services.index') }}" class="nav-item {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                <span class="material-symbols-outlined">school</span> Program/Layanan
            </a>
            <a href="{{ route('admin.projects.index') }}" class="nav-item {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}">
                <span class="material-symbols-outlined">work</span> Portfolio/Proyek
            </a>
            <a href="{{ route('admin.clients.index') }}" class="nav-item {{ request()->routeIs('admin.clients.*') ? 'active' : '' }}">
                <span class="material-symbols-outlined">handshake</span> Mitra/Klien
            </a>

            <div class="nav-section">Konten Pendukung</div>
            <a href="{{ route('admin.blog.index') }}" class="nav-item {{ request()->routeIs('admin.blog.*') ? 'active' : '' }}">
                <span class="material-symbols-outlined">newspaper</span> Berita/Acara
            </a>
            <a href="{{ route('admin.reviews.index') }}" class="nav-item {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
                <span class="material-symbols-outlined">star</span> Testimoni
            </a>
            <a href="{{ route('admin.faqs.index') }}" class="nav-item {{ request()->routeIs('admin.faqs.*') ? 'active' : '' }}">
                <span class="material-symbols-outlined">help</span> FAQ
            </a>

            <div class="nav-section">Tim & Lainnya</div>
            <a href="{{ route('admin.members.index') }}" class="nav-item {{ request()->routeIs('admin.members.*') ? 'active' : '' }}">
                <span class="material-symbols-outlined">groups</span> Expert/Team
            </a>
            <a href="{{ route('admin.keunggulan.index') }}" class="nav-item {{ request()->routeIs('admin.keunggulan.*') ? 'active' : '' }}">
                <span class="material-symbols-outlined">emoji_events</span> Keunggulan
            </a>
            <a href="{{ route('admin.visi-misi.index') }}" class="nav-item {{ request()->routeIs('admin.visi-misi.*') ? 'active' : '' }}">
                <span class="material-symbols-outlined">visibility</span> Visi & Misi
            </a>

            <a href="{{ route('admin.gallery.index') }}" class="nav-item {{ request()->routeIs('admin.gallery.*') ? 'active' : '' }}">
                <span class="material-symbols-outlined">photo_library</span> Gallery
            </a>
            <a href="{{ route('admin.pendaftaran.index') }}" class="nav-item {{ request()->routeIs('admin.pendaftaran.*') ? 'active' : '' }}">
                <span class="material-symbols-outlined">badge</span> Pendaftaran
            </a>

            <div class="nav-section">Sistem</div>
            <a href="{{ route('admin.logout') }}" class="nav-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <span class="material-symbols-outlined">logout</span> Keluar
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
                <span class="topbar-user">Halo, <strong>{{ Auth::user()->nama ?? 'Admin' }}</strong></span>
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
    </script>

    @yield('scripts')
</body>
</html>
