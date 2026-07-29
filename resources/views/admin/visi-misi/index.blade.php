@extends('admin.layouts.app')

@section('title', 'Visi & Misi')
@section('page-title', 'Visi & Misi')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <form method="GET" style="display: flex; gap: 8px;">
        <select name="type" style="padding: 8px 12px; border: 1px solid #e2e8f0; border-radius: 8px; font-family: 'Outfit', sans-serif; font-size: 13px;">
            <option value="">Semua</option>
            <option value="visi" {{ request('type') === 'visi' ? 'selected' : '' }}>Visi</option>
            <option value="misi" {{ request('type') === 'misi' ? 'selected' : '' }}>Misi</option>
        </select>
        <button type="submit" class="btn btn-secondary btn-sm">Filter</button>
    </form>
    <a href="{{ route('admin.visi-misi.create') }}" class="btn btn-primary">
        <span class="material-symbols-outlined">add</span> Tambah Baru
    </a>
</div>

<div class="card" style="padding: 0; overflow: hidden;">
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 50px;">ID</th>
                <th style="width: 80px;">Tipe</th>
                <th>Icon</th>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th style="width: 70px;">Urutan</th>
                <th>Status</th>
                <th style="width: 150px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($visiMisi as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>
                    <span class="badge {{ $item->type === 'visi' ? 'badge-info' : 'badge-warning' }}">{{ ucfirst($item->type) }}</span>
                </td>
                <td>
                    <span class="material-symbols-outlined" style="font-size: 22px; color: #020220;">{{ $item->icon }}</span>
                </td>
                <td><strong>{{ $item->title ?? '-' }}</strong></td>
                <td style="max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $item->description }}</td>
                <td style="text-align: center;">{{ $item->urutan }}</td>
                <td>
                    <span class="badge {{ $item->status === 'Show' ? 'badge-success' : 'badge-danger' }}">{{ $item->status }}</span>
                </td>
                <td>
                    <div style="display: flex; gap: 6px;">
                        <a href="{{ route('admin.visi-misi.edit', $item) }}" class="btn btn-secondary btn-sm">
                            <span class="material-symbols-outlined">edit</span>
                        </a>
                        <form method="POST" action="{{ route('admin.visi-misi.destroy', $item) }}" onsubmit="return confirm('Yakin hapus?')">
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
                <td colspan="8" style="text-align: center; padding: 40px; color: #94a3b8;">Belum ada data visi & misi.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top: 16px;">{{ $visiMisi->links() }}</div>
@endsection
