@extends('admin.layouts.app')

@section('title', 'Pendaftaran')
@section('page-title', 'Pendaftaran / Rekrutmen')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <form method="GET" style="display: flex; gap: 8px;">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, posisi..." style="padding: 8px 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-family: 'Outfit', sans-serif; font-size: 13px; width: 250px;">
        <select name="status" style="padding: 8px 12px; border: 1px solid #e2e8f0; border-radius: 8px; font-family: 'Outfit', sans-serif; font-size: 13px;">
            <option value="Pending" {{ request('status', 'Pending') === 'Pending' ? 'selected' : '' }}>Menunggu Review</option>
            <option value="Approved" {{ request('status') === 'Approved' ? 'selected' : '' }}>Disetujui</option>
            <option value="Rejected" {{ request('status') === 'Rejected' ? 'selected' : '' }}>Ditolak</option>
        </select>
        <button type="submit" class="btn btn-secondary btn-sm">Filter</button>
    </form>
</div>

<div class="card" style="padding: 0; overflow: hidden;">
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 50px;">ID</th>
                <th>Foto</th>
                <th>Nama</th>
                <th>Posisi</th>
                <th>Provinsi</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th style="width: 180px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pendaftarans as $p)
            <tr>
                <td>{{ $p->id }}</td>
                <td>
                    @if($p->foto)
                        <img src="{{ asset('storage/' . $p->foto) }}" style="width: 40px; height: 40px; border-radius: 8px; object-fit: cover;">
                    @else
                        <div style="width: 40px; height: 40px; border-radius: 8px; background: #f1f5f9; display: flex; align-items: center; justify-content: center;">
                            <span class="material-symbols-outlined" style="font-size: 20px; color: #94a3b8;">person</span>
                        </div>
                    @endif
                </td>
                <td>
                    <strong>{{ $p->nama }}</strong>
                    <div style="font-size: 12px; color: #64748b;">{{ $p->email }}</div>
                </td>
                <td>{{ $p->posisi ?? '-' }}</td>
                <td>{{ $p->provinsi ?? '-' }}</td>
                <td>{{ $p->created_at ? $p->created_at->format('d M Y') : '-' }}</td>
                <td>
                    @if($p->status === 'Pending')
                        <span class="badge badge-warning">Pending</span>
                    @elseif($p->status === 'Approved')
                        <span class="badge badge-success">Approved</span>
                    @else
                        <span class="badge badge-danger">Rejected</span>
                    @endif
                </td>
                <td>
                    <div style="display: flex; gap: 6px; flex-wrap: wrap;">
                        <a href="{{ route('admin.pendaftaran.show', $p) }}" class="btn btn-secondary btn-sm">
                            <span class="material-symbols-outlined">visibility</span>
                        </a>
                        @if($p->status === 'Pending')
                            <form method="POST" action="{{ route('admin.pendaftaran.approve', $p) }}" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm('Setujui lamaran ini? Data akan ditambahkan ke daftar anggota.')">
                                    <span class="material-symbols-outlined">check</span>
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.pendaftaran.reject', $p) }}" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tolak lamaran ini?')">
                                    <span class="material-symbols-outlined">close</span>
                                </button>
                            </form>
                        @endif
                        <form method="POST" action="{{ route('admin.pendaftaran.destroy', $p) }}" onsubmit="return confirm('Hapus data ini?')">
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
                <td colspan="8" style="text-align: center; padding: 40px; color: #94a3b8;">Belum ada data pendaftaran.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top: 16px;">{{ $pendaftarans->links() }}</div>
@endsection
