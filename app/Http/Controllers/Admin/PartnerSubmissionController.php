<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PartnerSubmission;
use App\Models\Client;
use Illuminate\Http\Request;

class PartnerSubmissionController extends Controller
{
    public function index()
    {
        $submissions = PartnerSubmission::orderByDesc('id')->get();
        return view('admin.partner-submissions.index', compact('submissions'));
    }

    public function show(PartnerSubmission $submission)
    {
        return view('admin.partner-submissions.show', compact('submission'));
    }

    public function approve(PartnerSubmission $submission)
    {
        // Create client from submission
        Client::create([
            'title'  => $submission->company_name,
            'sector' => $submission->sector,
            'img'    => $submission->logo,
            'url'    => $submission->website,
            'status' => 'Show',
        ]);

        $submission->update(['status' => 'Approved']);

        return redirect()->route('admin.partner-submissions.index')
            ->with('success', 'Partner berhasil disetujui dan ditambahkan ke halaman Partners & Clients.');
    }

    public function reject(Request $request, PartnerSubmission $submission)
    {
        $validated = $request->validate([
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $submission->update([
            'status' => 'Rejected',
            'admin_notes' => $validated['admin_notes'] ?? null,
        ]);

        return redirect()->route('admin.partner-submissions.index')
            ->with('success', 'Pendaftaran partner ditolak.');
    }

    public function destroy(PartnerSubmission $submission)
    {
        if ($submission->logo && \Storage::disk('public')->exists($submission->logo)) {
            \Storage::disk('public')->delete($submission->logo);
        }

        $submission->delete();

        return redirect()->route('admin.partner-submissions.index')
            ->with('success', 'Pendaftaran dihapus.');
    }
}
