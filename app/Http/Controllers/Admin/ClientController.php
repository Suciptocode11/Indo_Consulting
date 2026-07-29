<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $query = Client::query();

        if ($search = $request->input('search')) {
            $query->where('title', 'like', "%{$search}%");
        }

        $clients = $query->orderByDesc('id')->paginate(15)->withQueryString();

        return view('admin.clients.index', compact('clients'));
    }

    public function create()
    {
        return view('admin.clients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'  => 'required|string|max:255',
            'sector' => 'nullable|string|max:255',
            'img'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status' => 'required|in:Show,Hide',
            'url'    => 'nullable|string|max:500',
        ]);

        if ($request->hasFile('img')) {
            $validated['img'] = $request->file('img')->store('clients', 'public');
        }

        Client::create($validated);

        return redirect()->route('admin.clients.index')->with('success', 'Klien berhasil ditambahkan.');
    }

    public function edit(Client $client)
    {
        return view('admin.clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'title'  => 'required|string|max:255',
            'sector' => 'nullable|string|max:255',
            'img'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status' => 'required|in:Show,Hide',
            'url'    => 'nullable|string|max:500',
        ]);

        if ($request->hasFile('img')) {
            if ($client->img && \Storage::disk('public')->exists($client->img)) {
                \Storage::disk('public')->delete($client->img);
            }
            $validated['img'] = $request->file('img')->store('clients', 'public');
        }

        $client->update($validated);

        return redirect()->route('admin.clients.index')->with('success', 'Klien berhasil diupdate.');
    }

    public function destroy(Client $client)
    {
        if ($client->img && \Storage::disk('public')->exists($client->img)) {
            \Storage::disk('public')->delete($client->img);
        }

        $client->delete();

        return redirect()->route('admin.clients.index')->with('success', 'Klien berhasil dihapus.');
    }
}
