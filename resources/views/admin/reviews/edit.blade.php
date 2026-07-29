@extends('admin.layouts.app')

@section('title', 'Edit Testimoni')
@section('page-title', 'Edit Testimoni')

@section('content')
<div class="card" style="max-width: 720px;">
    <form method="POST" action="{{ route('admin.reviews.update', $review) }}">
        @csrf @method('PUT')

        <div class="form-row">
            <div class="form-group">
                <label>Nama *</label>
                <input type="text" name="nama" value="{{ old('nama', $review->nama) }}" required>
            </div>
            <div class="form-group">
                <label>Pekerjaan</label>
                <input type="text" name="pekerjaan" value="{{ old('pekerjaan', $review->pekerjaan) }}">
            </div>
        </div>

        <div class="form-group">
            <label>Review *</label>
            <textarea name="review" rows="4" required>{{ old('review', $review->review) }}</textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Bintang (1-5)</label>
                <select name="stars">
                    <option value="">-- Pilih --</option>
                    @for($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}" {{ old('stars', $review->stars) == $i ? 'selected' : '' }}>{{ $i }} ⭐</option>
                    @endfor
                </select>
            </div>
            <div class="form-group">
                <label>Status *</label>
                <select name="status" required>
                    <option value="Show" {{ old('status', $review->status) === 'Show' ? 'selected' : '' }}>Show</option>
                    <option value="Hide" {{ old('status', $review->status) === 'Hide' ? 'selected' : '' }}>Hide</option>
                </select>
            </div>
        </div>

        <div style="display: flex; gap: 10px; margin-top: 24px;">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
