<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriKeuangan;
use App\Models\ProyekKlien;
use App\Models\TransaksiKeuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class KeuanganProyekController extends Controller
{
    public function index(Request $request)
    {
        $search    = $request->input('search', '');
        $status    = $request->input('status', '');
        $serviceId = $request->input('service_id', '');
        $tahun     = $request->input('tahun', '');

        // Query proyek klien
        $query = ProyekKlien::with('service');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_proyek', 'like', "%{$search}%")
                  ->orWhere('nama_klien', 'like', "%{$search}%")
                  ->orWhere('kode_proyek', 'like', "%{$search}%");
            });
        }

        if ($serviceId) {
            $query->where('service_id', $serviceId);
        }

        if ($tahun) {
            $query->whereYear('tanggal_mulai', $tahun);
        }

        if ($status === 'piutang' || $status === 'belum_lunas') {
            $proyeks = $query->orderByDesc('tanggal_mulai')->orderByDesc('id')->get()->filter(function ($p) {
                return $p->sisa_tagihan > 0;
            });
        } elseif ($status === 'lunas') {
            $proyeks = $query->orderByDesc('tanggal_mulai')->orderByDesc('id')->get()->filter(function ($p) {
                return $p->sisa_tagihan <= 0 && $p->nilai_kontrak > 0;
            });
        } else {
            if ($status) {
                $query->where('status', $status);
            }
            $proyeks = $query->orderByDesc('tanggal_mulai')->orderByDesc('id')->get();
        }

        // Agregasi KPI Keseluruhan
        $allProyeks = ProyekKlien::all();
        $totalNilaiKontrak = $allProyeks->sum('nilai_kontrak');

        $totalPemasukan = (float) TransaksiKeuangan::whereNotNull('proyek_klien_id')
            ->where('tipe', 'pemasukan')
            ->where('status', 'lunas')
            ->sum('nominal');

        $totalPengeluaran = (float) TransaksiKeuangan::whereNotNull('proyek_klien_id')
            ->where('tipe', 'pengeluaran')
            ->where('status', 'lunas')
            ->sum('nominal');

        $totalSisaTagihan = max(0, $totalNilaiKontrak - $totalPemasukan);
        $totalLabaBersih  = $totalPemasukan - $totalPengeluaran;

        // Opsi filter
        $services = DB::table('service')->where('status', 'Show')->orderBy('title')->get();
        $tahunList = ProyekKlien::selectRaw('YEAR(tanggal_mulai) as tahun')
            ->groupBy('tahun')
            ->orderByDesc('tahun')
            ->pluck('tahun');

        if ($tahunList->isEmpty()) {
            $tahunList = collect([now()->year]);
        }

        return view('admin.keuangan.proyek.index', compact(
            'proyeks', 'search', 'status', 'serviceId', 'tahun',
            'totalNilaiKontrak', 'totalPemasukan', 'totalPengeluaran',
            'totalSisaTagihan', 'totalLabaBersih',
            'services', 'tahunList'
        ));
    }

    public function create()
    {
        $kodeProyek = ProyekKlien::generateKodeProyek();
        $services = DB::table('service')->where('status', 'Show')->orderBy('title')->get();

        return view('admin.keuangan.proyek.create', compact('kodeProyek', 'services'));
    }

    public function store(Request $request)
    {
        if ($request->has('tanggal_mulai') && preg_match('/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/', (string) $request->input('tanggal_mulai'), $m)) {
            $request->merge(['tanggal_mulai' => sprintf('%04d-%02d-%02d', $m[3], $m[2], $m[1])]);
        }
        if ($request->has('tanggal_selesai') && preg_match('/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/', (string) $request->input('tanggal_selesai'), $m)) {
            $request->merge(['tanggal_selesai' => sprintf('%04d-%02d-%02d', $m[3], $m[2], $m[1])]);
        }
        if ($request->has('nilai_kontrak')) {
            $raw = str_replace(['.', ','], ['', '.'], (string) $request->input('nilai_kontrak'));
            $request->merge(['nilai_kontrak' => $raw]);
        }

        $validated = $request->validate([
            'nama_proyek'     => 'required|string|max:255',
            'nama_klien'      => 'required|string|max:255',
            'kontak_klien'    => 'nullable|string|max:255',
            'pic'             => 'nullable|string|max:100',
            'service_id'      => 'nullable|exists:service,id',
            'nilai_kontrak'   => 'required|numeric|min:0',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'status'          => 'required|in:berjalan,selesai,pending,batal',
            'deskripsi'       => 'nullable|string',
            'keterangan'      => 'nullable|string',
        ]);

        $validated['kode_proyek'] = ProyekKlien::generateKodeProyek();
        $validated['keterangan']  = $validated['deskripsi'] ?? $request->input('keterangan');
        $validated['created_by']  = Auth::id() ?? 1;

        $proyek = ProyekKlien::create($validated);

        if ($request->input('save_and_add') == '1' || $request->has('save_and_add')) {
            if ($request->routeIs('admin.keuangan.proyek.store') || str_contains(url()->previous(), 'proyek/create')) {
                return redirect()->route('admin.keuangan.proyek.create')
                    ->with('success', "Proyek '{$proyek->nama_proyek}' berhasil ditambahkan. Silakan tambahkan proyek berikutnya.");
            }
            return back()
                ->with('success', "Kontrak klien '{$proyek->nama_proyek}' berhasil ditambahkan. Silakan tambahkan kontrak berikutnya.")
                ->with('reopen_modal_kontrak', true);
        }

        return redirect()->route('admin.keuangan.kontrak.show', $proyek->id)
            ->with('success', "Kontrak klien '{$proyek->nama_proyek}' berhasil ditambahkan.");
    }

    public function show(int $id)
    {
        $proyek = ProyekKlien::with(['service', 'creator'])->findOrFail($id);

        $transaksi = TransaksiKeuangan::with(['kategori', 'createdBy'])
            ->where('proyek_klien_id', $id)
            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->get();

        $pemasukanList   = $transaksi->where('tipe', 'pemasukan');
        $pengeluaranList = $transaksi->where('tipe', 'pengeluaran');

        $kategoriPemasukan   = KategoriKeuangan::where('tipe', 'pemasukan')->orderBy('nama')->get();
        $kategoriPengeluaran = KategoriKeuangan::where('tipe', 'pengeluaran')->orderBy('nama')->get();

        return view('admin.keuangan.proyek.show', compact(
            'proyek', 'transaksi', 'pemasukanList', 'pengeluaranList',
            'kategoriPemasukan', 'kategoriPengeluaran'
        ));
    }

    public function edit(int $id)
    {
        $proyek = ProyekKlien::findOrFail($id);
        $services = DB::table('service')->where('status', 'Show')->orderBy('title')->get();

        return view('admin.keuangan.proyek.edit', compact('proyek', 'services'));
    }

    public function update(Request $request, int $id)
    {
        $proyek = ProyekKlien::findOrFail($id);

        if ($request->has('nilai_kontrak')) {
            $raw = str_replace(['.', ','], ['', '.'], (string) $request->input('nilai_kontrak'));
            $request->merge(['nilai_kontrak' => $raw]);
        }

        $validated = $request->validate([
            'nama_proyek'     => 'required|string|max:255',
            'nama_klien'      => 'required|string|max:255',
            'kontak_klien'    => 'nullable|string|max:255',
            'pic'             => 'nullable|string|max:100',
            'service_id'      => 'nullable|exists:service,id',
            'nilai_kontrak'   => 'required|numeric|min:0',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'status'          => 'required|in:berjalan,selesai,pending,batal',
            'deskripsi'       => 'nullable|string',
            'keterangan'      => 'nullable|string',
        ]);

        if (isset($validated['deskripsi'])) {
            $validated['keterangan'] = $validated['deskripsi'];
        }

        $proyek->update($validated);

        return redirect()->route('admin.keuangan.kontrak.show', $proyek->id)
            ->with('success', "Data kontrak klien '{$proyek->nama_proyek}' berhasil diperbarui.");
    }

    public function destroy(int $id)
    {
        $proyek = ProyekKlien::findOrFail($id);
        $nama = $proyek->nama_proyek;

        // Lepaskan relasi transaksi agar riwayat keuangan umum tidak hilang
        TransaksiKeuangan::where('proyek_klien_id', $id)->update(['proyek_klien_id' => null]);

        $proyek->delete();

        return redirect()->route('admin.keuangan.program.index')
            ->with('success', "Kontrak '{$nama}' berhasil dihapus. Transaksi terkait tetap tersimpan di buku kas umum.");
    }

    public function quickTransaksi(Request $request, int $id)
    {
        $proyek = ProyekKlien::findOrFail($id);

        if ($request->has('tanggal') && preg_match('/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/', (string) $request->input('tanggal'), $m)) {
            $request->merge(['tanggal' => sprintf('%04d-%02d-%02d', $m[3], $m[2], $m[1])]);
        }

        if ($request->has('nominal')) {
            $raw = str_replace(['.', ','], ['', '.'], (string) $request->input('nominal'));
            $request->merge(['nominal' => $raw]);
        }

        if ($request->has('harga_satuan')) {
            $rawHs = str_replace(['.', ','], ['', '.'], (string) $request->input('harga_satuan'));
            $request->merge(['harga_satuan' => $rawHs]);
        }

        if ($request->has('status') && $request->input('status') === 'piutang') {
            $request->merge(['status' => 'pending']);
        }
        if ($request->filled('deskripsi')) {
            $request->merge(['judul' => Str::limit($request->input('deskripsi'), 250)]);
        } elseif ($request->filled('judul')) {
            $request->merge(['deskripsi' => $request->input('judul')]);
        } else {
            $judulFallback = $request->input('tipe') === 'pemasukan' ? "Pemasukan - {$proyek->nama_proyek}" : "Pengeluaran - {$proyek->nama_proyek}";
            $request->merge(['judul' => Str::limit($judulFallback, 250), 'deskripsi' => Str::limit($judulFallback, 250)]);
        }

        $validated = $request->validate([
            'tipe'              => 'required|in:pemasukan,pengeluaran',
            'kategori_id'       => 'required|exists:kategori_keuangan,id',
            'tanggal'           => 'required|date',
            'judul'             => 'required|string|max:500',
            'penerima'          => 'nullable|string|max:255',
            'nominal'           => 'required|numeric|min:1',
            'satuan'            => 'nullable|string|max:50',
            'volume'            => 'nullable|numeric|min:0.01',
            'harga_satuan'      => 'nullable|numeric|min:0',
            'metode_pembayaran' => 'nullable|in:Transfer Bank,Kas Tunai,Lainnya',
            'status'            => 'nullable|in:lunas,pending',
            'bukti'             => 'nullable|file|mimes:jpeg,png,jpg,webp,pdf|max:5120',
            'deskripsi'         => 'nullable|string',
            'keterangan'        => 'nullable|string',
        ]);

        $validated['metode_pembayaran'] = $validated['metode_pembayaran'] ?? 'Transfer Bank';
        $validated['status']            = $validated['status'] ?? 'lunas';
        $validated['volume']            = $validated['volume'] ?? 1;
        $validated['satuan']            = $validated['satuan'] ?? 'paket';
        $validated['keterangan']        = $validated['deskripsi'] ?? $request->input('keterangan');

        // Auto-generate kode transaksi
        $prefix = ($validated['tipe'] === 'pemasukan' ? 'KM-' : 'KK-') . date('Ym') . '-';
        $last = TransaksiKeuangan::where('kode_transaksi', 'like', $prefix . '%')
            ->orderByDesc('id')
            ->value('kode_transaksi');

        $nextNum = $last ? str_pad(((int) substr($last, -4)) + 1, 4, '0', STR_PAD_LEFT) : '0001';

        $validated['kode_transaksi']  = $prefix . $nextNum;
        $validated['proyek_klien_id'] = $proyek->id;
        $validated['service_id']      = $proyek->service_id;
        $validated['created_by']      = Auth::id() ?? 1;

        if ($request->hasFile('bukti')) {
            $validated['bukti'] = $request->file('bukti')->store('keuangan/bukti', 'public');
        }

        TransaksiKeuangan::create($validated);

        $tipeLabel = $validated['tipe'] === 'pemasukan' ? 'Pemasukan' : 'Pengeluaran';

        if ($request->input('save_and_add') == '1' || $request->has('save_and_add')) {
            $modalToReopen = $validated['tipe'] === 'pemasukan' ? 'modalInflow' : 'modalOutflow';
            return redirect()->route('admin.keuangan.kontrak.show', $proyek->id)
                ->with('success', "{$tipeLabel} untuk proyek '{$proyek->nama_proyek}' berhasil dicatat. Silakan tambah data berikutnya.")
                ->with('reopen_modal', $modalToReopen);
        }

        return redirect()->route('admin.keuangan.kontrak.show', $proyek->id)
            ->with('success', "{$tipeLabel} untuk proyek '{$proyek->nama_proyek}' berhasil dicatat.");
    }

    public function quickStore(Request $request)
    {
        if ($request->has('nilai_kontrak')) {
            $raw = str_replace(['.', ','], ['', '.'], (string) $request->input('nilai_kontrak'));
            $request->merge(['nilai_kontrak' => $raw]);
        }

        $validated = $request->validate([
            'nama_proyek'   => 'required|string|max:255',
            'nama_klien'    => 'required|string|max:255',
            'kontak_klien'  => 'nullable|string|max:255',
            'service_id'    => 'nullable|exists:service,id',
            'nilai_kontrak' => 'required|numeric|min:0',
            'tanggal_mulai' => 'required|date',
        ]);

        $validated['kode_proyek'] = ProyekKlien::generateKodeProyek();
        $validated['status']      = 'berjalan';
        $validated['created_by']  = Auth::id() ?? 1;

        $proyek = ProyekKlien::create($validated);

        return response()->json([
            'success' => true,
            'message' => "Kontrak klien '{$proyek->nama_proyek}' berhasil dibuat.",
            'proyek'  => [
                'id'          => $proyek->id,
                'kode_proyek' => $proyek->kode_proyek,
                'nama_proyek' => $proyek->nama_proyek,
                'nama_klien'  => $proyek->nama_klien,
                'label'       => "{$proyek->nama_proyek} (Klien: {$proyek->nama_klien})",
            ],
        ]);
    }
}
