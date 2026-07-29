<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Keunggulan;
use Illuminate\Http\Request;

class KeunggulanController extends Controller
{
    public function index(Request $request)
    {
        $query = Keunggulan::query();

        if ($search = $request->input('search')) {
            $query->where('title', 'like', "%{$search}%");
        }

        $keunggulan = $query->orderBy('urutan')->orderBy('id')->paginate(15)->withQueryString();

        return view('admin.keunggulan.index', compact('keunggulan'));
    }

    public function create()
    {
        return view('admin.keunggulan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'icon'        => 'nullable|string|max:255',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'urutan'      => 'nullable|integer',
            'status'      => 'required|in:Show,Hide',
        ]);

        Keunggulan::create($validated);

        return redirect()->route('admin.keunggulan.index')->with('success', 'Keunggulan berhasil ditambahkan.');
    }

    public function edit(Keunggulan $keunggulan)
    {
        return view('admin.keunggulan.edit', compact('keunggulan'));
    }

    public function update(Request $request, Keunggulan $keunggulan)
    {
        $validated = $request->validate([
            'icon'        => 'nullable|string|max:255',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'urutan'      => 'nullable|integer',
            'status'      => 'required|in:Show,Hide',
        ]);

        $keunggulan->update($validated);

        return redirect()->route('admin.keunggulan.index')->with('success', 'Keunggulan berhasil diupdate.');
    }

    public function destroy(Keunggulan $keunggulan)
    {
        $keunggulan->delete();

        return redirect()->route('admin.keunggulan.index')->with('success', 'Keunggulan berhasil dihapus.');
    }
}
