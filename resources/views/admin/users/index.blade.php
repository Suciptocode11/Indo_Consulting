@extends('admin.layouts.app')

@section('title', 'Kelola Akun Pengguna')
@section('page-title', 'Kelola Akun Pengguna')

@push('styles')
<style>
    .users-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 24px;
    }
    .users-title {
        font-size: 20px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
    }
    .users-sub {
        font-size: 13px;
        color: #64748b;
        margin: 4px 0 0;
    }
    .btn-add-user {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 9px 18px;
        border-radius: 10px;
        background: #bb0027;
        color: #fff;
        font-weight: 600;
        font-size: 13px;
        border: none;
        cursor: pointer;
        transition: background .15s;
    }
    .btn-add-user:hover {
        background: #990020;
    }

    /* Filter Bar */
    .filter-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 14px 18px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
    }

    /* Badges */
    .badge-role-super {
        background: #fee2e2;
        color: #b91c1c;
        border: 1px solid #fecaca;
    }
    .badge-role-admin {
        background: #dbeafe;
        color: #1d4ed8;
        border: 1px solid #bfdbfe;
    }
    .badge-role-finance {
        background: #fef3c7;
        color: #b45309;
        border: 1px solid #fde68a;
    }

    /* Modal styling */
    .modal-backdrop-custom {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(4px);
        z-index: 1000;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 16px;
    }
    .modal-box-custom {
        background: #fff;
        border-radius: 16px;
        width: 100%;
        max-width: 500px;
        box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
        overflow: hidden;
        animation: modalScale .2s ease-out;
    }
    @keyframes modalScale {
        from { transform: scale(0.95); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }
    .modal-header-custom {
        padding: 18px 24px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .modal-body-custom {
        padding: 22px 24px;
        max-height: calc(85vh - 120px);
        overflow-y: auto;
    }
    .modal-footer-custom {
        padding: 14px 24px;
        background: #f8fafc;
        border-top: 1px solid #f1f5f9;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }
</style>
@endpush

@section('content')
<div>
    {{-- Header --}}
    <div class="users-header">
        <div>
            <h1 class="users-title">Kelola Akun Pengguna Back Office</h1>
            <p class="users-sub">Manajemen kredensial, hak akses, dan kata sandi seluruh staf & administrator</p>
        </div>
        <button type="button" class="btn-add-user" onclick="openModalAddUser()">
            <span class="material-symbols-outlined" style="font-size:18px;">person_add</span>
            Tambah Akun Baru
        </button>
    </div>

    {{-- Filter Bar --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('admin.users.index') }}" style="display:flex; gap:10px; flex-wrap:wrap; align-items:center; flex:1;">
            <div style="flex:1; min-width:200px; position:relative;">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, username, atau email..."
                       style="width:100%; padding:8px 12px; border:1px solid #cbd5e1; border-radius:8px; font-size:13px; font-family:inherit;">
            </div>
            <div>
                <select name="level" onchange="this.form.submit()" style="padding:8px 12px; border:1px solid #cbd5e1; border-radius:8px; font-size:13px; font-family:inherit; background:#fff;">
                    <option value="">Semua Role / Hak Akses</option>
                    <option value="super_admin" {{ request('level') === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                    <option value="admin"       {{ request('level') === 'admin' ? 'selected' : '' }}>Admin (Konten)</option>
                    <option value="finance"     {{ request('level') === 'finance' ? 'selected' : '' }}>Finance (Keuangan)</option>
                </select>
            </div>
            <button type="submit" class="btn btn-secondary btn-sm" style="padding:8px 14px;">Filter</button>
            @if(request('search') || request('level'))
                <a href="{{ route('admin.users.index') }}" style="font-size:12px; color:#dc2626; text-decoration:none; display:inline-flex; align-items:center; gap:2px;">
                    <span class="material-symbols-outlined" style="font-size:14px;">close</span> Reset
                </a>
            @endif
        </form>
    </div>

    {{-- Validation Error Alert --}}
    @if($errors->any())
        <div style="background:#fee2e2; border:1px solid #fecaca; color:#991b1b; padding:12px 16px; border-radius:10px; margin-bottom:20px; font-size:13px;">
            <strong><span class="material-symbols-outlined" style="font-size:16px; vertical-align:middle;">error</span> Terjadi kesalahan:</strong>
            <ul style="margin:6px 0 0; padding-left:20px;">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Table Card --}}
    <div class="card" style="padding:0; overflow:hidden; border-radius:14px;">
        <div style="overflow-x:auto;">
            <table class="data-table" style="width:100%; border-collapse:collapse;">
                <thead>
                    <tr>
                        <th style="width:40px; text-align:center;">#</th>
                        <th style="min-width:220px;">Nama & Kredensial</th>
                        <th style="min-width:180px;">Email</th>
                        <th style="min-width:140px; text-align:center;">Hak Akses (Role)</th>
                        <th style="min-width:120px; text-align:center;">Status Akun</th>
                        <th style="min-width:140px; text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $u)
                        @php
                            $isSelf = ($u->id === auth()->id());
                        @endphp
                        <tr>
                            <td style="text-align:center; color:#94a3b8; font-weight:600;">
                                {{ $users->firstItem() + $loop->index }}
                            </td>
                            <td>
                                <div style="display:flex; align-items:center; gap:10px;">
                                    <div style="width:36px; height:36px; border-radius:50%; background:#f1f5f9; display:flex; align-items:center; justify-content:center; color:#475569; font-weight:700; font-size:14px; flex-shrink:0;">
                                        {{ strtoupper(substr($u->nama ?: $u->username, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div style="font-weight:700; color:#0f172a; font-size:13px;">
                                            {{ $u->nama ?: '—' }}
                                            @if($isSelf)
                                                <span style="font-size:10px; background:#e0e7ff; color:#4338ca; padding:1px 6px; border-radius:10px; margin-left:4px; font-weight:700;">Anda</span>
                                            @endif
                                        </div>
                                        <div style="font-family:monospace; font-size:11px; color:#64748b; margin-top:1px;">
                                            @<span>{{ $u->username }}</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td style="font-size:13px; color:#334155;">
                                {{ $u->email }}
                            </td>
                            <td style="text-align:center;">
                                @if($u->isSuperAdmin())
                                    <span class="badge badge-role-super" style="padding:4px 10px; border-radius:20px; font-size:11px; font-weight:700; display:inline-flex; align-items:center; gap:4px;">
                                        <span class="material-symbols-outlined" style="font-size:14px;">shield_person</span>
                                        Super Admin
                                    </span>
                                @elseif($u->isFinance())
                                    <span class="badge badge-role-finance" style="padding:4px 10px; border-radius:20px; font-size:11px; font-weight:700; display:inline-flex; align-items:center; gap:4px;">
                                        <span class="material-symbols-outlined" style="font-size:14px;">payments</span>
                                        Finance
                                    </span>
                                @else
                                    <span class="badge badge-role-admin" style="padding:4px 10px; border-radius:20px; font-size:11px; font-weight:700; display:inline-flex; align-items:center; gap:4px;">
                                        <span class="material-symbols-outlined" style="font-size:14px;">manage_accounts</span>
                                        Admin
                                    </span>
                                @endif
                            </td>
                            <td style="text-align:center;">
                                <span style="display:inline-flex; align-items:center; gap:4px; font-size:12px; color:#16a34a; font-weight:600;">
                                    <span class="material-symbols-outlined" style="font-size:14px;">check_circle</span>
                                    Aktif
                                </span>
                            </td>
                            <td style="text-align:center; white-space:nowrap;">
                                <div style="display:inline-flex; gap:6px; align-items:center;">
                                    <button type="button" class="btn btn-secondary btn-sm"
                                            onclick="openModalEditUser({{ json_encode([
                                                'id'       => $u->id,
                                                'nama'     => $u->nama,
                                                'username' => $u->username,
                                                'email'    => $u->email,
                                                'level'    => $u->level,
                                                'is_self'  => $isSelf,
                                            ]) }})"
                                            title="Edit Profil & Ganti Password">
                                        <span class="material-symbols-outlined" style="font-size:15px;">edit</span>
                                        <span>Edit</span>
                                    </button>

                                    @if(!$isSelf)
                                        <form method="POST" action="{{ route('admin.users.destroy', $u) }}"
                                              onsubmit="return confirm('Yakin ingin menghapus akun [{{ $u->username }}]? Tindakan ini tidak dapat dibatalkan.');" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus Akun">
                                                <span class="material-symbols-outlined" style="font-size:15px;">delete</span>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center; padding:40px; color:#94a3b8;">
                                <span class="material-symbols-outlined" style="font-size:36px; display:block; margin-bottom:8px;">group_off</span>
                                Tidak ada akun pengguna yang sesuai dengan filter pencarian.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div style="margin-top:16px;">
        {{ $users->links() }}
    </div>
</div>

{{-- MODAL 1: Tambah Akun Baru --}}
<div id="modalAddUser" class="modal-backdrop-custom" style="display:none;">
    <div class="modal-box-custom">
        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf
            <div class="modal-header-custom">
                <h3 style="font-size:16px; font-weight:700; color:#0f172a; margin:0; display:flex; align-items:center; gap:8px;">
                    <span class="material-symbols-outlined" style="color:#bb0027;">person_add</span>
                    Tambah Akun Pengguna Baru
                </h3>
                <button type="button" onclick="closeModalAddUser()" style="background:none; border:none; cursor:pointer; color:#94a3b8; font-size:20px;">&times;</button>
            </div>
            <div class="modal-body-custom">
                <div class="form-group">
                    <label>Nama Lengkap *</label>
                    <input type="text" name="nama" required placeholder="Contoh: Muhammad Budi" value="{{ old('nama') }}">
                </div>
                <div class="form-group">
                    <label>Username *</label>
                    <input type="text" name="username" required placeholder="Contoh: budi_finance" value="{{ old('username') }}">
                    <div style="font-size:11px; color:#94a3b8; margin-top:4px;">Gunakan huruf kecil, angka, dan underscore tanpa spasi.</div>
                </div>
                <div class="form-group">
                    <label>Alamat Email *</label>
                    <input type="email" name="email" required placeholder="budi@indoconsulting.id" value="{{ old('email') }}">
                </div>
                <div class="form-group">
                    <label>Hak Akses (Role) *</label>
                    <select name="level" required>
                        <option value="admin" {{ old('level') === 'admin' ? 'selected' : '' }}>Admin (Operasional & Konten Website)</option>
                        <option value="finance" {{ old('level') === 'finance' ? 'selected' : '' }}>Finance (Khusus Keuangan & Kas)</option>
                        <option value="super_admin" {{ old('level') === 'super_admin' ? 'selected' : '' }}>Super Admin (Akses Penuh Seluruh Sistem)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Kata Sandi (Password) *</label>
                    <input type="password" name="password" required placeholder="Minimal 6 karakter" autocomplete="new-password">
                </div>
                <div class="form-group" style="margin-bottom:0;">
                    <label>Konfirmasi Kata Sandi *</label>
                    <input type="password" name="password_confirmation" required placeholder="Ulangi kata sandi di atas" autocomplete="new-password">
                </div>
            </div>
            <div class="modal-footer-custom">
                <button type="button" class="btn btn-secondary" onclick="closeModalAddUser()">Batal</button>
                <button type="submit" class="btn btn-primary" style="background:#bb0027; border-color:#bb0027;">Simpan Akun Baru</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL 2: Edit Akun & Ganti Password --}}
