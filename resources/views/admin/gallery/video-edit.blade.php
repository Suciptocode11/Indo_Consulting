@extends('admin.layouts.app')

@section('title', 'Edit Video')
@section('page-title', 'Edit Video: ' . $video->title)

@section('content')
<a href="{{ route('admin.gallery.index', ['tab' => 'videos']) }}" style="display: inline-flex; align-items: center; gap: 4px; font-size: 13px; color: #64748b; text-decoration: none; margin-bottom: 16px;">
    <span class="material-symbols-outlined" style="font-size: 18px;">arrow_back</span> Kembali ke Gallery
</a>

<div class="card" style="max-width: 720px;" x-data="{ sourceType: '{{ ($video->source && str_contains($video->source, 'youtube')) ? 'youtube' : 'upload' }}' }">
    <form method="POST" action="{{ route('admin.gallery.video-update', $video) }}" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="form-group">
            <label>Judul Video *</label>
            <input type="text" name="title" value="{{ old('title', $video->title) }}" required>
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
            <input type="text" name="source_url" value="{{ old('source_url', str_contains($video->source, 'youtube') ? $video->source : '') }}">
        </div>

        <div class="form-group" x-show="sourceType === 'upload'" x-cloak>
            <label>File Video</label>
            @if(!str_contains($video->source, 'youtube') && $video->source)
                <div style="margin-bottom: 8px; font-size: 13px; color: #64748b;">Video saat ini: {{ basename($video->source) }}</div>
            @endif
            <input type="file" name="source_file" accept="video/*">
            <div class="help">Kosongkan jika tidak ingin mengganti.</div>
        </div>

        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="content" rows="3">{{ old('content', $video->content) }}</textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Tanggal</label>
                <input type="date" name="date" value="{{ old('date', $video->date) }}">
            </div>
            <div class="form-group">
                <label>Status *</label>
                <select name="status" required>
                    <option value="Show" {{ old('status', $video->status) === 'Show' ? 'selected' : '' }}>Show</option>
                    <option value="Hide" {{ old('status', $video->status) === 'Hide' ? 'selected' : '' }}>Hide</option>
                </select>
            </div>
        </div>

        <div style="display: flex; gap: 10px; margin-top: 24px;">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.gallery.index', ['tab' => 'videos']) }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
