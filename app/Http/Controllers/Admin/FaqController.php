<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index(Request $request)
    {
        $query = Faq::query();

        if ($search = $request->input('search')) {
            $query->where('question', 'like', "%{$search}%");
        }

        $faqs = $query->orderBy('urutan')->orderBy('id')->paginate(15)->withQueryString();

        return view('admin.faqs.index', compact('faqs'));
    }

    public function create()
    {
        return view('admin.faqs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'question' => 'required|string|max:500',
            'answer'   => 'required|string',
            'urutan'   => 'nullable|integer',
            'status'   => 'required|in:Show,Hide',
        ]);

        Faq::create($validated);

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ berhasil ditambahkan.');
    }

    public function edit(Faq $faq)
    {
        return view('admin.faqs.edit', compact('faq'));
    }

    public function update(Request $request, Faq $faq)
    {
        $validated = $request->validate([
            'question' => 'required|string|max:500',
            'answer'   => 'required|string',
            'urutan'   => 'nullable|integer',
            'status'   => 'required|in:Show,Hide',
        ]);

        $faq->update($validated);

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ berhasil diupdate.');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ berhasil dihapus.');
    }
}
