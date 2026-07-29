@extends('admin.layouts.app')

@section('title', 'Testimoni')
@section('page-title', 'Testimoni')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <form method="GET" style="display: flex; gap: 8px;">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama..." style="padding: 8px 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-family: 'Outfit', sans-serif; font-size: 13px; width: 220px;">
        <button type="submit" class="btn btn-secondary btn-sm">Filter</button>
    </form>
    <a href="{{ route('admin.reviews.create') }}" class="btn btn-primary">
        <span class="material-symbols-outlined">add</span> Tambah Baru
    </a>
</div>

<div class="card" style="padding: 0; overflow: hidden;">
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 50px;">ID</th>
                <th>Nama</th>
                <th>Pekerjaan</th>
                <th>Bintang</th>
                <th>Status</th>
                <th style="width: 150px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reviews as $review)
            <tr>
                <td>{{ $review->id }}</td>
                <td><strong>{{ $review->nama }}</strong></td>
                <td>{{ $review->pekerjaan ?? '-' }}</td>
                <td>{{ $review->stars ? str_repeat('⭐', (int) $review->stars) : '-' }}</td>
                <td>
                    <span class="badge {{ $review->status === 'Show' ? 'badge-success' : 'badge-danger' }}">{{ $review->status }}</span>
                </td>
                <td>
                    <div style="display: flex; gap: 6px;">
                        <a href="{{ route('admin.reviews.edit', $review) }}" class="btn btn-secondary btn-sm">
                            <span class="material-symbols-outlined">edit</span>
                        </a>
                        <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}" onsubmit="return confirm('Yakin hapus?')">
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
                <td colspan="6" style="text-align: center; padding: 40px; color: #94a3b8;">Belum ada data testimoni.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top: 16px;">{{ $reviews->links() }}</div>
@endsection
