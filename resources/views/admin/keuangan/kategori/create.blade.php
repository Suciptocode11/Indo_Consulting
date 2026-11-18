@extends('admin.layouts.app')

@section('title', 'Tambah Kategori Keuangan')
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
        <h2 style="font-size:16px; font-weight:700; color:#0f172a; margin-bottom:20px;">Tambah Kategori Keuangan</h2>

        <form method="POST" action="{{ route('admin.keuangan.kategori.store') }}">
            @csrf

            <div class="form-group">
                <label>Nama Kategori *</label>
                <input type="text" name="nama" value="{{ old('nama') }}" required
                    placeholder="Contoh: Fee Program Konsultasi">
                @error('nama') <div class="error-msg">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label>Tipe *</label>
                <select name="tipe" required>
                    <option value="">— Pilih Tipe —</option>
                    <option value="pemasukan"   {{ old('tipe', request('tipe')) === 'pemasukan'   ? 'selected' : '' }}>Pemasukan (Uang Masuk)</option>
                    <option value="pengeluaran" {{ old('tipe', request('tipe')) === 'pengeluaran' ? 'selected' : '' }}>Pengeluaran (Uang Keluar)</option>
                </select>
                @error('tipe') <div class="error-msg">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label>Keterangan <span style="font-weight:400; color:#94a3b8;">(opsional)</span></label>
                <textarea name="keterangan" rows="3" placeholder="Deskripsi singkat kategori ini">{{ old('keterangan') }}</textarea>
                @error('keterangan') <div class="error-msg">{{ $message }}</div> @enderror
            </div>

            <div style="display:flex; gap:10px; margin-top:24px; padding-top:16px; border-top:1px solid #f1f5f9; align-items:center; justify-content:flex-end;">
                <a href="{{ route('admin.keuangan.kategori.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" name="save_and_add" value="1" class="btn btn-secondary" style="background:#fff; border:1px solid #bb0027; color:#bb0027; font-weight:600; display:inline-flex; align-items:center; gap:5px;">
                    <span class="material-symbols-outlined" style="font-size:16px; color:#bb0027;">add_circle</span> Simpan & Tambah
                </button>
                <button type="submit" class="btn btn-primary" style="display:inline-flex; align-items:center; gap:5px;">
                    <span class="material-symbols-outlined" style="font-size:16px;">save</span> Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

