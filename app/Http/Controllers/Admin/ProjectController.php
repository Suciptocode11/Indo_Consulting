<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\KategoriProject;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::with(['kategoriProject', 'service']);

        if ($search = $request->input('search')) {
            $query->where('title', 'like', "%{$search}%");
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $projects = $query->orderByDesc('id')->paginate(15)->withQueryString();
        $kategoris = KategoriProject::orderBy('title')->get();

        return view('admin.projects.index', compact('projects', 'kategoris'));
    }

    public function create()
    {
        $kategoris = KategoriProject::orderBy('title')->get();

        return view('admin.projects.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date'        => 'nullable|string|max:20',
            'title'       => 'required|string|max:500',
            'img'         => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'content'     => 'nullable|string',
            'status'      => 'required|in:Show,Hide',
            'url'         => 'nullable|string|max:500',
            'lokasi'      => 'nullable|string',
            'slug'        => 'nullable|string|max:255',
            'id_category' => 'nullable|integer',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        if ($request->hasFile('img')) {
            $validated['img'] = $request->file('img')->store('projects', 'public');
        }

        Project::create($validated);

        return redirect()->route('admin.projects.index')->with('success', 'Proyek berhasil ditambahkan.');
    }

    public function edit(Project $project)
    {
        $kategoris = KategoriProject::orderBy('title')->get();

        return view('admin.projects.edit', compact('project', 'kategoris'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'date'        => 'nullable|string|max:20',
            'title'       => 'required|string|max:500',
            'img'         => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'content'     => 'nullable|string',
            'status'      => 'required|in:Show,Hide',
            'url'         => 'nullable|string|max:500',
            'lokasi'      => 'nullable|string',
            'slug'        => 'nullable|string|max:255',
            'id_category' => 'nullable|integer',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        if ($request->hasFile('img')) {
            if ($project->img && \Storage::disk('public')->exists($project->img)) {
                \Storage::disk('public')->delete($project->img);
            }
            $validated['img'] = $request->file('img')->store('projects', 'public');
        }

        $project->update($validated);

        return redirect()->route('admin.projects.index')->with('success', 'Proyek berhasil diupdate.');
    }

    public function destroy(Project $project)
    {
        if ($project->img && \Storage::disk('public')->exists($project->img)) {
            \Storage::disk('public')->delete($project->img);
        }

        $project->delete();

        return redirect()->route('admin.projects.index')->with('success', 'Proyek berhasil dihapus.');
    }
}
