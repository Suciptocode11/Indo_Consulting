@extends('admin.layouts.app')

@section('title', 'Tambah Expert')
@section('page-title', 'Tambah Expert/Team')

@section('content')
<div class="card" style="max-width: 720px;">
    <form method="POST" action="{{ route('admin.members.store') }}" enctype="multipart/form-data">
        @csrf

        <h3 style="font-size: 14px; font-weight: 600; color: #64748b; margin-bottom: 16px; text-transform: uppercase; letter-spacing: 0.5px;">Data Pribadi</h3>

        <div class="form-row">
            <div class="form-group">
                <label>Nama Lengkap *</label>
                <input type="text" name="nama" value="{{ old('nama') }}" required>
            </div>
            <div class="form-group">
                <label>Jabatan</label>
                <input type="text" name="jabatan" value="{{ old('jabatan') }}" placeholder="Contoh: Konsultan Senior">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}">
            </div>
            <div class="form-group">
                <label>WhatsApp</label>
                <input type="text" name="wa" value="{{ old('wa') }}" placeholder="+62 8xx-xxxx-xxxx">
            </div>
        </div>

        <div class="form-group">
            <label>Alamat</label>
            <textarea name="alamat" rows="2">{{ old('alamat') }}</textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Foto Profil</label>
                <input type="file" name="foto" accept="image/*">
                <div class="help">Format: JPG, PNG, WebP. Max 2MB.</div>
            </div>
            <div class="form-group">
                <label>CV (PDF)</label>
                <input type="file" name="cv" accept=".pdf">
                <div class="help">Format: PDF. Max 5MB.</div>
            </div>
        </div>

        <hr style="margin: 24px 0; border: none; border-top: 1px solid #e2e8f0;">

        <h3 style="font-size: 14px; font-weight: 600; color: #64748b; margin-bottom: 16px; text-transform: uppercase; letter-spacing: 0.5px;">Profil Profesional</h3>

        <div class="form-group">
            <label>Profil Singkat</label>
            <textarea name="profil" class="summernote" placeholder="Biografi singkat about this expert">{{ old('profil') }}</textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Pendidikan</label>
                <input type="text" name="pendidikan" value="{{ old('pendidikan') }}" placeholder="S2 Manajemen, UI">
            </div>
            <div class="form-group">
                <label>Pengalaman</label>
                <input type="text" name="pengalaman" value="{{ old('pengalaman') }}" placeholder="15+ tahun di bidang HR">
            </div>
        </div>

        <div class="form-group">
            <label>Keahlian</label>
            <textarea name="keahlian" rows="3" placeholder="Pisahkan dengan koma: HR Management, Leadership, Change Management">{{ old('keahlian') }}</textarea>
        </div>

        <div class="form-group">
            <label>Penunjang / Sertifikasi</label>
            <textarea name="penunjang" rows="2" placeholder="Sertifikasi, pelatihan tambahan">{{ old('penunjang') }}</textarea>
        </div>

        <hr style="margin: 24px 0; border: none; border-top: 1px solid #e2e8f0;">

        <h3 style="font-size: 14px; font-weight: 600; color: #64748b; margin-bottom: 16px; text-transform: uppercase; letter-spacing: 0.5px;">Sosial Media</h3>

        <div class="form-row">
            <div class="form-group">
                <label>Instagram</label>
                <input type="url" name="instagram" value="{{ old('instagram') }}" placeholder="https://instagram.com/...">
            </div>
            <div class="form-group">
                <label>LinkedIn</label>
                <input type="url" name="linkedin" value="{{ old('linkedin') }}" placeholder="https://linkedin.com/in/...">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Twitter / X</label>
                <input type="url" name="twitter" value="{{ old('twitter') }}" placeholder="https://twitter.com/...">
            </div>
            <div class="form-group">
                <label>YouTube</label>
                <input type="url" name="youtube" value="{{ old('youtube') }}" placeholder="https://youtube.com/...">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Facebook</label>
                <input type="url" name="facebook" value="{{ old('facebook') }}" placeholder="https://facebook.com/...">
            </div>
            <div class="form-group">
                <label>Situs Web</label>
                <input type="url" name="situs" value="{{ old('situs') }}" placeholder="https://...">
            </div>
        </div>

        <hr style="margin: 24px 0; border: none; border-top: 1px solid #e2e8f0;">

        <div class="form-row">
            <div class="form-group">
                <label>Slug</label>
                <input type="text" name="slug" value="{{ old('slug') }}" placeholder="Otomatis dari nama">
            </div>
            <div class="form-group">
                <label>ID Group</label>
                <input type="text" name="id_group" value="{{ old('id_group') }}" placeholder="Kode grup expert">
            </div>
        </div>

        <div class="form-row">
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
            <a href="{{ route('admin.members.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
