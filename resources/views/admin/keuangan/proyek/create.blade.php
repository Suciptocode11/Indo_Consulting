@extends('admin.layouts.app')

@section('title', 'Tambah Kontrak Klien')
@section('page-title', 'Tambah Kontrak Klien')

@push('styles')
<style>
    .form-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 28px 32px;
        max-width: 860px;
    }
    .form-section-title {
        font-size: 14px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 16px;
        padding-bottom: 8px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .form-section-title .material-symbols-outlined {
        color: #bb0027;
        font-size: 18px;
    }
    .form-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px 20px;
        margin-bottom: 20px;
    }
    @media (max-width: 640px) {
        .form-grid-2 { grid-template-columns: 1fr; }
    }
    .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }
    .form-group.full {
        grid-column: 1 / -1;
    }
    .form-group label {
        font-size: 12px;
        font-weight: 600;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }
    .form-group label .req {
        color: #dc2626;
    }
    .form-control {
        padding: 9px 13px;
        border: 1px solid #cbd5e1;
        border-radius: 9px;
        font-family: 'Outfit', sans-serif;
        font-size: 13px;
        color: #0f172a;
        background: #fff;
        transition: border-color .15s, box-shadow .15s;
    }
    .form-control:focus {
        outline: none;
        border-color: #bb0027;
        box-shadow: 0 0 0 3px rgba(187,0,39,.1);
    }
    .form-control:read-only {
        background: #f8fafc;
        color: #64748b;
        cursor: not-allowed;
    }
    .input-group-rp {
        display: flex;
        align-items: stretch;
        width: 100%;
    }
    .input-group-addon-rp {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0 14px;
        background: #f1f5f9;
        color: #475569;
        font-weight: 700;
        font-size: 13px;
        border: 1px solid #cbd5e1;
        border-right: none;
        border-radius: 9px 0 0 9px;
        user-select: none;
        flex-shrink: 0;
    }
    .input-group-field-rp {
        flex: 1;
        border-radius: 0 9px 9px 0 !important;
        border: 1px solid #cbd5e1;
        padding: 10px 14px;
        font-size: 13px;
        font-family: 'Outfit', sans-serif;
        outline: none;
        background: #fff;
        color: #0f172a;
        font-weight: 600;
        transition: border-color .15s, box-shadow .15s;
        width: 100%;
    }
    .input-group-field-rp:focus {
        border-color: #bb0027;
        box-shadow: 0 0 0 3px rgba(187,0,39,.08);
    }
    .form-hint {
        font-size: 11px;
        color: #94a3b8;
    }
    .form-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 28px;
        padding-top: 20px;
        border-top: 1px solid #f1f5f9;
    }
    .btn-cancel {
        padding: 9px 18px;
        border-radius: 9px;
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
        background: #f1f5f9;
        text-decoration: none;
        transition: background .15s;
    }
    .btn-cancel:hover { background: #e2e8f0; }
    .btn-submit {
        padding: 9px 22px;
        border-radius: 9px;
        font-size: 13px;
        font-weight: 600;
        color: #fff;
        background: #bb0027;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background .15s;
    }
    .btn-submit:hover { background: #9a0020; }
</style>
@endpush

@section('content')
<div style="max-width: 860px; margin: 0 auto;">
    {{-- Header --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;flex-wrap:wrap;gap:12px;">
        <div>
            <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">Tambah Kontrak Klien Baru</h1>
            <p style="font-size:13px;color:#64748b;margin:4px 0 0;">Daftarkan kontrak proyek klien untuk memantau nilai proyek, termin pembayaran, dan biaya operasional</p>
        </div>
        <a href="{{ route('admin.keuangan.program.index') }}#daftar-kontrak" class="btn-cancel" style="display:inline-flex;align-items:center;gap:4px;">
            <span class="material-symbols-outlined" style="font-size:16px;">arrow_back</span>
            Kembali
        </a>
    </div>

    {{-- Validation Errors --}}
    @if($errors->any())
        <div style="background:#fee2e2;border:1px solid #fecaca;color:#b91c1c;padding:14px 18px;border-radius:12px;margin-bottom:20px;font-size:13px;">
            <strong style="display:block;margin-bottom:6px;">Terdapat kesalahan pada isian form:</strong>
            <ul style="margin:0;padding-left:18px;">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form Card --}}
    <div class="form-card">
        <form method="POST" action="{{ route('admin.keuangan.kontrak.store') }}" id="proyekForm">
            @csrf

            {{-- Bagian 1: Data Utama Kontrak --}}
            <div class="form-section-title">
                <span class="material-symbols-outlined">assignment</span>
                Informasi Kontrak Klien
            </div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label>Kode Kontrak</label>
                    <input type="text" class="form-control" value="{{ $kodeProyek }}" readonly>
                    <span class="form-hint">Dibuat otomatis oleh sistem</span>
                </div>

                <div class="form-group">
                    <label>Status Kontrak <span class="req">*</span></label>
                    <select name="status" class="form-control" required>
                        <option value="berjalan" {{ old('status') === 'berjalan' ? 'selected' : '' }}>Berjalan (Aktif)</option>
                        <option value="pending"  {{ old('status') === 'pending'  ? 'selected' : '' }}>Pending / Menunggu Kickoff</option>
                        <option value="selesai"  {{ old('status') === 'selesai'  ? 'selected' : '' }}>Selesai</option>
                        <option value="batal"    {{ old('status') === 'batal'    ? 'selected' : '' }}>Batal</option>
                    </select>
                </div>

                <div class="form-group full">
                    <label>Nama Proyek / Pekerjaan <span class="req">*</span></label>
                    <input type="text" name="nama_proyek" class="form-control" value="{{ old('nama_proyek') }}"
                           placeholder="Contoh: Pendampingan Akreditasi & Restrukturisasi SOP" required>
                </div>

                <div class="form-group">
                    <label>Nama Klien / Perusahaan <span class="req">*</span></label>
                    <input type="text" name="nama_klien" class="form-control" value="{{ old('nama_klien') }}"
                           placeholder="Contoh: PT Semen Indonesia (Persero) Tbk" required>
                </div>

                <div class="form-group">
                    <label>PIC / Penanggung Jawab Konsultan</label>
                    <input type="text" name="pic" class="form-control" value="{{ old('pic') }}"
                           placeholder="Contoh: Bpk. Bagas Pratama, S.H.">
                </div>

                <div class="form-group">
                    <label>Kontak PIC Klien</label>
                    <input type="text" name="kontak_klien" class="form-control" value="{{ old('kontak_klien') }}"
                           placeholder="Contoh: Bpk. Bambang - 08123456789">
                </div>

                <div class="form-group">
                    <label>Kategori Program / Layanan</label>
                    <select name="service_id" class="form-control">
                        <option value="">-- Pilih Layanan (Opsional) --</option>
                        @foreach($services as $svc)
                            <option value="{{ $svc->id }}" {{ old('service_id') == $svc->id ? 'selected' : '' }}>
                                {{ $svc->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Nilai Proyek / Harga Kontrak <span class="req">*</span></label>
                    <div class="input-group-rp">
                        <span class="input-group-addon-rp">Rp</span>
                        <input type="text" id="nilai_kontrak_display" class="input-group-field-rp"
                               placeholder="0" value="{{ old('nilai_kontrak') ? number_format(old('nilai_kontrak'), 0, ',', '.') : '' }}" required>
                    </div>
                    <input type="hidden" name="nilai_kontrak" id="nilai_kontrak" value="{{ old('nilai_kontrak', 0) }}">
                    <span class="form-hint">Total nilai kesepakatan harga proyek</span>
                </div>
            </div>

            {{-- Bagian 2: Periode Kontrak --}}
            <div class="form-section-title" style="margin-top:28px;">
                <span class="material-symbols-outlined">calendar_month</span>
                Jadwal & Periode Proyek
            </div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label>Tanggal Mulai <span class="req">*</span></label>
                    <input type="date" name="tanggal_mulai" class="form-control datepicker" value="{{ old('tanggal_mulai', date('Y-m-d')) }}" required>
                </div>

                <div class="form-group">
                    <label>Target Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" class="form-control datepicker" value="{{ old('tanggal_selesai') }}">
                </div>

                <div class="form-group full">
                    <label>Deskripsi <span style="font-weight:400; color:#94a3b8;">(opsional)</span></label>
                    <textarea name="deskripsi" rows="3" class="form-control" placeholder="Deskripsi ruang lingkup pekerjaan, catatan kesepakatan, syarat termin, dsb...">{{ old('deskripsi', old('keterangan')) }}</textarea>
                </div>
            </div>

            {{-- Form Actions --}}
            <div class="form-actions">
                <a href="{{ route('admin.keuangan.proyek.index') }}" class="btn-cancel">Batal</a>
                <button type="submit" name="save_and_add" value="1"
                    style="padding:9px 20px; border-radius:9px; font-size:13px; font-weight:700;
                           color:#bb0027; background:#fff; border:1px solid #bb0027; cursor:pointer;
                           display:inline-flex; align-items:center; gap:6px; font-family:'Outfit',sans-serif; transition:background .15s;">
                    <span class="material-symbols-outlined" style="font-size:18px; color:#bb0027;">add_circle</span>
                    Simpan & Tambah
                </button>
                <button type="submit" class="btn-submit">
                    <span class="material-symbols-outlined" style="font-size:18px;">save</span>
                    Simpan Proyek Klien
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Format nominal display auto ribuan
    const displayInput = document.getElementById('nilai_kontrak_display');
    const hiddenInput  = document.getElementById('nilai_kontrak');

    function formatNumber(n) {
        return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    displayInput.addEventListener('input', function(e) {
        let val = this.value.replace(/\D/g, "");
        hiddenInput.value = val || 0;
        this.value = val ? formatNumber(val) : "";
    });

    document.getElementById('proyekForm')?.addEventListener('submit', function() {
        let val = displayInput.value.replace(/\D/g, "");
        hiddenInput.value = val || 0;
    });
</script>
@endpush

