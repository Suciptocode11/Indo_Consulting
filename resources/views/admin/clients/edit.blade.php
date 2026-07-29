@extends('admin.layouts.app')

@section('title', 'Edit Klien')
@section('page-title', 'Edit Mitra/Klien')

@section('content')
<div class="card" style="max-width: 720px;">
    <form method="POST" action="{{ route('admin.clients.update', $client) }}" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="form-group">
            <label>Nama Klien *</label>
            <input type="text" name="title" value="{{ old('title', $client->title) }}" required>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Sektor/Kategori</label>
                <select name="sector">
                    <option value="">-- Pilih Sektor --</option>
                    <option value="Pemerintahan" {{ old('sector', $client->sector) === 'Pemerintahan' ? 'selected' : '' }}>Pemerintahan</option>
                    <option value="Perbankan" {{ old('sector', $client->sector) === 'Perbankan' ? 'selected' : '' }}>Perbankan</option>
                    <option value="BUMN" {{ old('sector', $client->sector) === 'BUMN' ? 'selected' : '' }}>BUMN</option>
                    <option value="Swasta" {{ old('sector', $client->sector) === 'Swasta' ? 'selected' : '' }}>Swasta</option>
                    <option value="Pendidikan" {{ old('sector', $client->sector) === 'Pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                    <option value="Teknologi" {{ old('sector', $client->sector) === 'Teknologi' ? 'selected' : '' }}>Teknologi</option>
                    <option value="Konstruksi" {{ old('sector', $client->sector) === 'Konstruksi' ? 'selected' : '' }}>Konstruksi</option>
                </select>
            </div>
            <div class="form-group">
                <label>Logo/Gambar</label>
                @if($client->img)
                    <div style="margin-bottom: 8px;">
                        <img src="{{ asset('storage/' . $client->img) }}" style="height: 60px; border-radius: 8px; object-fit: cover;">
                    </div>
                @endif
                <input type="file" name="img" accept="image/*">
            </div>
            <div class="form-group">
                <label>Status *</label>
                <select name="status" required>
                    <option value="Show" {{ old('status', $client->status) === 'Show' ? 'selected' : '' }}>Show</option>
                    <option value="Hide" {{ old('status', $client->status) === 'Hide' ? 'selected' : '' }}>Hide</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label>URL Website</label>
            <input type="url" name="url" value="{{ old('url', $client->url) }}">
        </div>

        <div style="display: flex; gap: 10px; margin-top: 24px;">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.clients.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
