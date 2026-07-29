<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaturan;
use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    public function edit()
    {
        $pengaturan = Pengaturan::firstOrCreate([], [
            'company' => 'Indo Consulting',
            'address' => 'Jl. Ganetri IV No.4, Tonja, Kec. Denpasar Utara, Kota Denpasar, Bali 80237',
            'phone' => '+62 878-653-0996',
            'email' => 'partner@indoconsulting.id',
            'website' => 'https://indoconsulting.id',
            'copyright' => '&copy; ' . date('Y') . ' Indo Consulting. Hak cipta dilindungi.',
        ]);

        return view('admin.pengaturan.edit', compact('pengaturan'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'company'   => 'nullable|string|max:255',
            'address'   => 'nullable|string|max:255',
            'phone'     => 'nullable|string|max:255',
            'email'     => 'nullable|email|max:255',
            'website'   => 'nullable|url|max:255',
            'map'       => 'nullable|string',
            'copyright' => 'nullable|string|max:255',
            'logo'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $pengaturan = Pengaturan::first();

        if ($request->hasFile('logo')) {
            // Hapus logo lama
            if ($pengaturan->logo && \Storage::disk('public')->exists($pengaturan->logo)) {
                \Storage::disk('public')->delete($pengaturan->logo);
            }
            $validated['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $pengaturan->update($validated);

        return redirect()->route('admin.pengaturan.edit')->with('success', 'Pengaturan berhasil disimpan.');
    }
}
