@extends('admin.layouts.app')

@section('title', 'FAQ')
@section('page-title', 'FAQ (Pertanyaan Umum)')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <form method="GET" style="display: flex; gap: 8px;">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari pertanyaan..." style="padding: 8px 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-family: 'Outfit', sans-serif; font-size: 13px; width: 240px;">
        <button type="submit" class="btn btn-secondary btn-sm">Filter</button>
    </form>
    <a href="{{ route('admin.faqs.create') }}" class="btn btn-primary">
        <span class="material-symbols-outlined">add</span> Tambah Baru
    </a>
</div>

<div class="card" style="padding: 0; overflow: hidden;">
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 50px;">ID</th>
                <th>Pertanyaan</th>
                <th style="width: 80px;">Urutan</th>
                <th>Status</th>
                <th style="width: 150px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($faqs as $faq)
            <tr>
                <td>{{ $faq->id }}</td>
                <td><strong>{{ $faq->question }}</strong></td>
                <td style="text-align: center;">{{ $faq->urutan }}</td>
                <td>
                    <span class="badge {{ $faq->status === 'Show' ? 'badge-success' : 'badge-danger' }}">{{ $faq->status }}</span>
                </td>
                <td>
                    <div style="display: flex; gap: 6px;">
                        <a href="{{ route('admin.faqs.edit', $faq) }}" class="btn btn-secondary btn-sm">
                            <span class="material-symbols-outlined">edit</span>
                        </a>
                        <form method="POST" action="{{ route('admin.faqs.destroy', $faq) }}" onsubmit="return confirm('Yakin hapus?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <span class="material-symbols-outlined">delete</span>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; padding: 40px; color: #94a3b8;">Belum ada data FAQ.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top: 16px;">{{ $faqs->links() }}</div>
@endsection
