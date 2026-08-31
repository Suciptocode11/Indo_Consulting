<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriProject;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KategoriProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = KategoriProject::query();

        if ($search = $request->input('search')) {
            $query->where('title', 'like', "%{$search}%");
        }

        $kategoris = $query->orderBy('title')->paginate(15)->withQueryString();

        return view('admin.kategori-project.index', compact('kategoris'));
    }

    public function create()
    {
        return view('admin.kategori-project.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug'  => 'nullable|string|max:255',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        KategoriProject::create($validated);

        return redirect()->route('admin.kategori-project.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(KategoriProject $kategoriProject)
    {
        return view('admin.kategori-project.edit', compact('kategoriProject'));
    }

    public function update(Request $request, KategoriProject $kategoriProject)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug'  => 'nullable|string|max:255',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $kategoriProject->update($validated);

        return redirect()->route('admin.kategori-project.index')->with('success', 'Kategori berhasil diupdate.');
    }

    public function destroy(KategoriProject $kategoriProject)
    {
        $kategoriProject->delete();

        return redirect()->route('admin.kategori-project.index')->with('success', 'Kategori berhasil dihapus.');
    }

    public function quickStoreCategory(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug'  => 'nullable|string|max:255',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $kategori = KategoriProject::create($validated);

        return response()->json([
            'success' => true,
            'data'    => $kategori,
            'message' => 'Kategori proyek berhasil ditambahkan.',
        ]);
    }
}