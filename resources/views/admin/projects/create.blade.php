@extends('admin.layouts.app')

@section('title', 'Tambah Proyek')
@section('page-title', 'Tambah Portfolio/Proyek')

@section('content')
<div class="card" style="max-width: 720px;">
    <form method="POST" action="{{ route('admin.projects.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label>Judul Proyek *</label>
            <input type="text" name="title" value="{{ old('title') }}" required>
            @error('title') <div class="error-msg">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                <label style="margin-bottom: 0;">Kategori</label>
                <button type="button" class="btn-quick-add" onclick="openQuickCategoryModal('project', 'id_category')">
                    <span class="material-symbols-outlined" style="font-size: 15px;">add_circle</span> Tambah Kategori Baru
                </button>
            </div>
            <select name="id_category">
                <option value="">-- Pilih Kategori --</option>
                @foreach($kategoris as $k)
                    <option value="{{ $k->id }}" {{ old('id_category') == $k->id ? 'selected' : '' }}>{{ $k->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Tanggal</label>
                <input type="date" name="date" value="{{ old('date') }}">
            </div>
            <div class="form-group">
                <label>Lokasi</label>
                <input type="text" name="lokasi" value="{{ old('lokasi') }}" placeholder="Kota, Provinsi">
            </div>
        </div>

        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="content" rows="5">{{ old('content') }}</textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Gambar</label>
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

        <div class="form-row">
            <div class="form-group">
                <label>Slug</label>
                <input type="text" name="slug" value="{{ old('slug') }}" placeholder="Otomatis dari judul">
            </div>
            <div class="form-group">
                <label>URL Eksternal</label>
                <input type="url" name="url" value="{{ old('url') }}">
            </div>
        </div>

        <div style="display: flex; gap: 10px; margin-top: 24px;">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
