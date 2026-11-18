@extends('admin.layouts.app')

@section('title', 'Kategori Keuangan')
@section('page-title', 'Manajemen Keuangan')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; flex-wrap:wrap; gap:10px;">
    <div style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
        <a href="{{ route('admin.keuangan.index') }}" class="btn btn-secondary btn-sm"
           style="display:inline-flex; align-items:center; gap:5px;">
            <span class="material-symbols-outlined" style="font-size:15px;">arrow_back</span> Kembali
        </a>
        <form method="GET" style="display:flex; gap:8px; flex-wrap:wrap;">
            <select name="tipe" style="padding:7px 12px; border:1px solid #e2e8f0; border-radius:8px; font-family:'Outfit',sans-serif; font-size:13px;">
                <option value="">Semua Tipe</option>
                <option value="pemasukan"   {{ request('tipe') === 'pemasukan'   ? 'selected' : '' }}>Pemasukan</option>
                <option value="pengeluaran" {{ request('tipe') === 'pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
            </select>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama..."
                style="padding:7px 12px; border:1px solid #e2e8f0; border-radius:8px; font-family:'Outfit',sans-serif; font-size:13px; width:180px;">
            <button type="submit" class="btn btn-secondary btn-sm">Filter</button>
        </form>
    </div>
    <div style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
        <button type="button" class="btn btn-secondary" onclick="openModalTambahKontrak()"
           style="display:inline-flex; align-items:center; gap:6px; background:#fff; border:1px solid #cbd5e1; color:#0f172a; font-weight:600; cursor:pointer;">
            <span class="material-symbols-outlined" style="font-size:16px; color:#bb0027;">post_add</span> Tambah Kontrak Klien
        </button>
        <a href="{{ route('admin.keuangan.kategori.create') }}" class="btn btn-primary"
           style="display:inline-flex; align-items:center; gap:6px;">
            <span class="material-symbols-outlined" style="font-size:16px;">add</span> Tambah Kategori
        </a>
    </div>
</div>

<div class="card" style="padding:0; overflow:hidden;">
    <table class="data-table">
        <thead>
            <tr>
                <th style="width:50px; text-align:center;">#</th>
                <th>Nama Kategori</th>
                <th style="width:120px;">Tipe</th>
                <th>Keterangan</th>
                <th style="width:90px; text-align:center;">Transaksi</th>
                <th style="width:120px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kategoris as $kat)
            <tr>
                <td style="text-align:center; color:#94a3b8; font-weight:600;">{{ $kategoris->firstItem() + $loop->index }}</td>
                <td><strong style="font-size:13px;">{{ $kat->nama }}</strong></td>
                <td>
                    <span style="padding:3px 10px; border-radius:6px; font-size:11px; font-weight:600; display:inline-flex; align-items:center; gap:4px;
                        {{ $kat->tipe === 'pemasukan' ? 'background:#dcfce7; color:#15803d;' : 'background:#fee2e2; color:#b91c1c;' }}">
                        <span class="material-symbols-outlined" style="font-size:12px;">
                            {{ $kat->tipe === 'pemasukan' ? 'arrow_downward' : 'arrow_upward' }}
                        </span>
                        {{ $kat->tipe_label }}
                    </span>
                </td>
                <td style="font-size:12px; color:#64748b;">{{ Str::limit($kat->keterangan, 60) ?? '—' }}</td>
                <td style="text-align:center; font-size:13px; font-weight:600; color:#334155;">{{ $kat->transaksi_count }}</td>
                <td>
                    <div style="display:flex; gap:5px;">
                        <a href="{{ route('admin.keuangan.kategori.edit', $kat) }}" class="btn btn-secondary btn-sm" title="Edit">
                            <span class="material-symbols-outlined">edit</span>
                        </a>
                        <form method="POST" action="{{ route('admin.keuangan.kategori.destroy', $kat) }}"
                              onsubmit="return confirm('Yakin hapus kategori \'{{ $kat->nama }}\'?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                <span class="material-symbols-outlined">delete</span>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align:center; padding:40px; color:#94a3b8;">
                    <span class="material-symbols-outlined" style="font-size:32px; display:block; margin-bottom:8px; opacity:.4;">category</span>
                    Belum ada kategori keuangan.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top:16px;">{{ $kategoris->links() }}</div>

{{-- Shortcut Tambah Kontrak Klien di Bawah Tabel Kategori --}}
<div style="margin-top:24px; padding:18px 22px; background:#fff; border:1px solid #e2e8f0; border-radius:12px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:14px; box-shadow:0 1px 3px rgba(0,0,0,0.03);">
    <div style="display:flex; align-items:center; gap:12px;">
        <div style="width:40px; height:40px; border-radius:10px; background:#fef2f2; display:flex; align-items:center; justify-content:center; color:#bb0027; flex-shrink:0;">
            <span class="material-symbols-outlined" style="font-size:22px;">post_add</span>
        </div>
        <div>
            <div style="font-size:14px; font-weight:700; color:#0f172a;">Pendaftaran Kontrak Proyek Klien</div>
            <div style="font-size:12px; color:#64748b; margin-top:2px;">Buat kontrak baru, tentukan PIC, target jadwal, dan nilai kesepakatan proyek.</div>
        </div>
    </div>
    <button type="button" onclick="openModalTambahKontrak()" class="btn btn-primary"
       style="display:inline-flex; align-items:center; gap:6px; background:#bb0027; border-color:#bb0027; font-weight:600; padding:9px 18px; cursor:pointer;">
        <span class="material-symbols-outlined" style="font-size:17px;">add_circle</span> Tambah Kontrak Klien
    </button>
</div>
@endsection

