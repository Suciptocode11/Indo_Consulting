@extends('admin.layouts.app')

@section('title', 'Edit Berita')
@section('page-title', 'Edit Berita/Acara')

@section('content')
<div class="card" style="max-width: 720px;">
    <form method="POST" action="{{ route('admin.blog.update', $blog) }}" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="form-group">
            <label>Judul Berita *</label>
            <input type="text" name="title" value="{{ old('title', $blog->title) }}" required>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Tanggal</label>
                <input type="date" name="date" value="{{ old('date', $blog->date) }}">
            </div>
            <div class="form-group">
                <label>Kategori</label>
                <select name="id_category">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($kategoris as $k)
                        <option value="{{ $k->id }}" {{ old('id_category', $blog->id_category) == $k->id ? 'selected' : '' }}>{{ $k->title }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <label>Caption</label>
            <input type="text" name="caption" value="{{ old('caption', $blog->caption) }}">
        </div>

        <div class="form-group">
            <label>Isi Berita</label>
            <textarea name="content" class="summernote">{{ old('content', $blog->content) }}</textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Gambar</label>
                @if($blog->img)
                    <div style="margin-bottom: 8px;">
                        <img src="{{ asset('storage/' . $blog->img) }}" style="height: 80px; border-radius: 8px; object-fit: cover;">
                    </div>
                @endif
                <input type="file" name="img" accept="image/*">
            </div>
            <div class="form-group">
                <label>Status *</label>
                <select name="status" required>
                    <option value="Show" {{ old('status', $blog->status) === 'Show' ? 'selected' : '' }}>Show</option>
                    <option value="Hide" {{ old('status', $blog->status) === 'Hide' ? 'selected' : '' }}>Hide</option>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Tags</label>
                <input type="text" name="tags" value="{{ old('tags', $blog->tags) }}">
            </div>
            <div class="form-group">
                <label>Slug</label>
                <input type="text" name="slug" value="{{ old('slug', $blog->slug) }}">
            </div>
        </div>

        <div class="form-group">
            <label>Jumlah Dilihat (Views)</label>
            <input type="number" name="hit" value="{{ old('hit', $blog->hit) }}" min="0">
            <div class="help">Jumlah orang yang membaca berita ini. Bisa diubah manual atau otomatis bertambah saat ada yang membuka.</div>
        </div>

        <div style="display: flex; gap: 10px; margin-top: 24px;">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.blog.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
