@extends('admin.layouts.app')

@section('title', 'Tambah Visi & Misi')
@section('page-title', 'Tambah Visi & Misi')

@section('content')
<div class="card" style="max-width: 720px;">
    <form method="POST" action="{{ route('admin.visi-misi.store') }}">
        @csrf

        <div class="form-row">
            <div class="form-group">
                <label>Tipe *</label>
                <select name="type" required>
                    <option value="visi" {{ old('type') === 'visi' ? 'selected' : '' }}>Visi</option>
                    <option value="misi" {{ old('type', 'misi') === 'misi' ? 'selected' : '' }}>Misi</option>
                </select>
            </div>
            <div class="form-group">
                <label>Icon (Material Symbols)</label>
                <input type="text" name="icon" value="{{ old('icon') }}" placeholder="Contoh: visibility, flag, target">
            </div>
        </div>

        <div class="form-group">
            <label>Judul</label>
            <input type="text" name="title" value="{{ old('title') }}" placeholder="Opsional — untuk misi yang punya judul sub">
        </div>

        <div class="form-group">
            <label>Deskripsi *</label>
            <textarea name="description" rows="4" required placeholder="Tuliskan visi atau misi di sini">{{ old('description') }}</textarea>
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
            <a href="{{ route('admin.visi-misi.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
