<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PageContentController extends Controller
{
    public function index()
    {
        $pages = ['home', 'tentang-kami', 'program', 'portfolio', 'partners-clients', 'news-events', 'gallery', 'kontak-kami'];
        $currentPage = request('page', 'home');
        $contents = PageContent::where('page', $currentPage)->orderBy('key')->get();

        return view('admin.page-contents.index', compact('pages', 'currentPage', 'contents'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'page' => 'required|string|max:100',
        ]);

        $page = $request->input('page');
        $contents = $request->input('contents', []);

        // Ambil semua content untuk halaman ini (untuk mengetahui key mana yang bertipe image)
        $imageKeys = PageContent::where('page', $page)
            ->where('type', 'image')
            ->pluck('key')
            ->toArray();

        // Proses upload file untuk semua key bertipe image
        foreach ($imageKeys as $imageKey) {
            if ($request->hasFile("files.{$imageKey}")) {
                // Validasi file gambar
                $request->validate([
                    "files.{$imageKey}" => 'file|mimes:jpeg,jpg,png,webp,gif|max:5120',
                ]);

                $file = $request->file("files.{$imageKey}");

                // Hapus file lama jika ada
                $oldContent = PageContent::where('page', $page)->where('key', $imageKey)->first();
                if ($oldContent && !empty($oldContent->value) && !str_starts_with($oldContent->value, 'http')) {
                    Storage::disk('public')->delete($oldContent->value);
                }

                // Simpan file baru
                $path = $file->store('page-images', 'public');
                $contents[$imageKey] = $path;
            }
            // Jika tidak ada file baru diunggah, pertahankan nilai lama (kecuali user hapus)
            elseif (!array_key_exists($imageKey, $contents)) {
                $oldContent = PageContent::where('page', $page)->where('key', $imageKey)->first();
                $contents[$imageKey] = $oldContent ? $oldContent->value : '';
            }
            // Jika value adalah string kosong, artinya user ingin menghapus gambar
            // Biarkan value tetap string kosong (sudah di-set dari hidden input)
        }

        // Simpan semua content
        foreach ($contents as $key => $value) {
            PageContent::updateOrCreate(
                ['key' => $key, 'page' => $page],
                ['value' => $value]
            );
        }

        return redirect()->route('admin.page-contents.index', ['page' => $page])
            ->with('success', 'Konten halaman berhasil disimpan.');
    }
}
