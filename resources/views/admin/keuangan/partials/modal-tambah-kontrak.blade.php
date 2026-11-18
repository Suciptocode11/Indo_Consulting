@php
    $modalServices = \Illuminate\Support\Facades\DB::table('service')->where('status', 'Show')->orderBy('title')->get();
@endphp

<div id="modalTambahKontrak" class="floating-modal-backdrop" style="display: none;">
    <div class="floating-modal-card" onclick="event.stopPropagation()">
        {{-- Header Modal --}}
        <div class="floating-modal-head">
            <h3>
                <span class="material-symbols-outlined" style="font-size: 20px; color: #f87171;">post_add</span>
                Tambah Kontrak Proyek Klien
            </h3>
            <button type="button" class="floating-modal-close" onclick="closeModalTambahKontrak()" title="Tutup">
                <span class="material-symbols-outlined" style="font-size: 18px;">close</span>
            </button>
        </div>

        {{-- Form Body --}}
        <form method="POST" action="{{ route('admin.keuangan.kontrak.store') }}" id="formModalTambahKontrak">
            @csrf

            <div class="floating-modal-body">
                @if($errors->any() && (old('nama_proyek') || old('nama_klien') || old('nilai_kontrak')))
                    <div style="background:#fee2e2;border:1px solid #fecaca;color:#b91c1c;padding:10px 14px;border-radius:10px;margin-bottom:14px;font-size:12px;">
                        <strong style="display:block;margin-bottom:3px;">Mohon periksa kembali isian form:</strong>
                        <ul style="margin:0;padding-left:16px;">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="floating-form-grid">
                    {{-- 1. Nama Proyek --}}
                    <div class="floating-form-group full">
                        <label>Nama Proyek / Pekerjaan <span class="req">*</span></label>
                        <input type="text" name="nama_proyek" id="modal_nama_proyek" class="floating-form-control"
                               placeholder="Contoh: Pendampingan Akreditasi & Restrukturisasi SOP"
                               value="{{ old('nama_proyek') }}" required autocomplete="off">
                    </div>

                    {{-- 2. Nama Klien --}}
                    <div class="floating-form-group full">
                        <label>Nama Klien / Perusahaan <span class="req">*</span></label>
                        <input type="text" name="nama_klien" id="modal_nama_klien" class="floating-form-control"
                               placeholder="Contoh: PT Semen Indonesia (Persero) Tbk"
                               value="{{ old('nama_klien') }}" required autocomplete="off">
                    </div>

                    {{-- 3. PIC Konsultan & Kontak Klien --}}
                    <div class="floating-form-group">
                        <label>PIC / Penanggung Jawab</label>
                        <input type="text" name="pic" class="floating-form-control"
                               placeholder="Contoh: Bpk. Bagas Pratama, S.H."
                               value="{{ old('pic') }}">
                    </div>
                    <div class="floating-form-group">
                        <label>Kontak PIC Klien</label>
                        <input type="text" name="kontak_klien" class="floating-form-control"
                               placeholder="Contoh: 08123456789"
                               value="{{ old('kontak_klien') }}">
                    </div>

                    {{-- 4. Kategori Layanan & Status --}}
                    <div class="floating-form-group">
                        <label>Kategori Layanan / Program</label>
                        <select name="service_id" class="floating-form-control">
                            <option value="">-- Pilih Layanan (Opsional) --</option>
                            @foreach($modalServices as $svc)
                                <option value="{{ $svc->id }}" {{ old('service_id') == $svc->id ? 'selected' : '' }}>{{ $svc->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="floating-form-group">
                        <label>Status Kontrak <span class="req">*</span></label>
                        <select name="status" class="floating-form-control" required>
                            <option value="berjalan" {{ old('status', 'berjalan') === 'berjalan' ? 'selected' : '' }}>Berjalan (Aktif)</option>
                            <option value="pending" {{ old('status') === 'pending' ? 'selected' : '' }}>Pending / Menunggu Kickoff</option>
                            <option value="selesai" {{ old('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="batal" {{ old('status') === 'batal' ? 'selected' : '' }}>Batal</option>
                        </select>
                    </div>

                    {{-- 5. Tanggal Mulai & Tanggal Selesai --}}
                    <div class="floating-form-group">
                        <label>Tanggal Mulai <span class="req">*</span></label>
                        <input type="date" name="tanggal_mulai" class="floating-form-control datepicker" value="{{ old('tanggal_mulai', date('Y-m-d')) }}" required>
                    </div>
                    <div class="floating-form-group">
                        <label>Target Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" class="floating-form-control datepicker" value="{{ old('tanggal_selesai') }}">
                    </div>

                    {{-- 6. Nilai Proyek / Harga Kontrak (Dengan External Rp Badge & Auto Ribuan) --}}
                    <div class="floating-form-group full">
                        <label>Nilai Proyek / Harga Kontrak <span class="req">*</span></label>
                        <div class="input-group-rp">
                            <span class="input-group-addon-rp">Rp</span>
                            <input type="text" id="modal_nilai_kontrak_display" class="input-group-field-rp"
                                   placeholder="Contoh: 50.000.000" autocomplete="off" required
                                   value="{{ old('nilai_kontrak') ? number_format(old('nilai_kontrak'), 0, ',', '.') : '' }}"
                                   oninput="onModalNilaiKontrakInput(this)">
                        </div>
                        <input type="hidden" name="nilai_kontrak" id="modal_nilai_kontrak_val" value="{{ old('nilai_kontrak', 0) }}">
                        <div style="font-size: 11px; color: #94a3b8; margin-top: 3px;">Total nominal kesepakatan harga kontrak proyek klien</div>
                    </div>

                    {{-- 7. Deskripsi --}}
                    <div class="floating-form-group full">
                        <label>Deskripsi <span style="font-weight: 400; color: #94a3b8;">(opsional)</span></label>
                        <textarea name="deskripsi" rows="2" class="floating-form-control" placeholder="Catatan ruang lingkup, durasi, atau detail khusus pekerjaan...">{{ old('deskripsi') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Footer Modal --}}
            <div class="floating-modal-foot">
                <button type="button" class="btn-floating-cancel" onclick="closeModalTambahKontrak()">Batal</button>
                <button type="submit" name="save_and_add" value="1"
                    style="background:#fff; color:#bb0027; border:1px solid #bb0027; box-shadow:none;
                           font-family:'Outfit',sans-serif; font-size:13px; font-weight:700;
                           padding:9px 18px; border-radius:9px; cursor:pointer;
                           display:inline-flex; align-items:center; gap:6px; transition:background .15s;">
                    <span class="material-symbols-outlined" style="font-size:17px; color:#bb0027;">add_circle</span>
                    Simpan & Tambah
                </button>
                <button type="submit" class="btn-floating-submit">
                    <span class="material-symbols-outlined" style="font-size: 17px;">save</span>
                    Simpan Kontrak
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .floating-modal-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.65);
        backdrop-filter: blur(4px);
        z-index: 99999;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 16px;
    }
    .floating-modal-card {
        background: #ffffff;
        border-radius: 16px;
        width: 100%;
        max-width: 660px;
        max-height: calc(100vh - 40px);
        display: flex;
        flex-direction: column;
        box-shadow: 0 24px 48px -12px rgba(15, 23, 42, 0.35);
        overflow: hidden;
        animation: modalSlideUp 0.18s ease-out;
    }
    .floating-modal-card form {
        display: flex;
        flex-direction: column;
        flex: 1 1 auto;
        min-height: 0;
        overflow: hidden;
        margin: 0;
    }
    @keyframes modalSlideUp {
        from { transform: translateY(12px) scale(0.98); opacity: 0; }
        to   { transform: translateY(0) scale(1); opacity: 1; }
    }
    .floating-modal-head {
        padding: 16px 22px;
        background: #0f172a;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-shrink: 0;
    }
    .floating-modal-head h3 {
        margin: 0;
        font-size: 15px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 8px;
        color: #ffffff;
        letter-spacing: -0.2px;
    }
    .floating-modal-close {
        background: rgba(255, 255, 255, 0.12);
        border: none;
        color: #ffffff;
        width: 30px;
        height: 30px;
        border-radius: 7px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background 0.15s;
    }
    .floating-modal-close:hover {
        background: #dc2626;
    }
    .floating-modal-body {
        padding: 20px 24px;
        overflow-y: auto;
        flex: 1 1 auto;
        min-height: 0;
        max-height: calc(100vh - 160px);
        overscroll-behavior: contain;
    }
    .floating-modal-body::-webkit-scrollbar {
        width: 6px;
    }
    .floating-modal-body::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }
    .floating-form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px 16px;
    }
    @media (max-width: 600px) {
        .floating-form-grid {
            grid-template-columns: 1fr;
        }
    }
    .floating-form-group {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }
    .floating-form-group.full {
        grid-column: 1 / -1;
    }
    .floating-form-group label {
        font-size: 11px;
        font-weight: 700;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.35px;
    }
    .floating-form-group label .req {
        color: #dc2626;
    }
    .floating-form-control {
        width: 100%;
        padding: 9px 13px;
        border: 1px solid #cbd5e1;
        border-radius: 9px;
        font-family: 'Outfit', sans-serif;
        font-size: 13px;
        color: #0f172a;
        background: #ffffff;
        outline: none;
        transition: border-color .15s, box-shadow .15s;
    }
    .floating-form-control:focus {
        border-color: #bb0027;
        box-shadow: 0 0 0 3px rgba(187,0,39,.08);
    }
    /* Input Group Rp di Floating Form */
    .floating-modal-card .input-group-rp {
        display: flex;
        align-items: stretch;
        width: 100%;
    }
    .floating-modal-card .input-group-addon-rp {
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
    .floating-modal-card .input-group-field-rp {
        flex: 1;
        border-radius: 0 9px 9px 0 !important;
        border: 1px solid #cbd5e1;
        padding: 9px 13px;
        font-size: 13px;
        font-family: 'Outfit', sans-serif;
        outline: none;
        background: #ffffff;
        color: #0f172a;
        font-weight: 600;
        width: 100%;
        transition: border-color .15s, box-shadow .15s;
    }
    .floating-modal-card .input-group-field-rp:focus {
        border-color: #bb0027;
        box-shadow: 0 0 0 3px rgba(187,0,39,.08);
    }
    .floating-modal-foot {
        padding: 13px 24px;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        flex-shrink: 0;
    }
    .btn-floating-cancel {
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        cursor: pointer;
        transition: all .15s;
    }
    .btn-floating-cancel:hover {
        background: #f1f5f9;
        color: #0f172a;
    }
    .btn-floating-submit {
        padding: 8px 20px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        color: #ffffff;
        background: #bb0027;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        box-shadow: 0 2px 6px rgba(187, 0, 39, 0.25);
        transition: background .15s;
    }
    .btn-floating-submit:hover {
        background: #9a0020;
    }
</style>

<script>
    function openModalTambahKontrak() {
        const modal = document.getElementById('modalTambahKontrak');
        if (modal) {
            modal.style.display = 'flex';
            if (window.initDatepickers) {
                window.initDatepickers(modal);
            }
            setTimeout(function() {
                const firstInput = document.getElementById('modal_nama_proyek');
                if (firstInput) firstInput.focus();
            }, 60);
        }
    }

    function closeModalTambahKontrak() {
        const modal = document.getElementById('modalTambahKontrak');
        if (modal) modal.style.display = 'none';
    }

    function onModalNilaiKontrakInput(el) {
        let raw = el.value.replace(/\D/g, "");
        const hidden = document.getElementById('modal_nilai_kontrak_val');
        if (hidden) hidden.value = raw || 0;
        el.value = raw ? raw.replace(/\B(?=(\d{3})+(?!\d))/g, ".") : "";
    }

    // Tutup saat klik area backdrop luar
    document.addEventListener('click', function(e) {
        const modal = document.getElementById('modalTambahKontrak');
        if (modal && e.target === modal) {
            closeModalTambahKontrak();
        }
    });

    // Tutup saat tekan ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModalTambahKontrak();
        }
    });

    @if(session('reopen_modal_kontrak') || ($errors->any() && (old('nama_proyek') || old('nama_klien') || old('nilai_kontrak'))))
    document.addEventListener('DOMContentLoaded', function() {
        openModalTambahKontrak();
    });
    @endif
</script>
