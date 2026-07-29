@extends('admin.layouts.app')

@section('title', 'Kategori Proyek')
@section('page-title', 'Kategori Proyek')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <form method="GET" style="display: flex; gap: 8px;">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kategori..." style="padding: 8px 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-family: 'Outfit', sans-serif; font-size: 13px; width: 220px;">
        <button type="submit" class="btn btn-secondary btn-sm">Filter</button>
    </form>
    <a href="{{ route('admin.kategori-project.create') }}" class="btn btn-primary">
        <span class="material-symbols-outlined">add</span> Tambah Baru
    </a>
</div>

<div class="card" style="padding: 0; overflow: hidden;">
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 50px;">ID</th>
                <th>Judul</th>
                <th>Slug</th>
                <th style="width: 150px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kategoris as $kategori)
            <tr>
                <td>{{ $kategori->id }}</td>
                <td><strong>{{ $kategori->title }}</strong></td>
                <td>{{ $kategori->slug }}</td>
                <td>
                    <div style="display: flex; gap: 6px;">
                        <a href="{{ route('admin.kategori-project.edit', $kategori) }}" class="btn btn-secondary btn-sm">
                            <span class="material-symbols-outlined">edit</span>
                        </a>
                        <form method="POST" action="{{ route('admin.kategori-project.destroy', $kategori) }}" onsubmit="return confirm('Yakin hapus? Proyek yang menggunakan kategori ini tidak akan terhapus.')">
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
                <td colspan="4" style="text-align: center; padding: 40px; color: #94a3b8;">Belum ada data kategori.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top: 16px;">{{ $kategoris->links() }}</div>
@endsection