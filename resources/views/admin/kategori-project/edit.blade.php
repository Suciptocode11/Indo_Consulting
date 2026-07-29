@extends('admin.layouts.app')

@section('title', 'Edit Kategori')
@section('page-title', 'Edit Kategori Proyek')

@section('content')
<div class="card" style="max-width: 500px;">
    <form method="POST" action="{{ route('admin.kategori-project.update', $kategoriProject) }}">
        @csrf @method('PUT')

        <div class="form-group">
            <label>Judul Kategori *</label>
            <input type="text" name="title" value="{{ old('title', $kategoriProject->title) }}" required>
            @error('title') <div class="error-msg">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label>Slug</label>
            <input type="text" name="slug" value="{{ old('slug', $kategoriProject->slug) }}">
        </div>

        <div style="display: flex; gap: 10px; margin-top: 24px;">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.kategori-project.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection