@extends('admin.layouts.app')

@section('title', 'Tambah Album')
@section('page-title', 'Tambah Album Baru')

@section('content')
<a href="{{ route('admin.gallery.index', ['tab' => 'albums']) }}" style="display: inline-flex; align-items: center; gap: 4px; font-size: 13px; color: #64748b; text-decoration: none; margin-bottom: 16px;">
    <span class="material-symbols-outlined" style="font-size: 18px;">arrow_back</span> Kembali ke Gallery
</a>

<div class="card" style="max-width: 720px;">
    <form method="POST" action="{{ route('admin.gallery.album-store') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label>Judul Album *</label>
            <input type="text" name="title" value="{{ old('title') }}" required placeholder="Nama album">
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Cover Album</label>
                <input type="file" name="img" accept="image/*">
                <div class="help">Foto sampul album. Format: JPG, PNG, WebP. Max 2MB.</div>
            </div>
            <div class="form-group">
                <label>Tanggal</label>
                <input type="date" name="date" value="{{ old('date') }}">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Slug</label>
                <input type="text" name="slug" value="{{ old('slug') }}" placeholder="Otomatis dari judul">
            </div>
            <div class="form-group">
                <label>Status *</label>
                <select name="status" required>
                    <option value="Show" {{ old('status', 'Show') === 'Show' ? 'selected' : '' }}>Show</option>
                    <option value="Hide" {{ old('status') === 'Hide' ? 'selected' : '' }}>Hide</option>
                </select>
            </div>
        </div>

        <div style="display: flex; gap: 10px; margin-top: 20px;">
            <button type="submit" class="btn btn-primary">Simpan Album</button>
            <a href="{{ route('admin.gallery.index', ['tab' => 'albums']) }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
