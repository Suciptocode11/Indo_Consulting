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
use Illuminate\Support\Facades\Route;
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
Route::post('/karir/daftar', [PendaftaranController::class, 'store'])->name('pendaftaran.store');

/*
|--------------------------------------------------------------------------
| Admin Auth Routes
|--------------------------------------------------------------------------
*/
Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.post');

/*
|--------------------------------------------------------------------------
| Admin Protected Routes
|--------------------------------------------------------------------------
*/
Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

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
    Route::resource('services', ServiceController::class)->except(['show']);
    Route::resource('projects', ProjectController::class)->except(['show']);
    Route::resource('clients', ClientController::class)->except(['show']);
    Route::resource('blog', BlogController::class)->except(['show']);
    Route::resource('reviews', ReviewController::class)->except(['show']);
    Route::resource('faqs', FaqController::class)->except(['show']);
    Route::resource('members', MemberController::class);
    Route::resource('keunggulan', KeunggulanController::class)->except(['show']);
    Route::resource('visi-misi', VisiMisiController::class)->except(['show']);
    Route::resource('kategori-project', \App\Http\Controllers\Admin\KategoriProjectController::class)->except(['show']);

    // Upload (Summernote image)
    Route::post('/upload-image', [UploadController::class, 'uploadImage']);

    // Gallery (unified)
    Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');
    // Album
    Route::get('/gallery/album/create', [GalleryController::class, 'albumCreate'])->name('gallery.album-create');
    Route::post('/gallery/album', [GalleryController::class, 'albumStore'])->name('gallery.album-store');
    Route::get('/gallery/album/{album}/edit', [GalleryController::class, 'albumEdit'])->name('gallery.album-edit');
    Route::put('/gallery/album/{album}', [GalleryController::class, 'albumUpdate'])->name('gallery.album-update');
    Route::delete('/gallery/album/{album}', [GalleryController::class, 'albumDestroy'])->name('gallery.album-destroy');
    // Foto
    Route::post('/gallery/foto', [GalleryController::class, 'fotoStore'])->name('gallery.foto-store');
    Route::delete('/gallery/foto/{foto}', [GalleryController::class, 'fotoDestroy'])->name('gallery.foto-destroy');
    Route::post('/gallery/album/{album}/foto', [GalleryController::class, 'fotoStoreInAlbum'])->name('gallery.album-foto-store');
    Route::delete('/gallery/album/{album}/foto/{foto}', [GalleryController::class, 'fotoDestroyFromAlbum'])->name('gallery.album-foto-destroy');
    // Video
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
});
