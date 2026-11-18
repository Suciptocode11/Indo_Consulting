<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\PengaturanController;
use App\Http\Controllers\Admin\PageContentController;
use App\Http\Controllers\Admin\SocialMediaController;
use App\Http\Controllers\Admin\KeunggulanController;
use App\Http\Controllers\Admin\VisiMisiController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\UploadController;
use App\Http\Controllers\Admin\PendaftaranController as AdminPendaftaranController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\RateLimiter;
use App\Http\Controllers\PageController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/tentang-kami', [PageController::class, 'tentangKami'])->name('tentang-kami');
Route::get('/our-expert', [PageController::class, 'ourExpert'])->name('our-expert');
Route::get('/news-events', [PageController::class, 'newsEvents'])->name('news-events');
Route::get('/berita/{slug}', [PageController::class, 'blogShow'])->name('blog.show');
Route::get('/gallery', [PageController::class, 'gallery'])->name('gallery');
Route::get('/program', [PageController::class, 'program'])->name('program');
Route::get('/program/{slug}', [PageController::class, 'programShow'])->name('program.show');
Route::get('/portfolio', [PageController::class, 'portfolio'])->name('portfolio');
Route::get('/portfolio/{slug}', [PageController::class, 'portfolioShow'])->name('portfolio.show');
Route::get('/partners-clients', [PageController::class, 'partnersClients'])->name('partners-clients');
Route::get('/kontak-kami', [PageController::class, 'kontakKami'])->name('kontak-kami');
Route::get('/karir', [PageController::class, 'karir'])->name('karir');
Route::get('/karir/daftar', [PendaftaranController::class, 'create'])->name('pendaftaran.create');
Route::post('/karir/daftar', [PendaftaranController::class, 'store'])->name('pendaftaran.store')->middleware('throttle:pendaftaran');

// Partner & Client Registration
Route::get('/daftar-partner', [\App\Http\Controllers\PartnerSubmissionController::class, 'create'])->name('partner.create');
Route::post('/daftar-partner', [\App\Http\Controllers\PartnerSubmissionController::class, 'store'])->name('partner.store')->middleware('throttle:pendaftaran');

// SEO
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

/*
|--------------------------------------------------------------------------
| Admin Auth Routes
|--------------------------------------------------------------------------
*/
Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.post')->middleware('throttle:login');

