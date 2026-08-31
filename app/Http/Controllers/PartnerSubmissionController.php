<?php

namespace App\Http\Controllers;

use App\Models\PartnerSubmission;
use Illuminate\Http\Request;

class PartnerSubmissionController extends Controller
{
    public function create()
    {
        return view('pages.daftar-partner');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name'     => 'required|string|max:255',
            'sector'           => 'nullable|string|max:100',
            'pic_name'         => 'required|string|max:255',
            'pic_position'     => 'nullable|string|max:100',
            'email'            => 'required|email|max:255',
            'phone'            => 'nullable|string|max:50',
            'address'          => 'nullable|string|max:1000',
            'website'          => 'nullable|url|max:255',
            'logo'             => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'company_profile'  => 'nullable|string|max:2000',
            'reason'           => 'nullable|string|max:1000',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('partner-submissions', 'public');
        }

        $validated['status'] = 'Pending';

        PartnerSubmission::create($validated);

        return redirect()->back()->with('success', 'Pendaftaran berhasil dikirim! Tim kami akan meninjau dan menghubungi Anda.');
    }
}
