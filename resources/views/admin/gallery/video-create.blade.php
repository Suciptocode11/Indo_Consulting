@extends('admin.layouts.app')

@section('title', 'Tambah Video')
@section('page-title', 'Tambah Video')

@section('content')
<a href="{{ route('admin.gallery.index', ['tab' => 'videos']) }}" style="display: inline-flex; align-items: center; gap: 4px; font-size: 13px; color: #64748b; text-decoration: none; margin-bottom: 16px;">
    <span class="material-symbols-outlined" style="font-size: 18px;">arrow_back</span> Kembali ke Gallery
</a>

<div class="card" style="max-width: 720px;" x-data="{ sourceType: 'youtube' }">
    <form method="POST" action="{{ route('admin.gallery.video-store') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label>Judul Video *</label>
            <input type="text" name="title" value="{{ old('title') }}" required placeholder="Contoh: Webinar Perpajakan 2024">
        </div>

        <div class="form-group">
            <label>Sumber Video *</label>
            <select name="source_type" x-model="sourceType">
                <option value="youtube">YouTube (Link)</option>
                <option value="upload">Upload File</option>
            </select>
        </div>

        <div class="form-group" x-show="sourceType === 'youtube'">
            <label>URL YouTube *</label>
            <input type="text" name="source_url" value="{{ old('source_url') }}" placeholder="https://www.youtube.com/watch?v=xxxxx">
            <div class="help">Paste URL YouTube. Otomatis di-convert ke embed.</div>
        </div>

        <div class="form-group" x-show="sourceType === 'upload'" x-cloak>
            <label>File Video</label>
            <input type="file" name="source_file" accept="video/*">
            <div class="help">Format: MP4, WebM, OGG. Max 50MB.</div>
        </div>

        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="content" rows="3">{{ old('content') }}</textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Tanggal</label>
                <input type="date" name="date" value="{{ old('date') }}">
            </div>
            <div class="form-group">
                <label>Status *</label>
                <select name="status" required>
                    <option value="Show">Show</option>
                    <option value="Hide">Hide</option>
                </select>
            </div>
        </div>

        <div style="display: flex; gap: 10px; margin-top: 24px;">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.gallery.index', ['tab' => 'videos']) }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
