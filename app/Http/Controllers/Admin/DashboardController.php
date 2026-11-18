<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Blog;
use App\Models\Client;
use App\Models\Faq;
use App\Models\Member;
use App\Models\Pendaftaran;
use App\Models\PartnerSubmission;
use App\Models\Project;
use App\Models\ProyekKlien;
use App\Models\Review;
use App\Models\Service;
use App\Models\TransaksiKeuangan;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1. ROLE FINANCE: Tidak memiliki dashboard, langsung ke modul Keuangan
        if ($user->isFinance()) {
            return redirect()->route('admin.keuangan.index');
        }

        // 2. DASHBOARD KHUSUS ADMIN (KONTEN & OPERASIONAL — TANPA KEUANGAN)
        if ($user->isAdmin()) {
            return $this->dashboardAdmin();
        }

        // 3. DASHBOARD SUPER ADMIN (SEMUA MODUL: KONTEN, LEADS, & KEUANGAN)
        return $this->dashboardSuperAdmin();
    }

    /**
     * Dashboard untuk Super Admin (Executive Summary)
     */
    protected function dashboardSuperAdmin()
    {
        // Data Keuangan
        $totalNilaiKontrak = (float) ProyekKlien::where('status', '!=', 'batal')->sum('nilai_kontrak');
        $totalPemasukan    = (float) TransaksiKeuangan::where('tipe', 'pemasukan')->where('status', 'lunas')->sum('nominal');
        $totalPengeluaran  = (float) TransaksiKeuangan::where('tipe', 'pengeluaran')->where('status', 'lunas')->sum('nominal');
        
        $piutangKas     = (float) TransaksiKeuangan::where('tipe', 'pemasukan')->where('status', 'pending')->sum('nominal');
        $piutangProyek  = (float) ProyekKlien::where('status', '!=', 'batal')->get()->sum('sisa_tagihan');
        $totalPiutang   = $piutangKas + $piutangProyek;
        $totalSelisih   = $totalPemasukan - $totalPengeluaran;

        // Data Konten & Leads
        $stats = [
            'pendaftaran_pending' => Pendaftaran::where('status', 'pending')->count(),
            'partner_pending'     => PartnerSubmission::where('status', 'pending')->count(),
            'services'            => Service::count(),
            'projects'            => Project::count(),
            'blogs'               => Blog::count(),
            'clients'             => Client::count(),
            'members'             => Member::count(),
            'kontrak_aktif'       => ProyekKlien::where('status', 'berjalan')->count(),
        ];

        // Aktivitas Terkini
        $recentTransaksi   = TransaksiKeuangan::with(['kategori', 'proyekKlien'])->orderByDesc('tanggal')->orderByDesc('id')->take(5)->get();
        $recentPendaftaran = Pendaftaran::orderByDesc('created_at')->take(5)->get();

        return view('admin.dashboard.super-admin', compact(
            'totalNilaiKontrak', 'totalPemasukan', 'totalPengeluaran',
            'totalPiutang', 'totalSelisih', 'stats',
            'recentTransaksi', 'recentPendaftaran'
        ));
    }

    /**
     * Dashboard untuk Admin (Konten Website & Leads — Tanpa Keuangan)
     */
    protected function dashboardAdmin()
    {
        $stats = [
            'pendaftaran_pending' => Pendaftaran::where('status', 'pending')->count(),
            'pendaftaran_total'   => Pendaftaran::count(),
            'partner_pending'     => PartnerSubmission::where('status', 'pending')->count(),
            'partner_total'       => PartnerSubmission::count(),
            'services'            => Service::count(),
            'projects'            => Project::count(),
            'blogs'               => Blog::count(),
            'clients'             => Client::count(),
            'members'             => Member::count(),
            'reviews'             => Review::count(),
            'faqs'                => Faq::count(),
            'albums'              => Album::count(),
        ];

        // Leads & Pendaftaran Terbaru
        $recentPendaftaran = Pendaftaran::orderByDesc('created_at')->take(6)->get();
        $recentPartners    = PartnerSubmission::orderByDesc('created_at')->take(6)->get();

        return view('admin.dashboard.admin', compact('stats', 'recentPendaftaran', 'recentPartners'));
    }
}
