<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProyekKlien;
use App\Models\TransaksiKeuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KeuanganProgramController extends Controller
{
    public function index(Request $request)
    {
        $tahun           = $request->input('tahun', now()->year);
        $bulan           = $request->input('bulan', '');
        $search          = $request->input('search', '');
        $kontrakSearch   = $request->input('kontrak_search', '');
        $kontrakStatus   = $request->input('kontrak_status', '');
        $kontrakService  = $request->input('kontrak_service', '');

        // Daftar tahun tersedia (dari transaksi_keuangan)
        $tahunList = DB::table('transaksi_keuangan')
            ->selectRaw('YEAR(tanggal) as tahun')
            ->groupBy('tahun')
            ->orderByDesc('tahun')
            ->pluck('tahun');

        if ($tahunList->isEmpty()) {
            $tahunList = collect([now()->year]);
        }

        // Ambil semua service (program layanan)
        $services = DB::table('service')
            ->where('status', 'Show')
            ->when($search, fn($q) => $q->where('title', 'like', "%{$search}%"))
            ->orderBy('title')
            ->get();

        // Fungsi bantu: hitung agregat transaksi per service_id
        $aggregate = function (int $serviceId) use ($tahun, $bulan) {
            $base = DB::table('transaksi_keuangan')
                ->where(function ($q) use ($serviceId) {
                    $q->where('service_id', $serviceId)
                      ->orWhereIn('proyek_klien_id', function ($sub) use ($serviceId) {
                          $sub->select('id')->from('proyek_klien')->where('service_id', $serviceId);
                      });
                })
                ->whereYear('tanggal', $tahun);

            if ($bulan) {
                $base = $base->whereMonth('tanggal', $bulan);
            }

            $pemasukan = (clone $base)
                ->where('tipe', 'pemasukan')
                ->where('status', 'lunas')
                ->sum('nominal');

            $pengeluaran = (clone $base)
                ->where('tipe', 'pengeluaran')
                ->where('status', 'lunas')
                ->sum('nominal');

            $piutangTrx = (clone $base)
                ->where('tipe', 'pemasukan')
                ->where('status', 'pending')
                ->sum('nominal');

            // Piutang sisa kontrak proyek klien untuk program layanan ini
            $proyeksInService = ProyekKlien::where('service_id', $serviceId)
                ->where('status', '!=', 'batal')
                ->get();
            $piutangProyek = (float) $proyeksInService->sum('sisa_tagihan');

            $piutang = $piutangTrx + $piutangProyek;

            $jumlahTransaksi = (clone $base)->count();

            $margin    = $pemasukan - $pengeluaran;
            $marginPct = $pemasukan > 0 ? round(($margin / $pemasukan) * 100, 1) : 0;
            $rasioBeban = $pemasukan > 0 ? round(($pengeluaran / $pemasukan) * 100, 1) : 0;

            // Jumlah kontrak klien aktif di bawah program ini
            $kontrakAktif = ProyekKlien::where('service_id', $serviceId)
                ->where('status', 'berjalan')
                ->count();
            $kontrakTotal = ProyekKlien::where('service_id', $serviceId)->count();

            return compact('pemasukan', 'pengeluaran', 'piutang', 'margin', 'marginPct', 'rasioBeban', 'jumlahTransaksi', 'kontrakAktif', 'kontrakTotal');
        };

        // Gabungkan service dengan data keuangan
        $programData = $services->map(function ($svc) use ($aggregate) {
            $fin = $aggregate($svc->id);
            return (object) array_merge((array) $svc, $fin);
        });

        // ─── Query Kontrak Klien ─────────────────────────────────────────────
        $kontrakQuery = ProyekKlien::with('service');

        if ($kontrakSearch) {
            $kontrakQuery->where(function ($q) use ($kontrakSearch) {
                $q->where('nama_proyek', 'like', "%{$kontrakSearch}%")
                  ->orWhere('nama_klien', 'like', "%{$kontrakSearch}%")
                  ->orWhere('kode_proyek', 'like', "%{$kontrakSearch}%");
            });
        }

        if ($kontrakService) {
            $kontrakQuery->where('service_id', $kontrakService);
        }

        if ($kontrakStatus === 'piutang') {
            $kontraks = $kontrakQuery->orderByDesc('tanggal_mulai')->orderByDesc('id')->get()->filter(function ($k) {
                return $k->sisa_tagihan > 0;
            });
        } elseif ($kontrakStatus === 'lunas') {
            $kontraks = $kontrakQuery->orderByDesc('tanggal_mulai')->orderByDesc('id')->get()->filter(function ($k) {
                return $k->sisa_tagihan <= 0 && $k->nilai_kontrak > 0;
            });
        } else {
            if ($kontrakStatus) {
                $kontrakQuery->where('status', $kontrakStatus);
            }
            $kontraks = $kontrakQuery->orderByDesc('tanggal_mulai')->orderByDesc('id')->get();
        }

        // Agregasi Kontrak Klien Keseluruhan
        $allKontraks = ProyekKlien::all();
        $totalNilaiKontrak = $allKontraks->where('status', '!=', 'batal')->sum('nilai_kontrak');

        $totalPemasukanKontrak = (float) TransaksiKeuangan::whereNotNull('proyek_klien_id')
            ->where('tipe', 'pemasukan')
            ->where('status', 'lunas')
            ->sum('nominal');

        $totalPengeluaranKontrak = (float) TransaksiKeuangan::whereNotNull('proyek_klien_id')
            ->where('tipe', 'pengeluaran')
            ->where('status', 'lunas')
            ->sum('nominal');

        $totalSisaPiutangKontrak = max(0, $totalNilaiKontrak - $totalPemasukanKontrak);
        $totalLabaKontrak        = $totalPemasukanKontrak - $totalPengeluaranKontrak;

        // Total keseluruhan Program
        $totalPemasukan   = $programData->sum('pemasukan');
        $totalPengeluaran = $programData->sum('pengeluaran');
        $totalPiutang     = $programData->sum('piutang');
        $totalMargin      = $totalPemasukan - $totalPengeluaran;
        $totalMarginPct   = $totalPemasukan > 0
            ? round(($totalMargin / $totalPemasukan) * 100, 1) : 0;

        return view('admin.keuangan.program.index', compact(
            'programData', 'tahun', 'bulan', 'search',
            'tahunList', 'services',
            'totalPemasukan', 'totalPengeluaran', 'totalPiutang',
            'totalMargin', 'totalMarginPct',
            // Kontrak Klien data
            'kontraks', 'kontrakSearch', 'kontrakStatus', 'kontrakService',
            'totalNilaiKontrak', 'totalPemasukanKontrak', 'totalPengeluaranKontrak',
            'totalSisaPiutangKontrak', 'totalLabaKontrak'
        ));
    }
}
