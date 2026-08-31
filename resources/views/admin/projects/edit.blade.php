@extends('admin.layouts.app')

@section('title', 'Edit Proyek')
@section('page-title', 'Edit Portfolio/Proyek')

@section('content')
<div class="card" style="max-width: 720px;">
    <form method="POST" action="{{ route('admin.projects.update', $project) }}" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="form-group">
            <label>Judul Proyek *</label>
            <input type="text" name="title" value="{{ old('title', $project->title) }}" required>
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
                    <option value="{{ $k->id }}" {{ old('id_category', $project->id_category) == $k->id ? 'selected' : '' }}>{{ $k->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Tanggal</label>
                <input type="date" name="date" value="{{ old('date', $project->date) }}">
            </div>
            <div class="form-group">
                <label>Lokasi</label>
                <input type="text" name="lokasi" value="{{ old('lokasi', $project->lokasi) }}">
            </div>
        </div>

        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="content" rows="5">{{ old('content', $project->content) }}</textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Gambar</label>
                @if($project->img)
                    <div style="margin-bottom: 8px;">
                        <img src="{{ asset('storage/' . $project->img) }}" style="height: 80px; border-radius: 8px; object-fit: cover;">
                    </div>
                @endif
                <input type="file" name="img" accept="image/*">
            </div>
            <div class="form-group">
                <label>Status *</label>
                <select name="status" required>
                    <option value="Show" {{ old('status', $project->status) === 'Show' ? 'selected' : '' }}>Show</option>
                    <option value="Hide" {{ old('status', $project->status) === 'Hide' ? 'selected' : '' }}>Hide</option>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Slug</label>
                <input type="text" name="slug" value="{{ old('slug', $project->slug) }}">
            </div>
            <div class="form-group">
                <label>URL Eksternal</label>
                <input type="url" name="url" value="{{ old('url', $project->url) }}">
            </div>
        </div>

        <div style="display: flex; gap: 10px; margin-top: 24px;">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
