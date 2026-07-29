<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VisiMisi;
use Illuminate\Http\Request;

class VisiMisiController extends Controller
{
    public function index(Request $request)
    {
        $query = VisiMisi::query();

        if ($type = $request->input('type')) {
            $query->where('type', $type);
        }

        $visiMisi = $query->orderBy('urutan')->orderBy('id')->paginate(15)->withQueryString();

        return view('admin.visi-misi.index', compact('visiMisi'));
    }

    public function create()
    {
        return view('admin.visi-misi.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type'        => 'required|in:visi,misi',
            'icon'        => 'nullable|string|max:255',
            'title'       => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'urutan'      => 'nullable|integer',
            'status'      => 'required|in:Show,Hide',
        ]);

        VisiMisi::create($validated);

        return redirect()->route('admin.visi-misi.index')->with('success', 'Visi & Misi berhasil ditambahkan.');
    }

    public function edit(VisiMisi $visiMisi)
    {
        return view('admin.visi-misi.edit', compact('visiMisi'));
    }

    public function update(Request $request, VisiMisi $visiMisi)
    {
        $validated = $request->validate([
            'type'        => 'required|in:visi,misi',
            'icon'        => 'nullable|string|max:255',
            'title'       => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'urutan'      => 'nullable|integer',
            'status'      => 'required|in:Show,Hide',
        ]);

        $visiMisi->update($validated);

        return redirect()->route('admin.visi-misi.index')->with('success', 'Visi & Misi berhasil diupdate.');
    }

    public function destroy(VisiMisi $visiMisi)
    {
        $visiMisi->delete();

        return redirect()->route('admin.visi-misi.index')->with('success', 'Visi & Misi berhasil dihapus.');
    }
}
