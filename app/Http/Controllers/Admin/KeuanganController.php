<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriKeuangan;
use App\Models\ProyekKlien;
use App\Models\Service;
use App\Models\TransaksiKeuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class KeuanganController extends Controller
{
    // ─── Index / Dashboard Keuangan ──────────────────────────────────────────

    public function index(Request $request)
    {
        // --- Filter params ---
        $filterMode  = $request->input('filter_mode', 'bulanan'); // harian | range_hari | bulanan | range_bulan | tahunan | semua
        $filterDate  = $request->input('filter_date', now()->format('Y-m-d'));
        $dateStartCustom = $request->input('date_start', now()->startOfMonth()->format('Y-m-d'));
        $dateEndCustom   = $request->input('date_end', now()->format('Y-m-d'));
        $filterMonth = $request->input('filter_month', now()->format('Y-m'));
        $monthStart  = $request->input('month_start', now()->format('Y-01'));
        $monthEnd    = $request->input('month_end', now()->format('Y-12'));
        $filterYear  = $request->input('filter_year', now()->year);
        $filterTipe  = $request->input('tipe', '');
        $filterService = $request->input('service_id', '');
        $filterStatus  = $request->input('status', '');
        $search      = $request->input('search', '');

        // --- Build date range ---
        [$dateStart, $dateEnd] = $this->buildDateRange($filterMode, $filterDate, $filterMonth, $filterYear, $dateStartCustom, $dateEndCustom, $monthStart, $monthEnd);

        // --- Base query ---
        $query = TransaksiKeuangan::with(['kategori', 'service', 'createdBy'])
            ->whereBetween('tanggal', [$dateStart, $dateEnd]);

        if ($filterTipe)    $query->where('tipe', $filterTipe);
        if ($filterService) $query->where('service_id', $filterService);
        if ($filterStatus)  $query->where('status', $filterStatus);
        if ($search)        $query->where(function ($q) use ($search) {
            $q->where('judul', 'like', "%{$search}%")
              ->orWhere('kode_transaksi', 'like', "%{$search}%")
              ->orWhere('keterangan', 'like', "%{$search}%");
        });

        $transaksis = (clone $query)->orderByDesc('tanggal')->orderByDesc('id')->paginate(20)->withQueryString();

        // --- Summary (only lunas for kas riil) ---
        $summaryAll = TransaksiKeuangan::whereBetween('tanggal', [$dateStart, $dateEnd]);
        if ($filterTipe)    (clone $summaryAll)->where('tipe', $filterTipe);
        if ($filterService) (clone $summaryAll)->where('service_id', $filterService);

        $summaryQ = DB::table('transaksi_keuangan')
            ->whereBetween('tanggal', [$dateStart, $dateEnd]);

        // apply same dimension filters for summary
        if ($filterTipe)    $summaryQ->where('tipe', $filterTipe);
        if ($filterService) $summaryQ->where('service_id', $filterService);

        $summaryData = $summaryQ->selectRaw("
            SUM(CASE WHEN tipe = 'pemasukan' AND status = 'lunas' THEN nominal ELSE 0 END) as total_pemasukan,
            SUM(CASE WHEN tipe = 'pengeluaran' AND status = 'lunas' THEN nominal ELSE 0 END) as total_pengeluaran,
            SUM(CASE WHEN tipe = 'pemasukan' AND status = 'pending' THEN nominal ELSE 0 END) as piutang,
            SUM(CASE WHEN tipe = 'pengeluaran' AND status = 'pending' THEN nominal ELSE 0 END) as tagihan_pending,
            COUNT(*) as total_transaksi
        ")->first();

        $totalPemasukan   = (float) ($summaryData->total_pemasukan ?? 0);
        $totalPengeluaran = (float) ($summaryData->total_pengeluaran ?? 0);
        $totalPiutangTrx  = (float) ($summaryData->piutang ?? 0);
        $totalTagihanPending = (float) ($summaryData->tagihan_pending ?? 0);

        // Piutang kontrak dari proyek klien aktif yang belum lunas
        $piutangProyek = (float) ProyekKlien::where('status', '!=', 'batal')->get()->sum(function ($p) {
            return $p->sisa_tagihan;
        });
        $totalPiutang = $totalPiutangTrx + $piutangProyek;
        $netSaldo         = $totalPemasukan - $totalPengeluaran;
        $totalTransaksi   = (int) ($summaryData->total_transaksi ?? 0);

        // --- Percentages ---
        $potensiPemasukan = $totalPemasukan + $totalPiutang;
        $totalPerputaran  = $totalPemasukan + $totalPengeluaran;

        $pctPemasukanLunas = $potensiPemasukan > 0 ? round(($totalPemasukan / $potensiPemasukan) * 100, 1) : 0;
        $pctArusMasuk      = $totalPerputaran > 0 ? round(($totalPemasukan / $totalPerputaran) * 100, 1) : 0;
        $pctRasioBeban     = $totalPemasukan > 0 ? round(($totalPengeluaran / $totalPemasukan) * 100, 1) : ($totalPengeluaran > 0 ? 100 : 0);
        $pctArusKeluar     = $totalPerputaran > 0 ? round(($totalPengeluaran / $totalPerputaran) * 100, 1) : 0;
        $pctMargin         = $totalPemasukan > 0 ? round(($netSaldo / $totalPemasukan) * 100, 1) : 0;
        $pctPiutang        = $potensiPemasukan > 0 ? round(($totalPiutang / $potensiPemasukan) * 100, 1) : 0;

        // --- Breakdown per program layanan (pemasukan lunas) ---
        $breakdownService = DB::table('transaksi_keuangan')
            ->leftJoin('proyek_klien', 'transaksi_keuangan.proyek_klien_id', '=', 'proyek_klien.id')
            ->join('service', DB::raw('COALESCE(transaksi_keuangan.service_id, proyek_klien.service_id)'), '=', 'service.id')
            ->whereBetween('transaksi_keuangan.tanggal', [$dateStart, $dateEnd])
            ->where('transaksi_keuangan.tipe', 'pemasukan')
            ->where('transaksi_keuangan.status', 'lunas')
            ->selectRaw('service.title as service_title, SUM(transaksi_keuangan.nominal) as total')
            ->groupBy('service.id', 'service.title')
            ->orderByDesc('total')
            ->get();

        // --- Breakdown per kategori (pengeluaran lunas) ---
        $breakdownKategori = DB::table('transaksi_keuangan')
            ->join('kategori_keuangan', 'transaksi_keuangan.kategori_id', '=', 'kategori_keuangan.id')
            ->whereBetween('transaksi_keuangan.tanggal', [$dateStart, $dateEnd])
            ->where('transaksi_keuangan.tipe', 'pengeluaran')
            ->where('transaksi_keuangan.status', 'lunas')
            ->selectRaw('kategori_keuangan.nama as kategori_nama, SUM(nominal) as total')
            ->groupBy('kategori_keuangan.id', 'kategori_keuangan.nama')
            ->orderByDesc('total')
            ->get();

        // --- Dropdown data ---
        $services  = Service::where('status', 'Show')->orderBy('title')->get(['id', 'title']);
        $kategoris = KategoriKeuangan::orderBy('tipe')->orderBy('nama')->get();

        return view('admin.keuangan.index', compact(
            'transaksis',
            'totalPemasukan', 'totalPengeluaran', 'netSaldo', 'totalTransaksi',
            'totalPiutang', 'totalTagihanPending', 'piutangProyek',
            'pctPemasukanLunas', 'pctArusMasuk', 'pctRasioBeban', 'pctArusKeluar', 'pctMargin', 'pctPiutang',
            'breakdownService', 'breakdownKategori',
            'services', 'kategoris',
            'filterMode', 'filterDate', 'dateStartCustom', 'dateEndCustom', 'filterMonth', 'monthStart', 'monthEnd', 'filterYear',
            'filterTipe', 'filterService', 'filterStatus', 'search',
            'dateStart', 'dateEnd'
        ));
    }

    // ─── Create ───────────────────────────────────────────────────────────────

    public function create()
    {
        $services     = Service::where('status', 'Show')->orderBy('title')->get(['id', 'title']);
        $kategoris    = KategoriKeuangan::orderBy('tipe')->orderBy('nama')->get();
        $proyekKliens = ProyekKlien::where('status', '!=', 'batal')->orderByDesc('id')->get(['id', 'nama_proyek', 'nama_klien']);

        return view('admin.keuangan.create', compact('services', 'kategoris', 'proyekKliens'));
    }

    // ─── Store ────────────────────────────────────────────────────────────────

    public function store(Request $request)
    {
        if ($request->has('tanggal') && preg_match('/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/', (string) $request->input('tanggal'), $m)) {
            $request->merge(['tanggal' => sprintf('%04d-%02d-%02d', $m[3], $m[2], $m[1])]);
        }
        if ($request->has('nominal')) {
            $rawNom = str_replace(['.', ','], ['', '.'], (string) $request->input('nominal'));
            $request->merge(['nominal' => $rawNom]);
        }
        if ($request->has('harga_satuan')) {
            $rawHs = str_replace(['.', ','], ['', '.'], (string) $request->input('harga_satuan'));
            $request->merge(['harga_satuan' => $rawHs]);
        }
        if ($request->has('status') && $request->input('status') === 'piutang') {
            $request->merge(['status' => 'pending']);
        }
        if ($request->filled('deskripsi')) {
            $request->merge(['judul' => \Illuminate\Support\Str::limit($request->input('deskripsi'), 250)]);
        } elseif ($request->filled('judul')) {
            $request->merge(['deskripsi' => $request->input('judul')]);
        } else {
            $fallback = $request->input('tipe') === 'pemasukan' ? 'Pemasukan Kas' : 'Pengeluaran Kas';
            $request->merge(['judul' => $fallback, 'deskripsi' => $fallback]);
        }

        $validated = $request->validate([
            'tanggal'          => 'required|date',
            'tipe'             => 'required|in:pemasukan,pengeluaran',
            'kategori_id'      => 'required|exists:kategori_keuangan,id',
            'service_id'       => 'nullable|exists:service,id',
            'proyek_klien_id'  => 'nullable|exists:proyek_klien,id',
            'deskripsi'        => 'required|string|max:1000',
            'judul'            => 'nullable|string|max:500',
            'satuan'           => 'nullable|string|max:50',
            'volume'           => 'nullable|numeric|min:0.01',
            'harga_satuan'     => 'nullable|numeric|min:0',
            'penerima'         => 'nullable|string|max:255',
            'nominal'          => 'required|numeric|min:0',
            'metode_pembayaran'=> 'nullable|in:Transfer Bank,Kas Tunai,Lainnya',
            'status'           => 'nullable|in:lunas,pending',
            'bukti'            => 'nullable|file|mimes:jpeg,png,jpg,webp,pdf|max:5120',
            'keterangan'       => 'nullable|string|max:2000',
        ]);

        $validated['metode_pembayaran'] = $validated['metode_pembayaran'] ?? 'Transfer Bank';
        $validated['status']            = $validated['status'] ?? 'lunas';
        $validated['volume']            = $validated['volume'] ?? 1;
        $validated['satuan']            = $validated['satuan'] ?? 'paket';
        $validated['keterangan']        = $validated['deskripsi'] ?? $request->input('keterangan');

        // Auto-inherit service_id dari proyek jika belum dipilih manual
        if (!empty($validated['proyek_klien_id']) && empty($validated['service_id'])) {
            $pk = ProyekKlien::find($validated['proyek_klien_id']);
            if ($pk && $pk->service_id) {
                $validated['service_id'] = $pk->service_id;
            }
        }

        if ($request->hasFile('bukti')) {
            $validated['bukti'] = $request->file('bukti')->store('keuangan/bukti', 'public');
        }

        $validated['kode_transaksi'] = TransaksiKeuangan::generateKode();
        $validated['created_by']     = Auth::id();

        // Validasi: kategori harus sesuai tipe
        $kategori = KategoriKeuangan::findOrFail($validated['kategori_id']);
        if ($kategori->tipe !== $validated['tipe']) {
            return back()->withInput()->with('error', 'Kategori tidak sesuai dengan tipe transaksi yang dipilih.');
        }

        TransaksiKeuangan::create($validated);

        if ($request->input('save_and_add') == '1' || $request->has('save_and_add')) {
            return redirect()->route('admin.keuangan.create', ['tipe' => $validated['tipe']])
                ->with('success', 'Transaksi berhasil disimpan (Kode: ' . $validated['kode_transaksi'] . '). Silakan tambahkan transaksi berikutnya.');
        }

        return redirect()->route('admin.keuangan.index')
            ->with('success', 'Transaksi berhasil disimpan. Kode: ' . $validated['kode_transaksi']);
    }

    // ─── Show ─────────────────────────────────────────────────────────────────

    public function show(TransaksiKeuangan $keuangan)
    {
        $keuangan->load(['kategori', 'service', 'proyekKlien', 'createdBy']);
        return view('admin.keuangan.show', compact('keuangan'));
    }

    // ─── Edit ─────────────────────────────────────────────────────────────────

    public function edit(TransaksiKeuangan $keuangan)
    {
        $services     = Service::where('status', 'Show')->orderBy('title')->get(['id', 'title']);
        $kategoris    = KategoriKeuangan::orderBy('tipe')->orderBy('nama')->get();
        $proyekKliens = ProyekKlien::where('status', '!=', 'batal')->orderByDesc('id')->get(['id', 'nama_proyek', 'nama_klien']);
        return view('admin.keuangan.edit', compact('keuangan', 'services', 'kategoris', 'proyekKliens'));
    }

    // ─── Update ───────────────────────────────────────────────────────────────

    public function update(Request $request, TransaksiKeuangan $keuangan)
    {
        if ($request->has('tanggal') && preg_match('/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/', (string) $request->input('tanggal'), $m)) {
            $request->merge(['tanggal' => sprintf('%04d-%02d-%02d', $m[3], $m[2], $m[1])]);
        }
        if ($request->has('nominal')) {
            $rawNom = str_replace(['.', ','], ['', '.'], (string) $request->input('nominal'));
            $request->merge(['nominal' => $rawNom]);
        }
        if ($request->has('harga_satuan')) {
            $rawHs = str_replace(['.', ','], ['', '.'], (string) $request->input('harga_satuan'));
            $request->merge(['harga_satuan' => $rawHs]);
        }
        if ($request->has('status') && $request->input('status') === 'piutang') {
            $request->merge(['status' => 'pending']);
        }
        if ($request->filled('deskripsi')) {
            $request->merge(['judul' => \Illuminate\Support\Str::limit($request->input('deskripsi'), 250)]);
        } elseif ($request->filled('judul')) {
            $request->merge(['deskripsi' => $request->input('judul')]);
        } else {
            $fallback = $request->input('tipe') === 'pemasukan' ? 'Pemasukan Kas' : 'Pengeluaran Kas';
            $request->merge(['judul' => $fallback, 'deskripsi' => $fallback]);
        }

        $validated = $request->validate([
            'tanggal'          => 'required|date',
            'tipe'             => 'required|in:pemasukan,pengeluaran',
            'kategori_id'      => 'required|exists:kategori_keuangan,id',
            'service_id'       => 'nullable|exists:service,id',
            'proyek_klien_id'  => 'nullable|exists:proyek_klien,id',
            'deskripsi'        => 'required|string|max:1000',
            'judul'            => 'nullable|string|max:500',
            'satuan'           => 'nullable|string|max:50',
            'volume'           => 'nullable|numeric|min:0.01',
            'harga_satuan'     => 'nullable|numeric|min:0',
            'penerima'         => 'nullable|string|max:255',
            'nominal'          => 'required|numeric|min:0',
            'metode_pembayaran'=> 'nullable|in:Transfer Bank,Kas Tunai,Lainnya',
            'status'           => 'nullable|in:lunas,pending',
            'bukti'            => 'nullable|file|mimes:jpeg,png,jpg,webp,pdf|max:5120',
            'keterangan'       => 'nullable|string|max:2000',
        ]);

        $validated['metode_pembayaran'] = $validated['metode_pembayaran'] ?? 'Transfer Bank';
        $validated['status']            = $validated['status'] ?? 'lunas';
        $validated['volume']            = $validated['volume'] ?? 1;
        $validated['satuan']            = $validated['satuan'] ?? 'paket';
        $validated['keterangan']        = $validated['deskripsi'] ?? $request->input('keterangan');

        // Auto-inherit service_id dari proyek jika belum dipilih manual
        if (!empty($validated['proyek_klien_id']) && empty($validated['service_id'])) {
            $pk = ProyekKlien::find($validated['proyek_klien_id']);
            if ($pk && $pk->service_id) {
                $validated['service_id'] = $pk->service_id;
            }
        }

        // Validasi tipe vs kategori
        $kategori = KategoriKeuangan::findOrFail($validated['kategori_id']);
        if ($kategori->tipe !== $validated['tipe']) {
            return back()->withInput()->with('error', 'Kategori tidak sesuai dengan tipe transaksi yang dipilih.');
        }

        if ($request->boolean('hapus_bukti')) {
            if ($keuangan->bukti && Storage::disk('public')->exists($keuangan->bukti)) {
                Storage::disk('public')->delete($keuangan->bukti);
            }
            $validated['bukti'] = null;
        }

        if ($request->hasFile('bukti')) {
            if ($keuangan->bukti && Storage::disk('public')->exists($keuangan->bukti)) {
                Storage::disk('public')->delete($keuangan->bukti);
            }
            $validated['bukti'] = $request->file('bukti')->store('keuangan/bukti', 'public');
        }

        $keuangan->update($validated);

        return redirect()->route('admin.keuangan.index')
            ->with('success', 'Transaksi berhasil diperbarui.');
    }

    // ─── Destroy ──────────────────────────────────────────────────────────────

    public function destroy(TransaksiKeuangan $keuangan)
    {
        if ($keuangan->bukti && Storage::disk('public')->exists($keuangan->bukti)) {
            Storage::disk('public')->delete($keuangan->bukti);
        }

        $keuangan->delete();

        return redirect()->route('admin.keuangan.index')
            ->with('success', 'Transaksi berhasil dihapus.');
    }

    // ─── Tandai Lunas (Quick Action) ─────────────────────────────────────────

    public function tandaiLunas(TransaksiKeuangan $keuangan)
    {
        $keuangan->update(['status' => 'lunas']);

        return back()->with('success', "Transaksi [{$keuangan->kode_transaksi}] berhasil ditandai Lunas.");
    }

    // ─── Cetak Invoice / Bukti Pembayaran ─────────────────────────────────────

    public function cetak(TransaksiKeuangan $keuangan)
    {
        $keuangan->load(['kategori', 'service', 'createdBy']);
        $pengaturan = \App\Models\Pengaturan::first();

        return view('admin.keuangan.cetak', compact('keuangan', 'pengaturan'));
    }

    // ─── Export Excel (.xls) ──────────────────────────────────────────────────

    public function exportExcel(Request $request)
    {
        $filterMode      = $request->input('filter_mode', 'bulanan');
        $filterDate      = $request->input('filter_date', now()->format('Y-m-d'));
        $dateStartCustom = $request->input('date_start', now()->startOfMonth()->format('Y-m-d'));
        $dateEndCustom   = $request->input('date_end', now()->format('Y-m-d'));
        $filterMonth     = $request->input('filter_month', now()->format('Y-m'));
        $monthStart      = $request->input('month_start', now()->format('Y-01'));
        $monthEnd        = $request->input('month_end', now()->format('Y-12'));
        $filterYear      = $request->input('filter_year', now()->year);
        $filterTipe      = $request->input('tipe', '');
        $filterService   = $request->input('service_id', '');
        $filterStatus    = $request->input('status', '');

        [$dateStart, $dateEnd] = $this->buildDateRange($filterMode, $filterDate, $filterMonth, $filterYear, $dateStartCustom, $dateEndCustom, $monthStart, $monthEnd);

        $query = TransaksiKeuangan::with(['kategori', 'service', 'createdBy'])
            ->whereBetween('tanggal', [$dateStart, $dateEnd])
            ->orderByDesc('tanggal')->orderByDesc('id');

        if ($filterTipe)    $query->where('tipe', $filterTipe);
        if ($filterService) $query->where('service_id', $filterService);
        if ($filterStatus)  $query->where('status', $filterStatus);

        $transaksis = $query->get();

        $filename = 'Laporan-Keuangan-' . $dateStart . '-sd-' . $dateEnd . '.xls';

        return response()->view('admin.keuangan.excel', [
            'transaksis' => $transaksis,
            'dateStart'  => $dateStart,
            'dateEnd'    => $dateEnd,
            'filterMode' => $filterMode,
            'pengaturan' => \App\Models\Pengaturan::first(),
        ], 200, [
            'Content-Type'        => 'application/vnd.ms-excel; charset=utf-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma'              => 'no-cache',
            'Expires'             => '0',
        ]);
    }

    // ─── Export PDF / Cetak Laporan ──────────────────────────────────────────

    public function exportPdf(Request $request)
    {
        $filterMode      = $request->input('filter_mode', 'bulanan');
        $filterDate      = $request->input('filter_date', now()->format('Y-m-d'));
        $dateStartCustom = $request->input('date_start', now()->startOfMonth()->format('Y-m-d'));
        $dateEndCustom   = $request->input('date_end', now()->format('Y-m-d'));
        $filterMonth     = $request->input('filter_month', now()->format('Y-m'));
        $monthStart      = $request->input('month_start', now()->format('Y-01'));
        $monthEnd        = $request->input('month_end', now()->format('Y-12'));
        $filterYear      = $request->input('filter_year', now()->year);
        $filterTipe      = $request->input('tipe', '');
        $filterService   = $request->input('service_id', '');
        $filterStatus    = $request->input('status', '');

        [$dateStart, $dateEnd] = $this->buildDateRange($filterMode, $filterDate, $filterMonth, $filterYear, $dateStartCustom, $dateEndCustom, $monthStart, $monthEnd);

        $query = TransaksiKeuangan::with(['kategori', 'service', 'proyekKlien', 'createdBy'])
            ->whereBetween('tanggal', [$dateStart, $dateEnd])
            ->orderBy('tanggal', 'asc')->orderBy('id', 'asc');

        if ($filterTipe)    $query->where('tipe', $filterTipe);
        if ($filterService) $query->where('service_id', $filterService);
        if ($filterStatus)  $query->where('status', $filterStatus);

        $transaksis = $query->get();

        $totalPemasukan   = (float) $transaksis->where('tipe', 'pemasukan')->where('status', 'lunas')->sum('nominal');
        $totalPengeluaran = (float) $transaksis->where('tipe', 'pengeluaran')->where('status', 'lunas')->sum('nominal');
        $totalPiutang     = (float) $transaksis->where('tipe', 'pemasukan')->where('status', 'pending')->sum('nominal');
        $selisih          = $totalPemasukan - $totalPengeluaran;

        return view('admin.keuangan.laporan-cetak', [
            'transaksis'       => $transaksis,
            'dateStart'        => $dateStart,
            'dateEnd'          => $dateEnd,
            'filterMode'       => $filterMode,
            'totalPemasukan'   => $totalPemasukan,
            'totalPengeluaran' => $totalPengeluaran,
            'totalPiutang'     => $totalPiutang,
            'selisih'          => $selisih,
            'pengaturan'       => \App\Models\Pengaturan::first(),
        ]);
    }

    // ─── Export CSV ───────────────────────────────────────────────────────────

    public function export(Request $request)
    {
        $filterMode      = $request->input('filter_mode', 'bulanan');
        $filterDate      = $request->input('filter_date', now()->format('Y-m-d'));
        $dateStartCustom = $request->input('date_start', now()->startOfMonth()->format('Y-m-d'));
        $dateEndCustom   = $request->input('date_end', now()->format('Y-m-d'));
        $filterMonth     = $request->input('filter_month', now()->format('Y-m'));
        $monthStart      = $request->input('month_start', now()->format('Y-01'));
        $monthEnd        = $request->input('month_end', now()->format('Y-12'));
        $filterYear      = $request->input('filter_year', now()->year);
        $filterTipe      = $request->input('tipe', '');
        $filterService   = $request->input('service_id', '');
        $filterStatus    = $request->input('status', '');

        [$dateStart, $dateEnd] = $this->buildDateRange($filterMode, $filterDate, $filterMonth, $filterYear, $dateStartCustom, $dateEndCustom, $monthStart, $monthEnd);

        $query = TransaksiKeuangan::with(['kategori', 'service', 'createdBy'])
            ->whereBetween('tanggal', [$dateStart, $dateEnd])
            ->orderByDesc('tanggal')->orderByDesc('id');

        if ($filterTipe)    $query->where('tipe', $filterTipe);
        if ($filterService) $query->where('service_id', $filterService);
        if ($filterStatus)  $query->where('status', $filterStatus);

        $transaksis = $query->get();

        $filename = 'laporan-keuangan-' . $dateStart . '-sd-' . $dateEnd . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($transaksis, $dateStart, $dateEnd) {
            $handle = fopen('php://output', 'w');

            // BOM for Excel UTF-8
            fputs($handle, "\xEF\xBB\xBF");
            // Excel delimiter hint
            fputs($handle, "sep=;\r\n");

            // Column headers
            fputcsv($handle, [
                'No',
                'Kode Transaksi',
                'Tanggal',
                'Tipe',
                'Kategori',
                'Program/Layanan',
                'Judul / Uraian Transaksi',
                'Penerima / Vendor',
                'Nominal (Rp)',
                'Metode Pembayaran',
                'Status',
                'Keterangan',
            ], ';');

            $no = 1;
            $totalPemasukan = 0;
            $totalPengeluaran = 0;

            foreach ($transaksis as $t) {
                fputcsv($handle, [
                    $no++,
                    $t->kode_transaksi,
                    $t->tanggal->format('d/m/Y'),
                    ucfirst($t->tipe),
                    $t->kategori?->nama ?? '-',
                    $t->service?->title ?? '-',
                    $t->judul,
                    $t->penerima ?? '-',
                    number_format($t->nominal, 0, ',', '.'),
                    $t->metode_pembayaran,
                    $t->status === 'lunas' ? 'Lunas' : 'Menunggu Pembayaran',
                    $t->keterangan ?? '-',
                ], ';');

                if ($t->status === 'lunas') {
                    if ($t->tipe === 'pemasukan') $totalPemasukan += $t->nominal;
                    else $totalPengeluaran += $t->nominal;
                }
            }

            // Summary rows
            fputcsv($handle, [], ';');
            fputcsv($handle, ['RINGKASAN (Transaksi Lunas)'], ';');
            fputcsv($handle, ['Total Pemasukan (Kas Riil):', '', '', '', '', '', '', '', 'Rp ' . number_format($totalPemasukan, 0, ',', '.')], ';');
            fputcsv($handle, ['Total Pengeluaran (Kas Riil):', '', '', '', '', '', '', '', 'Rp ' . number_format($totalPengeluaran, 0, ',', '.')], ';');
            fputcsv($handle, ['Saldo Bersih:', '', '', '', '', '', '', '', 'Rp ' . number_format($totalPemasukan - $totalPengeluaran, 0, ',', '.')], ';');

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    // ─── Helpers ─────────────────────────────────────────────────────────────

    private function buildDateRange(string $mode, string $date, string $month, $year, ?string $dateStartCustom = null, ?string $dateEndCustom = null, ?string $monthStart = null, ?string $monthEnd = null): array
    {
        return match ($mode) {
            'harian'      => [$date, $date],
            'range_hari'  => [
                $dateStartCustom ?: $date,
                $dateEndCustom ?: $date,
            ],
            'range_bulan' => [
                $monthStart ? \Carbon\Carbon::parse($monthStart . '-01')->startOfMonth()->format('Y-m-d') : \Carbon\Carbon::parse($month . '-01')->startOfMonth()->format('Y-m-d'),
                $monthEnd   ? \Carbon\Carbon::parse($monthEnd . '-01')->endOfMonth()->format('Y-m-d') : \Carbon\Carbon::parse($month . '-01')->endOfMonth()->format('Y-m-d'),
            ],
            'tahunan'     => ["{$year}-01-01", "{$year}-12-31"],
            'semua'       => ['2000-01-01', '2099-12-31'],
            default       => [ // bulanan
                \Carbon\Carbon::parse($month . '-01')->startOfMonth()->format('Y-m-d'),
                \Carbon\Carbon::parse($month . '-01')->endOfMonth()->format('Y-m-d'),
            ],
        };
    }
}

