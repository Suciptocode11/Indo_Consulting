@extends('admin.layouts.app')

@section('title', 'Tambah FAQ')
@section('page-title', 'Tambah FAQ')

@section('content')
<div class="card" style="max-width: 720px;">
    <form method="POST" action="{{ route('admin.faqs.store') }}">
        @csrf

        <div class="form-group">
            <label>Pertanyaan *</label>
            <input type="text" name="question" value="{{ old('question') }}" required placeholder="Contoh: Berapa lama proses konsultasi?">
        </div>

        <div class="form-group">
            <label>Jawaban *</label>
            <textarea name="answer" rows="5" required placeholder="Jawaban untuk pertanyaan tersebut">{{ old('answer') }}</textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Urutan</label>
                <input type="number" name="urutan" value="{{ old('urutan', 0) }}" min="0">
                <div class="help">Urutan tampilan (0 = paling atas)</div>
            </div>
            <div class="form-group">
                <label>Status *</label>
                <select name="status" required>
                    <option value="Show">Show</option>
                    <option value="Hide" {{ old('status') === 'Hide' ? 'selected' : '' }}>Hide</option>
                </select>
            </div>
        </div>

        <div style="display: flex; gap: 10px; margin-top: 24px;">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.faqs.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
