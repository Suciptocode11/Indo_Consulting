<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PendaftaranController extends Controller
{
    public function create()
    {
        $services = \App\Models\Service::where('status', 'Show')->get();
        return view('pages.karir', compact('services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'foto'             => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'nama'             => 'required|string|max:255',
            'email'            => 'required|email|max:255',
            'telepon'          => 'nullable|string|max:50',
            'tanggal_lahir'    => 'nullable|date',
            'jenis_kelamin'    => 'nullable|in:Laki-laki,Perempuan',
            'provinsi'         => 'nullable|string|max:100',
            'kode_provinsi'    => 'nullable|string|max:2',
            'alamat'           => 'nullable|string|max:1000',
            'daerah_asal'      => 'nullable|string|max:255',
            'pendidikan'       => 'nullable|string|max:100',
            'institusi'        => 'nullable|string|max:255',
            'pengalaman'       => 'nullable|string|max:100',
            'keahlian'         => 'nullable|string|max:500',
            'posisi'           => 'nullable|string|max:255',
            'surat_motivasi'   => 'nullable|string|max:2000',
            'cv'               => 'nullable|file|mimes:pdf|max:5120',
            'profil_singkat'   => 'nullable|string|max:500',
            'link_wa'          => 'nullable|string|max:50',
            'link_linkedin'    => 'nullable|string|max:255',
            'link_instagram'   => 'nullable|string|max:255',
            'link_facebook'    => 'nullable|string|max:255',
        ]);

        // Extract provinsi name from "kode|nama" format
        if (!empty($validated['provinsi']) && str_contains($validated['provinsi'], '|')) {
            $parts = explode('|', $validated['provinsi']);
            $validated['provinsi'] = $parts[1] ?? $parts[0];
        }

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('pendaftaran/foto', 'public');
        }

        if ($request->hasFile('cv')) {
            $validated['cv'] = $request->file('cv')->store('pendaftaran/cv', 'public');
        }

        $validated['status'] = 'Pending';

        Pendaftaran::create($validated);

        // Notify admin via email (non-blocking, silent fail)
        try {
            if (class_exists(\App\Mail\PendaftaranNotification::class)) {
                \Illuminate\Support\Facades\Mail::to('partner@indoconsulting.id')
                    ->send(new \App\Mail\PendaftaranNotification(
                        $validated['nama'] ?? 'Unknown',
                        $validated['email'] ?? '',
                        $validated['posisi'] ?? '-'
                    ));
            }
        } catch (\Exception $e) {
            // Log the error but don't block the user
            \Illuminate\Support\Facades\Log::error('Email notification failed: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Lamaran berhasil dikirim! Tim kami akan menghubungi Anda.');
    }
}
