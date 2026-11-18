@extends('admin.layouts.app')

@section('title', 'Edit Akun Pengguna')
@section('page-title', 'Edit Akun: ' . ($user->nama ?: $user->username))

@section('content')
<div style="max-width: 650px;">
    <div style="margin-bottom: 20px;">
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm" style="display:inline-flex; align-items:center; gap:4px;">
            <span class="material-symbols-outlined" style="font-size:16px;">arrow_back</span>
            Kembali ke Daftar Akun
        </a>
    </div>

    @if($errors->any())
        <div style="background:#fee2e2; border:1px solid #fecaca; color:#991b1b; padding:12px 16px; border-radius:10px; margin-bottom:20px; font-size:13px;">
            <strong>Terjadi kesalahan:</strong>
            <ul style="margin:6px 0 0; padding-left:20px;">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card" style="border-radius:14px; padding:28px;">
        <form method="POST" action="{{ route('admin.users.update', $user) }}">
            @csrf
            @method('PUT')

            <h3 style="font-size:15px; font-weight:700; color:#0f172a; margin:0 0 16px; display:flex; align-items:center; gap:8px;">
                <span class="material-symbols-outlined" style="color:#2563eb;">badge</span>
                Informasi Profil Akun
            </h3>

            <div class="form-group">
                <label>Nama Lengkap *</label>
                <input type="text" name="nama" value="{{ old('nama', $user->nama) }}" required placeholder="Contoh: Muhammad Budi">
            </div>

            <div class="form-group">
                <label>Username *</label>
                <input type="text" name="username" value="{{ old('username', $user->username) }}" required placeholder="budi_finance">
            </div>

            <div class="form-group">
                <label>Alamat Email *</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required placeholder="budi@indoconsulting.id">
            </div>

            <div class="form-group">
                <label>Hak Akses (Role) *</label>
                @if($user->id === auth()->id())
                    <input type="hidden" name="level" value="super_admin">
                    <select disabled style="background:#f8fafc; color:#64748b; cursor:not-allowed;">
                        <option selected>Super Admin (Akun Anda Sendiri)</option>
                    </select>
                    <div style="font-size:11px; color:#d97706; margin-top:4px;">* Anda tidak dapat menurunkan hak akses akun Anda sendiri.</div>
                @else
                    <select name="level" required>
                        <option value="admin" {{ old('level', $user->level) === 'admin' ? 'selected' : '' }}>Admin (Operasional & Konten Website)</option>
                        <option value="finance" {{ old('level', $user->level) === 'finance' ? 'selected' : '' }}>Finance (Khusus Keuangan & Kas)</option>
                        <option value="super_admin" {{ old('level', $user->level) === 'super_admin' ? 'selected' : '' }}>Super Admin (Akses Penuh Seluruh Sistem)</option>
                    </select>
                @endif
            </div>

            <div style="margin:24px 0 16px; padding-top:16px; border-top:1px dashed #e2e8f0;">
                <h3 style="font-size:15px; font-weight:700; color:#0f172a; margin:0 0 6px; display:flex; align-items:center; gap:8px;">
                    <span class="material-symbols-outlined" style="color:#4f46e5;">lock_reset</span>
                    Ganti Kata Sandi (Opsional)
                </h3>
                <div style="font-size:12px; color:#64748b; margin-bottom:16px;">
                    Kosongkan kedua kolom di bawah jika Anda tidak ingin mengubah password akun ini.
                </div>

                <div class="form-group">
                    <label>Password Baru</label>
                    <input type="password" name="password" placeholder="Minimal 6 karakter jika ingin ganti" autocomplete="new-password">
                </div>

                <div class="form-group">
                    <label>Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" placeholder="Ulangi password baru" autocomplete="new-password">
                </div>
            </div>

            <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:24px;">
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary" style="background:#2563eb; border-color:#2563eb;">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection

