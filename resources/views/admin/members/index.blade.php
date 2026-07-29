@extends('admin.layouts.app')

@section('title', 'Expert/Team')
@section('page-title', 'Expert / Team')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <form method="GET" style="display: flex; gap: 8px;">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama..." style="padding: 8px 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-family: 'Outfit', sans-serif; font-size: 13px; width: 220px;">
        <select name="status" style="padding: 8px 12px; border: 1px solid #e2e8f0; border-radius: 8px; font-family: 'Outfit', sans-serif; font-size: 13px;">
            <option value="">Semua Status</option>
            <option value="Show" {{ request('status') === 'Show' ? 'selected' : '' }}>Show</option>
            <option value="Hide" {{ request('status') === 'Hide' ? 'selected' : '' }}>Hide</option>
        </select>
        <button type="submit" class="btn btn-secondary btn-sm">Filter</button>
    </form>
    <a href="{{ route('admin.members.create') }}" class="btn btn-primary">
        <span class="material-symbols-outlined">add</span> Tambah Baru
    </a>
</div>

<div class="card" style="padding: 0; overflow: hidden;">
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 50px;">ID</th>
                <th>Nama</th>
                <th>No. Anggota</th>
                <th>Jabatan</th>
                <th>Status</th>
                <th style="width: 180px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($members as $member)
            <tr>
                <td>{{ $member->id }}</td>
                <td>
                    <div style="display: flex; align-items: center; gap: 10px;">
                        @if($member->foto && !str_starts_with($member->foto, 'http'))
                            <img src="{{ asset('storage/' . $member->foto) }}" style="width: 40px; height: 40px; border-radius: 8px; object-fit: cover;">
                        @elseif($member->foto)
                            <img src="{{ $member->foto }}" style="width: 40px; height: 40px; border-radius: 8px; object-fit: cover;">
                        @else
                            <div style="width: 40px; height: 40px; border-radius: 8px; background: #e2e8f0; display: flex; align-items: center; justify-content: center;">
                                <span class="material-symbols-outlined" style="font-size: 20px; color: #94a3b8;">person</span>
                            </div>
                        @endif
                        <div>
                            <strong>{{ $member->nama }}</strong>
                            <div style="font-size: 12px; color: #94a3b8;">{{ $member->email ?? '' }}</div>
                        </div>
                    </div>
                </td>
                <td>
                    @if($member->no_anggota)
                        <span style="font-family: 'Courier New', monospace; font-size: 12px; font-weight: 600; color: #0f172a;">{{ $member->no_anggota }}</span>
                    @else
                        <span style="color: #94a3b8;">-</span>
                    @endif
                </td>
                <td>{{ $member->jabatan ?? '-' }}</td>
                <td>
                    <span class="badge {{ $member->status === 'Show' ? 'badge-success' : 'badge-danger' }}">{{ $member->status }}</span>
                </td>
                <td>
                    <div style="display: flex; gap: 6px;">
                        @if($member->no_anggota)
                        <a href="{{ route('admin.members.show', $member) }}" class="btn btn-secondary btn-sm" title="Lihat Kartu Anggota">
                            <span class="material-symbols-outlined">badge</span>
                        </a>
                        @endif
                        <a href="{{ route('admin.members.edit', $member) }}" class="btn btn-secondary btn-sm">
                            <span class="material-symbols-outlined">edit</span>
                        </a>
                        <form method="POST" action="{{ route('admin.members.destroy', $member) }}" onsubmit="return confirm('Yakin hapus?')">
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
                <td colspan="7" style="text-align: center; padding: 40px; color: #94a3b8;">Belum ada data member.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top: 16px;">{{ $members->links() }}</div>
@endsection
