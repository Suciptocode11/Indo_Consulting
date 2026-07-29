<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $query = Member::query();

        if ($search = $request->input('search')) {
            $query->where('nama', 'like', "%{$search}%");
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $members = $query->orderByDesc('id')->paginate(15)->withQueryString();

        return view('admin.members.index', compact('members'));
    }

    public function create()
    {
        return view('admin.members.create');
    }

    public function show(Member $member)
    {
        return view('admin.members.show', compact('member'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'        => 'required|string|max:255',
            'wa'          => 'nullable|string|max:255',
            'email'       => 'nullable|email|max:255',
            'instagram'   => 'nullable|string|max:500',
            'twitter'     => 'nullable|string|max:500',
            'facebook'    => 'nullable|string|max:500',
            'youtube'     => 'nullable|string|max:500',
            'situs'       => 'nullable|string|max:500',
            'linkedin'    => 'nullable|string|max:500',
            'alamat'      => 'nullable|string',
            'pendidikan'  => 'nullable|string|max:255',
            'keahlian'    => 'nullable|string',
            'penunjang'   => 'nullable|string',
            'pengalaman'  => 'nullable|string',
            'jabatan'     => 'nullable|string|max:255',
            'profil'      => 'nullable|string',
            'foto'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'cv'          => 'nullable|file|mimes:pdf|max:5120',
            'status'      => 'required|in:Show,Hide',
            'slug'        => 'nullable|string|max:255',
            'id_group'    => 'nullable|string|max:50',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['nama']);
        }

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('members/photos', 'public');
        }

        if ($request->hasFile('cv')) {
            $validated['cv'] = $request->file('cv')->store('members/cv', 'public');
        }

        Member::create($validated);

        return redirect()->route('admin.members.index')->with('success', 'Member berhasil ditambahkan.');
    }

    public function edit(Member $member)
    {
        return view('admin.members.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'nama'        => 'required|string|max:255',
            'wa'          => 'nullable|string|max:255',
            'email'       => 'nullable|email|max:255',
            'instagram'   => 'nullable|string|max:500',
            'twitter'     => 'nullable|string|max:500',
            'facebook'    => 'nullable|string|max:500',
            'youtube'     => 'nullable|string|max:500',
            'situs'       => 'nullable|string|max:500',
            'linkedin'    => 'nullable|string|max:500',
            'alamat'      => 'nullable|string',
            'pendidikan'  => 'nullable|string|max:255',
            'keahlian'    => 'nullable|string',
            'penunjang'   => 'nullable|string',
            'pengalaman'  => 'nullable|string',
            'jabatan'     => 'nullable|string|max:255',
            'profil'      => 'nullable|string',
            'foto'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'cv'          => 'nullable|file|mimes:pdf|max:5120',
            'status'      => 'required|in:Show,Hide',
            'slug'        => 'nullable|string|max:255',
            'id_group'    => 'nullable|string|max:50',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['nama']);
        }

        if ($request->hasFile('foto')) {
            if ($member->foto && \Storage::disk('public')->exists($member->foto)) {
                \Storage::disk('public')->delete($member->foto);
            }
            $validated['foto'] = $request->file('foto')->store('members/photos', 'public');
        }

        if ($request->hasFile('cv')) {
            if ($member->cv && \Storage::disk('public')->exists($member->cv)) {
                \Storage::disk('public')->delete($member->cv);
            }
            $validated['cv'] = $request->file('cv')->store('members/cv', 'public');
        }

        $member->update($validated);

        return redirect()->route('admin.members.index')->with('success', 'Member berhasil diupdate.');
    }

    public function destroy(Member $member)
    {
        if ($member->foto && \Storage::disk('public')->exists($member->foto)) {
            \Storage::disk('public')->delete($member->foto);
        }

        if ($member->cv && \Storage::disk('public')->exists($member->cv)) {
            \Storage::disk('public')->delete($member->cv);
        }

        $member->delete();

        return redirect()->route('admin.members.index')->with('success', 'Member berhasil dihapus.');
    }
}
