@extends('admin.layouts.app')

@section('title', 'Tambah Berita')
@section('page-title', 'Tambah Berita/Acara')

@section('content')
<div class="card" style="max-width: 720px;">
    <form method="POST" action="{{ route('admin.blog.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label>Judul Berita *</label>
            <input type="text" name="title" value="{{ old('title') }}" required>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Tanggal</label>
                <input type="date" name="date" value="{{ old('date') }}">
            </div>
            <div class="form-group">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                    <label style="margin-bottom: 0;">Kategori</label>
                    <button type="button" class="btn-quick-add" onclick="openQuickCategoryModal('blog', 'id_category')">
                        <span class="material-symbols-outlined" style="font-size: 15px;">add_circle</span> Tambah
                    </button>
                </div>
                <select name="id_category">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($kategoris as $k)
                        <option value="{{ $k->id }}" {{ old('id_category') == $k->id ? 'selected' : '' }}>{{ $k->title }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <label>Caption</label>
            <input type="text" name="caption" value="{{ old('caption') }}" placeholder="Ringkasan singkat berita">
        </div>

        <div class="form-group">
            <label>Isi Berita</label>
            <textarea name="content" class="summernote">{{ old('content') }}</textarea>
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
                <label>Tags</label>
                <input type="text" name="tags" value="{{ old('tags') }}" placeholder="pajak, bisnis, konsultasi">
                <div class="help">Pisahkan dengan koma</div>
            </div>
            <div class="form-group">
                <label>Slug</label>
                <input type="text" name="slug" value="{{ old('slug') }}" placeholder="Otomatis dari judul">
            </div>
        </div>

        <div class="form-group">
            <label>Jumlah Dilihat (Views)</label>
            <input type="number" name="hit" value="{{ old('hit', 0) }}" min="0">
            <div class="help">Jumlah orang yang membaca berita ini. Bisa diubah manual atau otomatis bertambah saat ada yang membuka.</div>
        </div>

        <div style="display: flex; gap: 10px; margin-top: 24px;">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.blog.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