<div id="modalEditUser" class="modal-backdrop-custom" style="display:none;">
    <div class="modal-box-custom">
        <form id="formEditUser" method="POST" action="">
            @csrf
            @method('PUT')
            <div class="modal-header-custom">
                <h3 style="font-size:16px; font-weight:700; color:#0f172a; margin:0; display:flex; align-items:center; gap:8px;">
                    <span class="material-symbols-outlined" style="color:#2563eb;">manage_accounts</span>
                    Edit Akun & Ganti Password
                </h3>
                <button type="button" onclick="closeModalEditUser()" style="background:none; border:none; cursor:pointer; color:#94a3b8; font-size:20px;">&times;</button>
            </div>
            <div class="modal-body-custom">
                <div class="form-group">
                    <label>Nama Lengkap *</label>
                    <input type="text" id="editNama" name="nama" required>
                </div>
                <div class="form-group">
                    <label>Username *</label>
                    <input type="text" id="editUsername" name="username" required>
                </div>
                <div class="form-group">
                    <label>Alamat Email *</label>
                    <input type="email" id="editEmail" name="email" required>
                </div>
                <div class="form-group" id="groupEditLevel">
                    <label>Hak Akses (Role) *</label>
                    <select id="editLevel" name="level" required>
                        <option value="admin">Admin (Operasional & Konten Website)</option>
                        <option value="finance">Finance (Khusus Keuangan & Kas)</option>
                        <option value="super_admin">Super Admin (Akses Penuh Seluruh Sistem)</option>
                    </select>
                    <div id="selfRoleNote" style="font-size:11px; color:#d97706; margin-top:4px; display:none;">
                        * Hak akses akun Anda sendiri tetap Super Admin untuk mencegah terkunci dari sistem.
                    </div>
                </div>

                <div style="margin:20px 0 14px; padding-top:14px; border-top:1px dashed #e2e8f0;">
                    <div style="font-size:13px; font-weight:700; color:#0f172a; margin-bottom:4px; display:flex; align-items:center; gap:6px;">
                        <span class="material-symbols-outlined" style="font-size:16px; color:#4f46e5;">lock_reset</span>
                        Ganti Kata Sandi (Opsional)
                    </div>
                    <div style="font-size:12px; color:#64748b; margin-bottom:12px;">Kosongkan jika Anda tidak ingin mengubah password akun ini.</div>

                    <div class="form-group">
                        <label>Password Baru</label>
                        <input type="password" name="password" placeholder="Minimal 6 karakter jika ingin ganti" autocomplete="new-password">
                    </div>
                    <div class="form-group" style="margin-bottom:0;">
                        <label>Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" placeholder="Ulangi password baru" autocomplete="new-password">
                    </div>
                </div>
            </div>
            <div class="modal-footer-custom">
                <button type="button" class="btn btn-secondary" onclick="closeModalEditUser()">Batal</button>
                <button type="submit" class="btn btn-primary" style="background:#2563eb; border-color:#2563eb;">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openModalAddUser() {
        document.getElementById('modalAddUser').style.display = 'flex';
    }
    function closeModalAddUser() {
        document.getElementById('modalAddUser').style.display = 'none';
    }

    function openModalEditUser(user) {
        const form = document.getElementById('formEditUser');
        form.action = `/admin/users/${user.id}`;

        document.getElementById('editNama').value = user.nama || '';
        document.getElementById('editUsername').value = user.username || '';
        document.getElementById('editEmail').value = user.email || '';
        document.getElementById('editLevel').value = user.level || 'admin';

        const selectLevel = document.getElementById('editLevel');
        const selfNote = document.getElementById('selfRoleNote');

        if (user.is_self) {
            selectLevel.value = 'super_admin';
            selfNote.style.display = 'block';
        } else {
            selfNote.style.display = 'none';
        }

        document.getElementById('modalEditUser').style.display = 'flex';
    }

    function closeModalEditUser() {
        document.getElementById('modalEditUser').style.display = 'none';
    }

    // Close modal on backdrop click
    window.addEventListener('click', function(e) {
        if (e.target.classList.contains('modal-backdrop-custom')) {
            e.target.style.display = 'none';
        }
    });
</script>
@endpush
@endsection

