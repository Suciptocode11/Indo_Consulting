@extends('admin.layouts.app')

@section('title', 'Pengaturan')
@section('page-title', 'Pengaturan Umum')

@section('content')
<div class="card" style="max-width: 720px;">
    <form method="POST" action="{{ route('admin.pengaturan.update') }}" enctype="multipart/form-data">
        @csrf @method('PUT')

        <h3 style="font-size: 14px; font-weight: 600; color: #64748b; margin-bottom: 16px; text-transform: uppercase; letter-spacing: 0.5px;">Informasi Perusahaan</h3>

        <div class="form-group">
            <label>Nama Perusahaan</label>
            <input type="text" name="company" value="{{ old('company', $pengaturan->company) }}" placeholder="Indo Consulting">
        </div>

        <div class="form-group">
            <label>Alamat</label>
            <textarea name="address" rows="2">{{ old('address', $pengaturan->address) }}</textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Telepon / WhatsApp</label>
                <input type="text" name="phone" value="{{ old('phone', $pengaturan->phone) }}" placeholder="+62 8xx-xxxx-xxxx">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email', $pengaturan->email) }}" placeholder="partner@indoconsulting.id">
            </div>
        </div>

        <div class="form-group">
            <label>Website URL</label>
            <input type="url" name="website" value="{{ old('website', $pengaturan->website) }}" placeholder="https://indoconsulting.id">
        </div>

        <hr style="margin: 24px 0; border: none; border-top: 1px solid #e2e8f0;">

        <h3 style="font-size: 14px; font-weight: 600; color: #64748b; margin-bottom: 16px; text-transform: uppercase; letter-spacing: 0.5px;">Logo & Google Maps</h3>

        <div class="form-group">
            <label>Logo Perusahaan</label>
            @if($pengaturan->logo)
                <div style="margin-bottom: 10px;">
                    <img src="{{ asset('storage/' . $pengaturan->logo) }}" style="height: 60px; border-radius: 8px; object-fit: contain; background: #f8fafc; padding: 8px;">
                </div>
            @endif
            <input type="file" name="logo" accept="image/*">
            <div class="help">Format: JPG, PNG, WebP. Max 2MB. Kosongkan jika tidak ingin mengganti.</div>
        </div>

        <div class="form-group">
            <label>Embed URL Google Maps</label>
            <input type="url" name="map" value="{{ old('map', $pengaturan->map) }}" placeholder="https://www.google.com/maps/embed?pb=...">
            <div class="help">Cara mendapatkan: Buka Google Maps → Klik Share → Embed a map → Copy URL (bagian src="..." saja, bukan seluruh iframe).</div>
        </div>

        <hr style="margin: 24px 0; border: none; border-top: 1px solid #e2e8f0;">

        <h3 style="font-size: 14px; font-weight: 600; color: #64748b; margin-bottom: 16px; text-transform: uppercase; letter-spacing: 0.5px;">Footer</h3>

        <div class="form-group">
            <label>Teks Copyright</label>
            <input type="text" name="copyright" value="{{ old('copyright', $pengaturan->copyright) }}" placeholder="© 2026 Indo Consulting. Hak cipta dilindungi.">
        </div>

        <div style="display: flex; gap: 10px; margin-top: 28px;">
            <button type="submit" class="btn btn-primary" style="padding: 10px 28px;">
                <span class="material-symbols-outlined">save</span> Simpan Pengaturan
            </button>
        </div>
    </form>
</div>
@endsection
