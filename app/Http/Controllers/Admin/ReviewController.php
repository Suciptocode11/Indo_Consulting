<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::query();

        if ($search = $request->input('search')) {
            $query->where('nama', 'like', "%{$search}%");
        }

        $reviews = $query->orderByDesc('id')->paginate(15)->withQueryString();

        return view('admin.reviews.index', compact('reviews'));
    }

    public function create()
    {
        return view('admin.reviews.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'      => 'required|string|max:255',
            'review'    => 'required|string',
            'stars'     => 'nullable|string|max:10',
            'status'    => 'required|in:Show,Hide',
            'pekerjaan' => 'nullable|string|max:255',
        ]);

        Review::create($validated);

        return redirect()->route('admin.reviews.index')->with('success', 'Testimoni berhasil ditambahkan.');
    }

    public function edit(Review $review)
    {
        return view('admin.reviews.edit', compact('review'));
    }

    public function update(Request $request, Review $review)
    {
        $validated = $request->validate([
            'nama'      => 'required|string|max:255',
            'review'    => 'required|string',
            'stars'     => 'nullable|string|max:10',
            'status'    => 'required|in:Show,Hide',
            'pekerjaan' => 'nullable|string|max:255',
        ]);

        $review->update($validated);

        return redirect()->route('admin.reviews.index')->with('success', 'Testimoni berhasil diupdate.');
    }

    public function destroy(Review $review)
    {
        $review->delete();

        return redirect()->route('admin.reviews.index')->with('success', 'Testimoni berhasil dihapus.');
    }
}
