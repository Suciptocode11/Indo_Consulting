@extends('admin.layouts.app')

@section('title', 'Tambah Keunggulan')
@section('page-title', 'Tambah Keunggulan')

@section('content')
<div class="card" style="max-width: 720px;">
    <form method="POST" action="{{ route('admin.keunggulan.store') }}">
        @csrf

        <div class="form-group">
            <label>Icon (Material Symbols)</label>
            <input type="text" name="icon" value="{{ old('icon') }}" placeholder="Contoh: analytics, groups, handshake, verified">
            <div class="help">Cari icon di <a href="https://fonts.google.com/icons" target="_blank" style="color: #2563eb;">Google Material Symbols</a></div>
        </div>

        <div class="form-group">
            <label>Judul *</label>
            <input type="text" name="title" value="{{ old('title') }}" required placeholder="Contoh: Berbasis Data">
        </div>

        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="description" rows="3" placeholder="Penjelasan singkat keunggulan ini">{{ old('description') }}</textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Urutan</label>
                <input type="number" name="urutan" value="{{ old('urutan', 0) }}" min="0">
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
            <a href="{{ route('admin.keunggulan.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
