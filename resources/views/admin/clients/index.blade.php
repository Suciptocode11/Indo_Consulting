@extends('admin.layouts.app')

@section('title', 'Mitra/Klien')
@section('page-title', 'Mitra/Klien')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <form method="GET" style="display: flex; gap: 8px;">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari klien..." style="padding: 8px 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-family: 'Outfit', sans-serif; font-size: 13px; width: 220px;">
        <button type="submit" class="btn btn-secondary btn-sm">Filter</button>
    </form>
    <a href="{{ route('admin.clients.create') }}" class="btn btn-primary">
        <span class="material-symbols-outlined">add</span> Tambah Baru
    </a>
</div>

<div class="card" style="padding: 0; overflow: hidden;">
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 50px;">ID</th>
                <th>Nama</th>
                <th>Sektor</th>
                <th>URL</th>
                <th>Status</th>
                <th style="width: 150px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($clients as $client)
            <tr>
                <td>{{ $client->id }}</td>
                <td>
                    <div style="display: flex; align-items: center; gap: 10px;">
                        @if($client->img)
                            <img src="{{ asset('storage/' . $client->img) }}" style="width: 36px; height: 36px; border-radius: 6px; object-fit: cover;">
                        @endif
                        <strong>{{ $client->title }}</strong>
                    </div>
                </td>
                <td><span class="badge badge-info">{{ $client->sector ?? '-' }}</span></td>
                <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                    {{ $client->url ?? '-' }}
                </td>
                <td>
                    <span class="badge {{ $client->status === 'Show' ? 'badge-success' : 'badge-danger' }}">{{ $client->status }}</span>
                </td>
                <td>
                    <div style="display: flex; gap: 6px;">
                        <a href="{{ route('admin.clients.edit', $client) }}" class="btn btn-secondary btn-sm">
                            <span class="material-symbols-outlined">edit</span>
                        </a>
                        <form method="POST" action="{{ route('admin.clients.destroy', $client) }}" onsubmit="return confirm('Yakin hapus?')">
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
                <td colspan="6" style="text-align: center; padding: 40px; color: #94a3b8;">Belum ada data klien.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top: 16px;">{{ $clients->links() }}</div>
@endsection
