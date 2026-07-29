@extends('admin.layouts.app')

@section('title', 'Edit FAQ')
@section('page-title', 'Edit FAQ')

@section('content')
<div class="card" style="max-width: 720px;">
    <form method="POST" action="{{ route('admin.faqs.update', $faq) }}">
        @csrf @method('PUT')

        <div class="form-group">
            <label>Pertanyaan *</label>
            <input type="text" name="question" value="{{ old('question', $faq->question) }}" required>
        </div>

        <div class="form-group">
            <label>Jawaban *</label>
            <textarea name="answer" rows="5" required>{{ old('answer', $faq->answer) }}</textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Urutan</label>
                <input type="number" name="urutan" value="{{ old('urutan', $faq->urutan) }}" min="0">
            </div>
            <div class="form-group">
                <label>Status *</label>
                <select name="status" required>
                    <option value="Show" {{ old('status', $faq->status) === 'Show' ? 'selected' : '' }}>Show</option>
                    <option value="Hide" {{ old('status', $faq->status) === 'Hide' ? 'selected' : '' }}>Hide</option>
                </select>
            </div>
        </div>

        <div style="display: flex; gap: 10px; margin-top: 24px;">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.faqs.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
