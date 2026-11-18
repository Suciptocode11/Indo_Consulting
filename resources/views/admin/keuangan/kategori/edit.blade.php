@extends('admin.layouts.app')

@section('title', 'Edit Kategori Keuangan')
@section('page-title', 'Manajemen Keuangan')

@section('content')
<div style="max-width:520px; margin: 0 auto;">
    <div style="margin-bottom:16px;">
        <a href="{{ route('admin.keuangan.kategori.index') }}" class="btn btn-secondary btn-sm"
           style="display:inline-flex; align-items:center; gap:5px;">
            <span class="material-symbols-outlined" style="font-size:15px;">arrow_back</span> Kembali
        </a>
    </div>

    <div class="card">
        <h2 style="font-size:16px; font-weight:700; color:#0f172a; margin-bottom:20px;">Edit Kategori Keuangan</h2>

        <form method="POST" action="{{ route('admin.keuangan.kategori.update', $kategori) }}">
            @csrf @method('PUT')

            <div class="form-group">
                <label>Nama Kategori *</label>
                <input type="text" name="nama" value="{{ old('nama', $kategori->nama) }}" required>
                @error('nama') <div class="error-msg">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label>Tipe *</label>
                <select name="tipe" required>
                    <option value="pemasukan"   {{ old('tipe', $kategori->tipe) === 'pemasukan'   ? 'selected' : '' }}>Pemasukan (Uang Masuk)</option>
                    <option value="pengeluaran" {{ old('tipe', $kategori->tipe) === 'pengeluaran' ? 'selected' : '' }}>Pengeluaran (Uang Keluar)</option>
                </select>
                @error('tipe') <div class="error-msg">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label>Keterangan <span style="font-weight:400; color:#94a3b8;">(opsional)</span></label>
                <textarea name="keterangan" rows="3">{{ old('keterangan', $kategori->keterangan) }}</textarea>
                @error('keterangan') <div class="error-msg">{{ $message }}</div> @enderror
            </div>

            <div style="display:flex; gap:10px; margin-top:24px; padding-top:16px; border-top:1px solid #f1f5f9;">
                <button type="submit" class="btn btn-primary">
                    <span class="material-symbols-outlined" style="font-size:16px;">save</span> Simpan Perubahan
                </button>
                <a href="{{ route('admin.keuangan.kategori.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

