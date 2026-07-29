@extends('admin.layouts.app')

@section('title', 'Berita/Acara')
@section('page-title', 'Berita & Acara')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <form method="GET" style="display: flex; gap: 8px;">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari berita..." style="padding: 8px 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-family: 'Outfit', sans-serif; font-size: 13px; width: 220px;">
        <select name="status" style="padding: 8px 12px; border: 1px solid #e2e8f0; border-radius: 8px; font-family: 'Outfit', sans-serif; font-size: 13px;">
            <option value="">Semua Status</option>
            <option value="Show" {{ request('status') === 'Show' ? 'selected' : '' }}>Show</option>
            <option value="Hide" {{ request('status') === 'Hide' ? 'selected' : '' }}>Hide</option>
        </select>
        <button type="submit" class="btn btn-secondary btn-sm">Filter</button>
    </form>
    <a href="{{ route('admin.blog.create') }}" class="btn btn-primary">
        <span class="material-symbols-outlined">add</span> Tambah Baru
    </a>
</div>

<div class="card" style="padding: 0; overflow: hidden;">
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 50px;">ID</th>
                <th>Judul</th>
                <th>Tanggal</th>
                <th>Kategori</th>
                <th>Views</th>
                <th>Status</th>
                <th style="width: 150px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($blogs as $blog)
            <tr>
                <td>{{ $blog->id }}</td>
                <td><strong>{{ $blog->title }}</strong></td>
                <td>{{ $blog->date ?? '-' }}</td>
                <td>{{ $blog->kategori->title ?? '-' }}</td>
                <td>{{ $blog->hit ?? 0 }}</td>
                <td>
                    <span class="badge {{ $blog->status === 'Show' ? 'badge-success' : 'badge-danger' }}">{{ $blog->status }}</span>
                </td>
                <td>
                    <div style="display: flex; gap: 6px;">
                        <a href="{{ route('admin.blog.edit', $blog) }}" class="btn btn-secondary btn-sm">
                            <span class="material-symbols-outlined">edit</span>
                        </a>
                        <form method="POST" action="{{ route('admin.blog.destroy', $blog) }}" onsubmit="return confirm('Yakin hapus?')">
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
                <td colspan="7" style="text-align: center; padding: 40px; color: #94a3b8;">Belum ada data berita.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top: 16px;">{{ $blogs->links() }}</div>
@endsection
