<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriKeuangan;
use Illuminate\Http\Request;

class KategoriKeuanganController extends Controller
{
    public function index(Request $request)
    {
        $query = KategoriKeuangan::query();

        if ($tipe = $request->input('tipe')) {
            $query->where('tipe', $tipe);
        }

        if ($search = $request->input('search')) {
            $query->where('nama', 'like', "%{$search}%");
        }

        $kategoris = $query->withCount('transaksi')->orderBy('tipe')->orderBy('nama')->paginate(20)->withQueryString();

        return view('admin.keuangan.kategori.index', compact('kategoris'));
    }

    public function create()
    {
        return view('admin.keuangan.kategori.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'        => 'required|string|max:255',
            'tipe'        => 'required|in:pemasukan,pengeluaran',
            'keterangan'  => 'nullable|string|max:1000',
        ]);

        KategoriKeuangan::create($validated);

        if ($request->input('save_and_add') == '1' || $request->has('save_and_add')) {
            return redirect()->route('admin.keuangan.kategori.create', ['tipe' => $validated['tipe']])
                ->with('success', "Kategori '{$validated['nama']}' berhasil disimpan. Silakan tambahkan kategori berikutnya.");
        }

        return redirect()->route('admin.keuangan.kategori.index')
            ->with('success', 'Kategori keuangan berhasil ditambahkan.');
    }

    public function edit(KategoriKeuangan $kategoriKeuangan)
    {
        return view('admin.keuangan.kategori.edit', ['kategori' => $kategoriKeuangan]);
    }

    public function update(Request $request, KategoriKeuangan $kategoriKeuangan)
    {
        $validated = $request->validate([
            'nama'       => 'required|string|max:255',
            'tipe'       => 'required|in:pemasukan,pengeluaran',
            'keterangan' => 'nullable|string|max:1000',
        ]);

        $kategoriKeuangan->update($validated);

        return redirect()->route('admin.keuangan.kategori.index')
            ->with('success', 'Kategori keuangan berhasil diperbarui.');
    }

    public function destroy(KategoriKeuangan $kategoriKeuangan)
    {
        if ($kategoriKeuangan->transaksi()->exists()) {
            return back()->with('error', 'Kategori tidak dapat dihapus karena masih memiliki transaksi terkait.');
        }

        $kategoriKeuangan->delete();

        return redirect()->route('admin.keuangan.kategori.index')
            ->with('success', 'Kategori keuangan berhasil dihapus.');
    }

    /**
     * AJAX endpoint: return kategori list filtered by tipe
     */
    public function byTipe(Request $request)
    {
        $tipe = $request->input('tipe');
        $data = KategoriKeuangan::where('tipe', $tipe)->orderBy('nama')->get(['id', 'nama']);
        return response()->json($data);
    }

    /**
     * AJAX endpoint: Quick add kategori from transaction form
     */
    public function quickStore(Request $request)
    {
        $validated = $request->validate([
            'nama'        => 'required|string|max:255',
            'tipe'        => 'required|in:pemasukan,pengeluaran',
            'keterangan'  => 'nullable|string|max:1000',
        ]);

        $kategori = KategoriKeuangan::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil ditambahkan.',
            'data'    => [
                'id'   => $kategori->id,
                'nama' => $kategori->nama,
                'tipe' => $kategori->tipe,
            ],
        ]);
    }
}

