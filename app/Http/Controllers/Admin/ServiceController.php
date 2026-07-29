<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Service::query();

        if ($search = $request->input('search')) {
            $query->where('title', 'like', "%{$search}%");
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $services = $query->orderBy('id')->paginate(15)->withQueryString();

        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'   => 'required|string|max:500',
            'short'   => 'nullable|string',
            'content' => 'nullable|string',
            'icon'    => 'nullable|string|max:255',
            'img'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status'  => 'required|in:Show,Hide',
            'slug'    => 'nullable|string|max:255',
            'url'     => 'nullable|string|max:500',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        if ($request->hasFile('img')) {
            $validated['img'] = $request->file('img')->store('services', 'public');
        }

        Service::create($validated);

        return redirect()->route('admin.services.index')->with('success', 'Program berhasil ditambahkan.');
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'title'   => 'required|string|max:500',
            'short'   => 'nullable|string',
            'content' => 'nullable|string',
            'icon'    => 'nullable|string|max:255',
            'img'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status'  => 'required|in:Show,Hide',
            'slug'    => 'nullable|string|max:255',
            'url'     => 'nullable|string|max:500',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        if ($request->input('remove_img_img')) {
            if ($service->img && \Storage::disk('public')->exists($service->img)) {
                \Storage::disk('public')->delete($service->img);
            }
            $validated['img'] = null;
        }

        if ($request->hasFile('img')) {
            if ($service->img && \Storage::disk('public')->exists($service->img)) {
                \Storage::disk('public')->delete($service->img);
            }
            $validated['img'] = $request->file('img')->store('services', 'public');
        }

        $service->update($validated);

        return redirect()->route('admin.services.index')->with('success', 'Program berhasil diupdate.');
    }

    public function destroy(Service $service)
    {
        if ($service->img && \Storage::disk('public')->exists($service->img)) {
            \Storage::disk('public')->delete($service->img);
        }

        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'Program berhasil dihapus.');
    }
}
