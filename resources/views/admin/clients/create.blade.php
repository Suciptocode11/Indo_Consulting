@extends('admin.layouts.app')

@section('title', 'Tambah Klien')
@section('page-title', 'Tambah Mitra/Klien')

@section('content')
<div class="card" style="max-width: 720px;">
    <form method="POST" action="{{ route('admin.clients.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label>Nama Klien *</label>
            <input type="text" name="title" value="{{ old('title') }}" required placeholder="Contoh: PT Maju Bersama">
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Sektor/Kategori</label>
                <select name="sector">
                    <option value="">-- Pilih Sektor --</option>
                    <option value="Pemerintahan" {{ old('sector') === 'Pemerintahan' ? 'selected' : '' }}>Pemerintahan</option>
                    <option value="Perbankan" {{ old('sector') === 'Perbankan' ? 'selected' : '' }}>Perbankan</option>
                    <option value="BUMN" {{ old('sector') === 'BUMN' ? 'selected' : '' }}>BUMN</option>
                    <option value="Swasta" {{ old('sector') === 'Swasta' ? 'selected' : '' }}>Swasta</option>
                    <option value="Pendidikan" {{ old('sector') === 'Pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                    <option value="Teknologi" {{ old('sector') === 'Teknologi' ? 'selected' : '' }}>Teknologi</option>
                    <option value="Konstruksi" {{ old('sector') === 'Konstruksi' ? 'selected' : '' }}>Konstruksi</option>
                </select>
            </div>
            <div class="form-group">
                <label>Logo/Gambar</label>
                <input type="file" name="img" accept="image/*">
            </div>
            <div class="form-group">
                <label>Status *</label>
                <select name="status" required>
                    <option value="Show">Show</option>
                    <option value="Hide">Hide</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label>URL Website</label>
            <input type="url" name="url" value="{{ old('url') }}" placeholder="https://...">
        </div>

        <div style="display: flex; gap: 10px; margin-top: 24px;">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.clients.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
