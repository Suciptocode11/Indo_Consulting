@extends('admin.layouts.app')

@section('title', 'Edit Expert')
@section('page-title', 'Edit Expert/Team')

@section('content')
<div class="card" style="max-width: 720px;">
    <form method="POST" action="{{ route('admin.members.update', $member) }}" enctype="multipart/form-data">
        @csrf @method('PUT')

        <h3 style="font-size: 14px; font-weight: 600; color: #64748b; margin-bottom: 16px; text-transform: uppercase; letter-spacing: 0.5px;">Data Pribadi</h3>

        <div class="form-row">
            <div class="form-group">
                <label>Nama Lengkap *</label>
                <input type="text" name="nama" value="{{ old('nama', $member->nama) }}" required>
            </div>
            <div class="form-group">
                <label>Jabatan</label>
                <input type="text" name="jabatan" value="{{ old('jabatan', $member->jabatan) }}">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email', $member->email) }}">
            </div>
            <div class="form-group">
                <label>WhatsApp</label>
                <input type="text" name="wa" value="{{ old('wa', $member->wa) }}">
            </div>
        </div>

        <div class="form-group">
            <label>Alamat</label>
            <textarea name="alamat" rows="2">{{ old('alamat', $member->alamat) }}</textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Foto Profil</label>
                @if($member->foto)
                    <div style="margin-bottom: 8px;">
                        <img src="{{ asset('storage/' . $member->foto) }}" style="height: 80px; width: 80px; border-radius: 10px; object-fit: cover;">
                    </div>
                @endif
                <input type="file" name="foto" accept="image/*">
                <div class="help">Kosongkan jika tidak ingin mengganti.</div>
            </div>
            <div class="form-group">
                <label>CV (PDF)</label>
                @if($member->cv)
                    <div style="margin-bottom: 8px;">
                        <a href="{{ asset('storage/' . $member->cv) }}" target="_blank" class="btn btn-secondary btn-sm">
                            <span class="material-symbols-outlined">description</span> Lihat CV
                        </a>
                    </div>
                @endif
                <input type="file" name="cv" accept=".pdf">
            </div>
        </div>

        <hr style="margin: 24px 0; border: none; border-top: 1px solid #e2e8f0;">

        <h3 style="font-size: 14px; font-weight: 600; color: #64748b; margin-bottom: 16px; text-transform: uppercase; letter-spacing: 0.5px;">Profil Profesional</h3>

        <div class="form-group">
            <label>Profil Singkat</label>
            <textarea name="profil" class="summernote">{{ old('profil', $member->profil) }}</textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Pendidikan</label>
                <input type="text" name="pendidikan" value="{{ old('pendidikan', $member->pendidikan) }}">
            </div>
            <div class="form-group">
                <label>Pengalaman</label>
                <input type="text" name="pengalaman" value="{{ old('pengalaman', $member->pengalaman) }}">
            </div>
        </div>

        <div class="form-group">
            <label>Keahlian</label>
            <textarea name="keahlian" rows="3">{{ old('keahlian', $member->keahlian) }}</textarea>
        </div>

        <div class="form-group">
            <label>Penunjang / Sertifikasi</label>
            <textarea name="penunjang" rows="2">{{ old('penunjang', $member->penunjang) }}</textarea>
        </div>

        <hr style="margin: 24px 0; border: none; border-top: 1px solid #e2e8f0;">

        <h3 style="font-size: 14px; font-weight: 600; color: #64748b; margin-bottom: 16px; text-transform: uppercase; letter-spacing: 0.5px;">Sosial Media</h3>

        <div class="form-row">
            <div class="form-group">
                <label>Instagram</label>
                <input type="url" name="instagram" value="{{ old('instagram', $member->instagram) }}">
            </div>
            <div class="form-group">
                <label>LinkedIn</label>
                <input type="url" name="linkedin" value="{{ old('linkedin', $member->linkedin) }}">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Twitter / X</label>
                <input type="url" name="twitter" value="{{ old('twitter', $member->twitter) }}">
            </div>
            <div class="form-group">
                <label>YouTube</label>
                <input type="url" name="youtube" value="{{ old('youtube', $member->youtube) }}">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Facebook</label>
                <input type="url" name="facebook" value="{{ old('facebook', $member->facebook) }}">
            </div>
            <div class="form-group">
                <label>Situs Web</label>
                <input type="url" name="situs" value="{{ old('situs', $member->situs) }}">
            </div>
        </div>

        <hr style="margin: 24px 0; border: none; border-top: 1px solid #e2e8f0;">

        <div class="form-row">
            <div class="form-group">
                <label>Slug</label>
                <input type="text" name="slug" value="{{ old('slug', $member->slug) }}">
            </div>
            <div class="form-group">
                <label>ID Group</label>
                <input type="text" name="id_group" value="{{ old('id_group', $member->id_group) }}">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Status *</label>
                <select name="status" required>
                    <option value="Show" {{ old('status', $member->status) === 'Show' ? 'selected' : '' }}>Show</option>
                    <option value="Hide" {{ old('status', $member->status) === 'Hide' ? 'selected' : '' }}>Hide</option>
                </select>
            </div>
        </div>

        <div style="display: flex; gap: 10px; margin-top: 24px;">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.members.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
