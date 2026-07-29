@extends('admin.layouts.app')

@section('title', 'Edit Visi & Misi')
@section('page-title', 'Edit Visi & Misi')

@section('content')
<div class="card" style="max-width: 720px;">
    <form method="POST" action="{{ route('admin.visi-misi.update', $visiMisi) }}">
        @csrf @method('PUT')

        <div class="form-row">
            <div class="form-group">
                <label>Tipe *</label>
                <select name="type" required>
                    <option value="visi" {{ old('type', $visiMisi->type) === 'visi' ? 'selected' : '' }}>Visi</option>
                    <option value="misi" {{ old('type', $visiMisi->type) === 'misi' ? 'selected' : '' }}>Misi</option>
                </select>
            </div>
            <div class="form-group">
                <label>Icon (Material Symbols)</label>
                <input type="text" name="icon" value="{{ old('icon', $visiMisi->icon) }}">
            </div>
        </div>

        <div class="form-group">
            <label>Judul</label>
            <input type="text" name="title" value="{{ old('title', $visiMisi->title) }}">
        </div>

        <div class="form-group">
            <label>Deskripsi *</label>
            <textarea name="description" rows="4" required>{{ old('description', $visiMisi->description) }}</textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Urutan</label>
                <input type="number" name="urutan" value="{{ old('urutan', $visiMisi->urutan) }}" min="0">
            </div>
            <div class="form-group">
                <label>Status *</label>
                <select name="status" required>
                    <option value="Show" {{ old('status', $visiMisi->status) === 'Show' ? 'selected' : '' }}>Show</option>
                    <option value="Hide" {{ old('status', $visiMisi->status) === 'Hide' ? 'selected' : '' }}>Hide</option>
                </select>
            </div>
        </div>

        <div style="display: flex; gap: 10px; margin-top: 24px;">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.visi-misi.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
