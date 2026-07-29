@extends('admin.layouts.app')

@section('title', 'Konten Halaman')
@section('page-title', 'Konten Halaman')

@include('admin.partials.image-upload-assets')

@section('content')
<p style="font-size: 13px; color: #64748b; margin-bottom: 20px;">
    Edit teks, heading, dan foto yang tampil di setiap halaman website.
</p>

{{-- Tab Navigation --}}
<div style="display: flex; gap: 4px; margin-bottom: 24px; overflow-x: auto; padding-bottom: 4px;">
    @foreach($pages as $page)
        <a href="{{ route('admin.page-contents.index', ['page' => $page]) }}"
           class="btn {{ $currentPage === $page ? 'btn-primary' : 'btn-secondary' }}"
           style="white-space: nowrap; font-size: 12px;">
            {{ ucwords(str_replace('-', ' ', $page)) }}
        </a>
    @endforeach
</div>

<div class="card">
    <form method="POST" action="{{ route('admin.page-contents.update') }}" enctype="multipart/form-data" id="page-content-form">
        @csrf
        <input type="hidden" name="page" value="{{ $currentPage }}">

        <h3 style="font-size: 16px; font-weight: 600; color: #020220; margin-bottom: 20px;">
            Konten: {{ ucwords(str_replace('-', ' ', $currentPage)) }}
        </h3>

        @if($contents->isEmpty())
            <p style="color: #94a3b8; font-size: 14px; padding: 20px 0;">
                Belum ada konten untuk halaman ini. Konten akan ditambahkan otomatis saat website dihubungkan ke database.
            </p>
        @else
            @php
                // Kelompokkan konten berdasarkan prefix key
                $grouped = $contents->groupBy(function($item) {
                    $parts = explode('_', $item->key);
                    return $parts[0];
                });
            @endphp

            @foreach($contents as $content)
                <div class="form-group">
                    <label style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.3px; font-weight: 600; display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                        {{ str_replace('_', ' ', $content->key) }}
                        <span style="color: #94a3b8; font-weight: 400; text-transform: none; letter-spacing: 0; font-size: 11px; background: #f1f5f9; padding: 2px 8px; border-radius: 4px;">{{ $content->type }}</span>
                    </label>

                    @if($content->type === 'image')
                        {{-- ─── IMAGE UPLOAD WIDGET ─── --}}
                        @include('admin.partials.image-upload-widget', [
                            'name' => 'files[' . $content->key . ']',
                            'key'  => $content->key,
                            'value' => $content->value,
                            'arrayInput' => true
                        ])

                    @elseif($content->type === 'textarea' || strlen($content->value ?? '') > 80)
                        <textarea name="contents[{{ $content->key }}]" rows="3" style="width: 100%; padding: 10px 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-family: 'Outfit', sans-serif; font-size: 14px;">{{ old('contents.' . $content->key, $content->value) }}</textarea>
                    @else
                        <input type="text" name="contents[{{ $content->key }}]" value="{{ old('contents.' . $content->key, $content->value) }}" style="width: 100%; padding: 10px 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-family: 'Outfit', sans-serif; font-size: 14px;">
                    @endif
                </div>
            @endforeach
        @endif

        <div style="margin-top: 24px; display: flex; align-items: center; gap: 12px;">
            <button type="submit" class="btn btn-primary" style="padding: 10px 28px;">
                <span class="material-symbols-outlined">save</span> Simpan Konten
            </button>
            <span id="form-saving" style="display:none; font-size:13px; color:#64748b;">
                <span class="material-symbols-outlined" style="font-size:15px; vertical-align: middle; animation: spin 1s linear infinite;">refresh</span>
                Menyimpan...
            </span>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Spin animation for save button
    document.getElementById('page-content-form').addEventListener('submit', function () {
        document.getElementById('form-saving').style.display = 'inline-flex';
    });
});
const style = document.createElement('style');
style.textContent = '@keyframes spin { to { transform: rotate(360deg); } }';
document.head.appendChild(style);
</script>
@endpush

@endsection
