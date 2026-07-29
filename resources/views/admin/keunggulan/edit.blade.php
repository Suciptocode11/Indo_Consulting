@extends('admin.layouts.app')

@section('title', 'Edit Keunggulan')
@section('page-title', 'Edit Keunggulan')

@section('content')
<div class="card" style="max-width: 720px;">
    <form method="POST" action="{{ route('admin.keunggulan.update', $keunggulan) }}">
        @csrf @method('PUT')

        <div class="form-group">
            <label>Icon (Material Symbols)</label>
            <input type="text" name="icon" value="{{ old('icon', $keunggulan->icon) }}">
        </div>

        <div class="form-group">
            <label>Judul *</label>
            <input type="text" name="title" value="{{ old('title', $keunggulan->title) }}" required>
        </div>

        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="description" rows="3">{{ old('description', $keunggulan->description) }}</textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Urutan</label>
                <input type="number" name="urutan" value="{{ old('urutan', $keunggulan->urutan) }}" min="0">
            </div>
            <div class="form-group">
                <label>Status *</label>
                <select name="status" required>
                    <option value="Show" {{ old('status', $keunggulan->status) === 'Show' ? 'selected' : '' }}>Show</option>
                    <option value="Hide" {{ old('status', $keunggulan->status) === 'Hide' ? 'selected' : '' }}>Hide</option>
                </select>
            </div>
        </div>

        <div style="display: flex; gap: 10px; margin-top: 24px;">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.keunggulan.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
