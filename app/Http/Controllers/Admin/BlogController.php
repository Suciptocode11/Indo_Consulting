<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Blog::with('kategori');

        if ($search = $request->input('search')) {
            $query->where('title', 'like', "%{$search}%");
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $blogs = $query->orderByDesc('id')->paginate(15)->withQueryString();
        $kategoris = Kategori::orderBy('title')->get();

        return view('admin.blog.index', compact('blogs', 'kategoris'));
    }

    public function create()
    {
        $kategoris = Kategori::orderBy('title')->get();

        return view('admin.blog.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date'        => 'nullable|date',
            'title'       => 'required|string|max:500',
            'slug'        => 'nullable|string|max:500',
            'img'         => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'caption'     => 'nullable|string|max:500',
            'content'     => 'nullable|string',
            'status'      => 'required|in:Show,Hide',
            'tags'        => 'nullable|string',
            'keyword'     => 'nullable|string',
            'id_category' => 'nullable|integer',
            'hit'         => 'nullable|integer|min:0',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $validated['hit'] = $validated['hit'] ?? 0;

        if ($request->hasFile('img')) {
            $validated['img'] = $request->file('img')->store('blog', 'public');
        }

        Blog::create($validated);

        return redirect()->route('admin.blog.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit(Blog $blog)
    {
        $kategoris = Kategori::orderBy('title')->get();

        return view('admin.blog.edit', compact('blog', 'kategoris'));
    }

    public function update(Request $request, Blog $blog)
    {
        $validated = $request->validate([
            'date'        => 'nullable|date',
            'title'       => 'required|string|max:500',
            'slug'        => 'nullable|string|max:500',
            'img'         => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'caption'     => 'nullable|string|max:500',
            'content'     => 'nullable|string',
            'status'      => 'required|in:Show,Hide',
            'tags'        => 'nullable|string',
            'keyword'     => 'nullable|string',
            'id_category' => 'nullable|integer',
            'hit'         => 'nullable|integer|min:0',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        if ($request->hasFile('img')) {
            if ($blog->img && \Storage::disk('public')->exists($blog->img)) {
                \Storage::disk('public')->delete($blog->img);
            }
            $validated['img'] = $request->file('img')->store('blog', 'public');
        }

        $blog->update($validated);

        return redirect()->route('admin.blog.index')->with('success', 'Berita berhasil diupdate.');
    }

    public function destroy(Blog $blog)
    {
        if ($blog->img && \Storage::disk('public')->exists($blog->img)) {
            \Storage::disk('public')->delete($blog->img);
        }

        $blog->delete();

        return redirect()->route('admin.blog.index')->with('success', 'Berita berhasil dihapus.');
    }
}
