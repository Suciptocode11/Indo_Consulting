@extends('admin.layouts.app')

@section('title', 'Edit Program')
@section('page-title', 'Edit Program/Layanan')

@section('content')
<div class="card" style="max-width: 720px;">
    <form method="POST" action="{{ route('admin.services.update', $service) }}" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="form-group">
            <label>Judul Program *</label>
            <input type="text" name="title" value="{{ old('title', $service->title) }}" required>
            @error('title') <div class="error-msg">{{ $message }}</div> @enderror
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Icon (Material Symbols)</label>
                <input type="text" name="icon" value="{{ old('icon', $service->icon) }}">
            </div>
            <div class="form-group">
                <label>Slug</label>
                <input type="text" name="slug" value="{{ old('slug', $service->slug) }}">
            </div>
        </div>

        <div class="form-group">
            <label>Deskripsi Singkat</label>
            <textarea name="short" rows="3">{{ old('short', $service->short) }}</textarea>
        </div>

        <div class="form-group">
            <label>Deskripsi Lengkap</label>
            <textarea name="content" class="summernote">{{ old('content', $service->content) }}</textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Gambar</label>
                @if($service->img)
                    <div style="margin-bottom: 8px;">
                        @if(str_starts_with($service->img, 'http'))
                            <img src="{{ $service->img }}" style="height: 80px; border-radius: 8px; object-fit: cover;">
                        @else
                            <img src="{{ asset('storage/' . $service->img) }}" style="height: 80px; border-radius: 8px; object-fit: cover;">
                        @endif
                    </div>
                @endif
                <input type="file" name="img" accept="image/*">
                <div class="help">Kosongkan jika tidak ingin mengganti.</div>
            </div>
            <div class="form-group">
                <label>Status *</label>
                <select name="status" required>
                    <option value="Show" {{ old('status', $service->status) === 'Show' ? 'selected' : '' }}>Show</option>
                    <option value="Hide" {{ old('status', $service->status) === 'Hide' ? 'selected' : '' }}>Hide</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label>URL Eksternal</label>
            <input type="url" name="url" value="{{ old('url', $service->url) }}">
        </div>

        <div style="display: flex; gap: 10px; margin-top: 24px;">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
