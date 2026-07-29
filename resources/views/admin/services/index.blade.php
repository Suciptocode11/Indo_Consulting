@extends('admin.layouts.app')

@section('title', 'Program/Layanan')
@section('page-title', 'Program/Layanan')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <form method="GET" style="display: flex; gap: 8px;">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari program..." style="padding: 8px 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-family: 'Outfit', sans-serif; font-size: 13px; width: 220px;">
        <select name="status" style="padding: 8px 12px; border: 1px solid #e2e8f0; border-radius: 8px; font-family: 'Outfit', sans-serif; font-size: 13px;">
            <option value="">Semua Status</option>
            <option value="Show" {{ request('status') === 'Show' ? 'selected' : '' }}>Show</option>
            <option value="Hide" {{ request('status') === 'Hide' ? 'selected' : '' }}>Hide</option>
        </select>
        <button type="submit" class="btn btn-secondary btn-sm">Filter</button>
    </form>
    <a href="{{ route('admin.services.create') }}" class="btn btn-primary">
        <span class="material-symbols-outlined">add</span> Tambah Baru
    </a>
</div>

<div class="card" style="padding: 0; overflow: hidden;">
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 50px;">ID</th>
                <th>Judul</th>
                <th>Icon</th>
                <th>Status</th>
                <th style="width: 150px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($services as $service)
            <tr>
                <td>{{ $service->id }}</td>
                <td><strong>{{ $service->title }}</strong></td>
                <td><code style="font-size: 12px; background: #f1f5f9; padding: 2px 6px; border-radius: 4px;">{{ $service->icon }}</code></td>
                <td>
                    <span class="badge {{ $service->status === 'Show' ? 'badge-success' : 'badge-danger' }}">
                        {{ $service->status }}
                    </span>
                </td>
                <td>
                    <div style="display: flex; gap: 6px;">
                        <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-secondary btn-sm">
                            <span class="material-symbols-outlined">edit</span>
                        </a>
                        <form method="POST" action="{{ route('admin.services.destroy', $service) }}" onsubmit="return confirm('Yakin hapus?')">
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
                <td colspan="5" style="text-align: center; padding: 40px; color: #94a3b8;">Belum ada data program.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top: 16px;">
    {{ $services->links() }}
</div>
@endsection
