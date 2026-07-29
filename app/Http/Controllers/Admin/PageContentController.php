<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageContent;
use Illuminate\Http\Request;

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
        $validated = $request->validate([
            'page' => 'required|string|max:100',
            'contents' => 'required|array',
            'contents.*' => 'nullable|string|max:5000',
        ]);

        // Handle file uploads for image fields
        $imageKeys = ['hero_image', 'about_image'];
        foreach ($imageKeys as $imageKey) {
            if ($request->hasFile("files.{$imageKey}")) {
                $file = $request->file("files.{$imageKey}");
                $path = $file->store('page-content', 'public');
                $validated['contents'][$imageKey] = $path;
            }
        }

        foreach ($validated['contents'] as $key => $value) {
            PageContent::updateOrCreate(
                ['key' => $key, 'page' => $validated['page']],
                ['value' => $value]
            );
        }

        return redirect()->route('admin.page-contents.index', ['page' => $validated['page']])
            ->with('success', 'Konten halaman berhasil disimpan.');
    }
}
