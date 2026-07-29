@extends('admin.layouts.app')

@section('title', 'Tambah Program')
@section('page-title', 'Tambah Program/Layanan')

@include('admin.partials.image-upload-assets')

@section('content')
<div class="card" style="max-width: 720px;">
    <form method="POST" action="{{ route('admin.services.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label>Judul Program *</label>
            <input type="text" name="title" value="{{ old('title') }}" required placeholder="Contoh: Bisnis & Manajemen SDM">
            @error('title') <div class="error-msg">{{ $message }}</div> @enderror
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Icon (Material Symbols)</label>
                <input type="text" name="icon" value="{{ old('icon') }}" placeholder="Contoh: school">
                <div class="help">Nama icon dari Google Material Symbols</div>
            </div>
            <div class="form-group">
                <label>Slug</label>
                <input type="text" name="slug" value="{{ old('slug') }}" placeholder="Otomatis dari judul">
            </div>
        </div>

        <div class="form-group">
            <label>Deskripsi Singkat</label>
            <textarea name="short" rows="3" placeholder="Deskripsi singkat program">{{ old('short') }}</textarea>
        </div>

        <div class="form-group">
            <label>Deskripsi Lengkap</label>
            <textarea name="content" class="summernote" placeholder="Deskripsi lengkap program">{{ old('content') }}</textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Gambar</label>
                @include('admin.partials.image-upload-widget', [
                    'name' => 'img',
                    'key'  => 'img',
                    'value' => null,
                    'arrayInput' => false
                ])
                <div class="help" style="margin-top:8px;">Format: JPG, PNG, WebP. Max 5MB.</div>
            </div>
            <div class="form-group">
                <label>Status *</label>
                <select name="status" required>
                    <option value="Show" {{ old('status') === 'Show' ? 'selected' : '' }}>Show</option>
                    <option value="Hide" {{ old('status', 'Show') === 'Hide' ? 'selected' : '' }}>Hide</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label>URL Eksternal</label>
            <input type="url" name="url" value="{{ old('url') }}" placeholder="https://...">
        </div>

        <div style="display: flex; gap: 10px; margin-top: 24px;">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
