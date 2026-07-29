<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialMedia;
use Illuminate\Http\Request;

class SocialMediaController extends Controller
{
    public function index()
    {
        $socialMedia = SocialMedia::orderBy('urutan')->get();

        return view('admin.social-media.index', compact('socialMedia'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'social' => 'required|array',
            'social.*' => 'nullable|url|max:500',
        ]);

        $data = $validated['social'] ?? [];

        foreach ($data as $platform => $url) {
            SocialMedia::where('platform', $platform)->update(['url' => $url]);
        }

        return redirect()->route('admin.social-media.index')->with('success', 'Sosial media berhasil disimpan.');
    }
}