/*
|--------------------------------------------------------------------------
| Admin Protected Routes
|--------------------------------------------------------------------------
*/
Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // ─── Modul Program Layanan (Super Admin, Admin, & Finance) ─────────────
    Route::middleware('role:super_admin,admin,finance')->group(function () {
        Route::resource('services', ServiceController::class)->except(['show']);
    });

    // ─── Modul Konten Website & Operasional (Super Admin & Admin) ─────────
    Route::middleware('role:super_admin,admin')->group(function () {
        // Pengaturan (singleton — edit only)
        Route::get('/pengaturan', [PengaturanController::class, 'edit'])->name('pengaturan.edit');
        Route::put('/pengaturan', [PengaturanController::class, 'update'])->name('pengaturan.update');

        // Page Contents
        Route::get('/page-contents', [PageContentController::class, 'index'])->name('page-contents.index');
        Route::post('/page-contents', [PageContentController::class, 'update'])->name('page-contents.update');

        // Social Media
        Route::get('/social-media', [SocialMediaController::class, 'index'])->name('social-media.index');
        Route::put('/social-media', [SocialMediaController::class, 'update'])->name('social-media.update');

        // Full CRUD Resources
        Route::resource('projects', ProjectController::class)->except(['show']);
        Route::resource('clients', ClientController::class)->except(['show']);
        Route::resource('blog', BlogController::class)->except(['show']);
        Route::resource('reviews', ReviewController::class)->except(['show']);
        Route::resource('faqs', FaqController::class)->except(['show']);
        Route::resource('members', MemberController::class);
        Route::resource('keunggulan', KeunggulanController::class)->except(['show']);
        Route::resource('visi-misi', VisiMisiController::class)->except(['show']);
        Route::resource('kategori-project', \App\Http\Controllers\Admin\KategoriProjectController::class)->except(['show']);
        Route::post('/kategori-project/quick-store', [\App\Http\Controllers\Admin\KategoriProjectController::class, 'quickStoreCategory'])->name('kategori-project.quick-store');
        Route::post('/kategori-blog/quick-store', [\App\Http\Controllers\Admin\BlogController::class, 'quickStoreCategory'])->name('kategori-blog.quick-store');

        // Upload (Summernote image)
        Route::post('/upload-image', [UploadController::class, 'uploadImage'])->middleware('throttle:upload');

        // Gallery (unified)
        Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');
        Route::get('/gallery/album/create', [GalleryController::class, 'albumCreate'])->name('gallery.album-create');
        Route::post('/gallery/album', [GalleryController::class, 'albumStore'])->name('gallery.album-store');
        Route::get('/gallery/album/{album}/edit', [GalleryController::class, 'albumEdit'])->name('gallery.album-edit');
        Route::put('/gallery/album/{album}', [GalleryController::class, 'albumUpdate'])->name('gallery.album-update');
        Route::delete('/gallery/album/{album}', [GalleryController::class, 'albumDestroy'])->name('gallery.album-destroy');
        Route::post('/gallery/foto', [GalleryController::class, 'fotoStore'])->name('gallery.foto-store');
        Route::put('/gallery/foto/{foto}', [GalleryController::class, 'fotoUpdate'])->name('gallery.foto-update');
        Route::delete('/gallery/foto/{foto}', [GalleryController::class, 'fotoDestroy'])->name('gallery.foto-destroy');
        Route::post('/gallery/album/{album}/foto', [GalleryController::class, 'fotoStoreInAlbum'])->name('gallery.album-foto-store');
        Route::delete('/gallery/album/{album}/foto/{foto}', [GalleryController::class, 'fotoDestroyFromAlbum'])->name('gallery.album-foto-destroy');
        Route::get('/gallery/video/create', [GalleryController::class, 'videoCreate'])->name('gallery.video-create');
        Route::post('/gallery/video', [GalleryController::class, 'videoStore'])->name('gallery.video-store');
        Route::get('/gallery/video/{video}/edit', [GalleryController::class, 'videoEdit'])->name('gallery.video-edit');
        Route::put('/gallery/video/{video}', [GalleryController::class, 'videoUpdate'])->name('gallery.video-update');
        Route::delete('/gallery/video/{video}', [GalleryController::class, 'videoDestroy'])->name('gallery.video-destroy');

        // Pendaftaran
        Route::get('/pendaftaran', [AdminPendaftaranController::class, 'index'])->name('pendaftaran.index');
        Route::get('/pendaftaran/{pendaftaran}', [AdminPendaftaranController::class, 'show'])->name('pendaftaran.show');
        Route::post('/pendaftaran/{pendaftaran}/approve', [AdminPendaftaranController::class, 'approve'])->name('pendaftaran.approve');
        Route::post('/pendaftaran/{pendaftaran}/reject', [AdminPendaftaranController::class, 'reject'])->name('pendaftaran.reject');
        Route::delete('/pendaftaran/{pendaftaran}', [AdminPendaftaranController::class, 'destroy'])->name('pendaftaran.destroy');

        // Partner Submissions
        Route::get('/partner-submissions', [\App\Http\Controllers\Admin\PartnerSubmissionController::class, 'index'])->name('partner-submissions.index');
        Route::get('/partner-submissions/{submission}', [\App\Http\Controllers\Admin\PartnerSubmissionController::class, 'show'])->name('partner-submissions.show');
        Route::post('/partner-submissions/{submission}/approve', [\App\Http\Controllers\Admin\PartnerSubmissionController::class, 'approve'])->name('partner-submissions.approve');
        Route::post('/partner-submissions/{submission}/reject', [\App\Http\Controllers\Admin\PartnerSubmissionController::class, 'reject'])->name('partner-submissions.reject');
        Route::delete('/partner-submissions/{submission}', [\App\Http\Controllers\Admin\PartnerSubmissionController::class, 'destroy'])->name('partner-submissions.destroy');
    });

    // ─── Modul Manajemen Keuangan (Super Admin & Finance) ───────────────────
    Route::middleware('role:super_admin,finance')->prefix('keuangan')->name('keuangan.')->group(function () {
        // ── Keuangan Program (per Service/Layanan) ──────────────────────────
        Route::prefix('program')->name('program.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\KeuanganProgramController::class, 'index'])->name('index');
        });

        // ── Kontrak Klien ───────────────────────────────────────────────────
        Route::prefix('kontrak')->name('kontrak.')->group(function () {
            Route::get('/',                          fn() => redirect()->to(route('admin.keuangan.program.index') . '#daftar-kontrak'))->name('index');
            Route::get('/create',                    [\App\Http\Controllers\Admin\KeuanganProyekController::class, 'create'])->name('create');
            Route::post('/',                         [\App\Http\Controllers\Admin\KeuanganProyekController::class, 'store'])->name('store');
            Route::post('/quick-store',              [\App\Http\Controllers\Admin\KeuanganProyekController::class, 'quickStore'])->name('quick-store');
            Route::get('/{proyek}',                  [\App\Http\Controllers\Admin\KeuanganProyekController::class, 'show'])->name('show')->whereNumber('proyek');
            Route::get('/{proyek}/edit',             [\App\Http\Controllers\Admin\KeuanganProyekController::class, 'edit'])->name('edit')->whereNumber('proyek');
            Route::put('/{proyek}',                  [\App\Http\Controllers\Admin\KeuanganProyekController::class, 'update'])->name('update')->whereNumber('proyek');
            Route::delete('/{proyek}',               [\App\Http\Controllers\Admin\KeuanganProyekController::class, 'destroy'])->name('destroy')->whereNumber('proyek');
            Route::post('/{proyek}/quick-transaksi', [\App\Http\Controllers\Admin\KeuanganProyekController::class, 'quickTransaksi'])->name('quick-transaksi')->whereNumber('proyek');
        });

        // ── Proyek Klien (Alias & Akses Langsung) ───────────────────────────
        Route::prefix('proyek')->name('proyek.')->group(function () {
            Route::get('/',                          fn() => redirect()->to(route('admin.keuangan.program.index') . '#daftar-kontrak'))->name('index');
            Route::get('/create',                    [\App\Http\Controllers\Admin\KeuanganProyekController::class, 'create'])->name('create');
            Route::post('/',                         [\App\Http\Controllers\Admin\KeuanganProyekController::class, 'store'])->name('store');
            Route::post('/quick-store',              [\App\Http\Controllers\Admin\KeuanganProyekController::class, 'quickStore'])->name('quick-store');
            Route::get('/{proyek}',                  [\App\Http\Controllers\Admin\KeuanganProyekController::class, 'show'])->name('show')->whereNumber('proyek');
            Route::get('/{proyek}/edit',             [\App\Http\Controllers\Admin\KeuanganProyekController::class, 'edit'])->name('edit')->whereNumber('proyek');
            Route::put('/{proyek}',                  [\App\Http\Controllers\Admin\KeuanganProyekController::class, 'update'])->name('update')->whereNumber('proyek');
            Route::delete('/{proyek}',               [\App\Http\Controllers\Admin\KeuanganProyekController::class, 'destroy'])->name('destroy')->whereNumber('proyek');
            Route::post('/{proyek}/quick-transaksi', [\App\Http\Controllers\Admin\KeuanganProyekController::class, 'quickTransaksi'])->name('quick-transaksi')->whereNumber('proyek');
        });

        // Kategori Keuangan (harus didefinisikan sebelum wildcard /{keuangan})
        Route::prefix('kategori')->name('kategori.')->group(function () {
            Route::get('/',                                                                [\App\Http\Controllers\Admin\KategoriKeuanganController::class, 'index'])->name('index');
            Route::get('/create',                                                          [\App\Http\Controllers\Admin\KategoriKeuanganController::class, 'create'])->name('create');
            Route::post('/',                                                               [\App\Http\Controllers\Admin\KategoriKeuanganController::class, 'store'])->name('store');
            Route::post('/quick-store',                                                    [\App\Http\Controllers\Admin\KategoriKeuanganController::class, 'quickStore'])->name('quick-store');
            Route::get('/{kategoriKeuangan}/edit',                                         [\App\Http\Controllers\Admin\KategoriKeuanganController::class, 'edit'])->name('edit');
            Route::put('/{kategoriKeuangan}',                                              [\App\Http\Controllers\Admin\KategoriKeuanganController::class, 'update'])->name('update');
            Route::delete('/{kategoriKeuangan}',                                           [\App\Http\Controllers\Admin\KategoriKeuanganController::class, 'destroy'])->name('destroy');
            Route::get('/ajax/by-tipe',                                                    [\App\Http\Controllers\Admin\KategoriKeuanganController::class, 'byTipe'])->name('by-tipe');
        });

        // Transaksi (resource utama)
        Route::get('/',                                                                    [\App\Http\Controllers\Admin\KeuanganController::class, 'index'])->name('index');
        Route::get('/create',                                                              [\App\Http\Controllers\Admin\KeuanganController::class, 'create'])->name('create');
        Route::post('/',                                                                   [\App\Http\Controllers\Admin\KeuanganController::class, 'store'])->name('store');
        Route::get('/export/excel',                                                        [\App\Http\Controllers\Admin\KeuanganController::class, 'exportExcel'])->name('export-excel');
        Route::get('/export/pdf',                                                          [\App\Http\Controllers\Admin\KeuanganController::class, 'exportPdf'])->name('export-pdf');
        Route::get('/export/csv',                                                          [\App\Http\Controllers\Admin\KeuanganController::class, 'export'])->name('export');
        Route::get('/{keuangan}',                                                          [\App\Http\Controllers\Admin\KeuanganController::class, 'show'])->name('show')->whereNumber('keuangan');
        Route::get('/{keuangan}/edit',                                                     [\App\Http\Controllers\Admin\KeuanganController::class, 'edit'])->name('edit')->whereNumber('keuangan');
        Route::put('/{keuangan}',                                                          [\App\Http\Controllers\Admin\KeuanganController::class, 'update'])->name('update')->whereNumber('keuangan');
        Route::delete('/{keuangan}',                                                       [\App\Http\Controllers\Admin\KeuanganController::class, 'destroy'])->name('destroy')->whereNumber('keuangan');
        Route::post('/{keuangan}/tandai-lunas',                                            [\App\Http\Controllers\Admin\KeuanganController::class, 'tandaiLunas'])->name('tandai-lunas')->whereNumber('keuangan');
    });

    // ─── Khusus Super Admin: Kelola Akun Pengguna ───────────────────────────
    Route::middleware('role:super_admin')->group(function () {
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->except(['show']);
    });
});
