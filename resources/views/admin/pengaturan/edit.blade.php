@extends('admin.layouts.app')

@section('title', 'Pengaturan Perusahaan')
@section('page-title', 'Pengaturan Umum')

@push('styles')
<style>
    /* ─── Settings Card & Section Styling ─── */
    .settings-card {
        max-width: 860px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        padding: 28px 32px;
    }

    .section-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 20px;
    }

    .section-icon {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        background: #eff6ff;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }

    .section-title {
        font-size: 15px;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
        letter-spacing: -0.2px;
    }

    .section-desc {
        font-size: 12px;
        color: #64748b;
        margin: 2px 0 0;
    }

    .form-divider {
        margin: 32px 0;
        border: none;
        border-top: 1px solid #f1f5f9;
    }

    /* ─── Logo Upload Studio Component ─── */
    .logo-studio {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .logo-dropzone {
        border: 2px dashed #cbd5e1;
        border-radius: 10px;
        background: #ffffff;
        padding: 24px 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s ease;
        position: relative;
    }

    .logo-dropzone:hover,
    .logo-dropzone.dragover {
        border-color: #2563eb;
        background: #f0f7ff;
    }

    .logo-dropzone .dropzone-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: #f1f5f9;
        color: #64748b;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 10px;
        transition: transform 0.2s ease;
    }

    .logo-dropzone:hover .dropzone-icon {
        transform: translateY(-2px);
        background: #dbeafe;
        color: #2563eb;
    }

    .logo-dropzone-title {
        font-size: 14px;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 4px;
    }

    .logo-dropzone-hint {
        font-size: 12px;
        color: #94a3b8;
    }

    /* Dual Previews (Light & Dark Context) */
    .logo-previews-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 16px;
        margin-top: 4px;
    }

    .preview-box {
        border-radius: 10px;
        padding: 16px;
        display: flex;
        flex-direction: column;
        gap: 8px;
        border: 1px solid #e2e8f0;
    }

    .preview-box-light {
        background: repeating-conic-gradient(#f8fafc 0% 25%, #ffffff 0% 50%) 50% / 16px 16px;
    }

    .preview-box-dark {
        background: #020220;
        border-color: #1e293b;
    }

    .preview-label {
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .preview-box-light .preview-label { color: #64748b; }
    .preview-box-dark .preview-label { color: #94a3b8; }

    .preview-image-wrap {
        height: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 8px;
    }

    .preview-image-wrap img {
        max-height: 100%;
        max-width: 100%;
        object-fit: contain;
        transition: transform 0.2s ease;
    }

    /* Action bar */
    .logo-actions-bar {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding-top: 4px;
    }

    .badge-status-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-saved {
        background: #dcfce7;
        color: #15803d;
    }

    .badge-pending {
        background: #dbeafe;
        color: #1d4ed8;
        border: 1px dashed #93c5fd;
    }

    .badge-removed {
        background: #fee2e2;
        color: #b91c1c;
        border: 1px dashed #fca5a5;
    }

    .badge-default {
        background: #f1f5f9;
        color: #64748b;
    }

    .btn-action-sm {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        border: 1px solid transparent;
        font-family: inherit;
        transition: all 0.15s ease;
    }

    .btn-action-choose {
        background: #020220;
        color: #ffffff;
    }
    .btn-action-choose:hover {
        background: #1e1e40;
    }

    .btn-action-delete {
        background: #fff;
        color: #ef4444;
        border-color: #fecaca;
    }
    .btn-action-delete:hover {
        background: #fee2e2;
        border-color: #f87171;
    }

    .btn-action-revert {
        background: #f1f5f9;
        color: #475569;
        border-color: #cbd5e1;
    }
    .btn-action-revert:hover {
        background: #e2e8f0;
    }

    .field-error-text {
        color: #ef4444;
        font-size: 12px;
        font-weight: 500;
        margin-top: 6px;
        display: flex;
        align-items: center;
        gap: 4px;
    }
</style>
@endpush

@section('content')
<div class="settings-card">

    {{-- Error Banner --}}
    @if($errors->any())
        <div style="background: #fef2f2; border: 1px solid #fecaca; border-radius: 10px; padding: 14px 18px; margin-bottom: 24px; color: #991b1b; font-size: 13px;">
            <div style="display: flex; align-items: center; gap: 8px; font-weight: 600; margin-bottom: 6px;">
                <span class="material-symbols-outlined" style="font-size: 18px;">warning</span>
                Terdapat kesalahan pada formulir:
            </div>
            <ul style="margin: 0; padding-left: 24px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.pengaturan.update') }}" enctype="multipart/form-data" id="pengaturanForm">
        @csrf
        @method('PUT')

        {{-- Hidden input for file deletion --}}
        <input type="hidden" name="remove_logo" id="removeLogoInput" value="0">

        <!-- 1. IDENTITAS PERUSAHAAN -->
        <div class="section-header">
            <div class="section-icon">
                <span class="material-symbols-outlined">apartment</span>
            </div>
            <div>
                <h3 class="section-title">Informasi Perusahaan</h3>
                <p class="section-desc">Identitas bisnis, alamat kantor resmi, dan kontak publik</p>
            </div>
        </div>

        <div class="form-group">
            <label>Nama Perusahaan *</label>
            <input type="text" name="company" value="{{ old('company', $pengaturan->company) }}" placeholder="Indo Consulting" required>
            @error('company') <div class="field-error-text"><span class="material-symbols-outlined" style="font-size: 15px;">error</span> {{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label>Alamat Kantor</label>
            <textarea name="address" rows="2" placeholder="Jl. Ganetri IV No.4, Tonja, Denpasar, Bali">{{ old('address', $pengaturan->address) }}</textarea>
            @error('address') <div class="field-error-text"><span class="material-symbols-outlined" style="font-size: 15px;">error</span> {{ $message }}</div> @enderror
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Nomor Telepon / WhatsApp</label>
                <input type="text" name="phone" value="{{ old('phone', $pengaturan->phone) }}" placeholder="+62 878-653-0996">
                @error('phone') <div class="field-error-text"><span class="material-symbols-outlined" style="font-size: 15px;">error</span> {{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label>Alamat Email</label>
                <input type="email" name="email" value="{{ old('email', $pengaturan->email) }}" placeholder="partner@indoconsulting.id">
                @error('email') <div class="field-error-text"><span class="material-symbols-outlined" style="font-size: 15px;">error</span> {{ $message }}</div> @enderror
            </div>
        </div>

        <div class="form-group">
            <label>Website URL</label>
            <input type="url" name="website" value="{{ old('website', $pengaturan->website) }}" placeholder="https://indoconsulting.id">
            @error('website') <div class="field-error-text"><span class="material-symbols-outlined" style="font-size: 15px;">error</span> {{ $message }}</div> @enderror
        </div>

        <hr class="form-divider">

        <!-- 2. LOGO PERUSAHAAN STUDIO -->
        @php
            $hasCustomLogo = !empty($pengaturan->logo) && \Illuminate\Support\Facades\Storage::disk('public')->exists($pengaturan->logo);
            $currentLogoSrc = $hasCustomLogo ? asset('storage/' . $pengaturan->logo) : asset('images/logo.png');
        @endphp

        <div class="section-header">
            <div class="section-icon" style="background: #fdf2f8; color: #db2777;">
                <span class="material-symbols-outlined">brand_family</span>
            </div>
            <div>
                <h3 class="section-title">Logo Resmi Perusahaan</h3>
                <p class="section-desc">Logo akan otomatis diterapkan pada Header Website, Sidebar Admin, Page Loader, dan Footer.</p>
            </div>
        </div>

        <div class="logo-studio">
            {{-- Interactive Dropzone --}}
            <div class="logo-dropzone" id="logoDropzone" onclick="document.getElementById('logoFileInput').click()">
                <div class="dropzone-icon">
                    <span class="material-symbols-outlined" style="font-size: 26px;">cloud_upload</span>
                </div>
                <div class="logo-dropzone-title">Klik atau seret logo baru ke sini</div>
                <div class="logo-dropzone-hint">Format didukung: <strong>PNG (disarankan transparan), SVG, WebP, JPG</strong> • Maksimal <strong>5 MB</strong></div>

                {{-- Actual File Input --}}
                <input
                    type="file"
                    name="logo"
                    id="logoFileInput"
                    accept="image/png,image/jpeg,image/webp,image/svg+xml"
                    style="display: none;"
                >
            </div>

            @error('logo')
                <div class="field-error-text">
                    <span class="material-symbols-outlined" style="font-size: 15px;">error</span>
                    {{ $message }}
                </div>
            @enderror

            {{-- Live Dual Context Previews --}}
            <div class="logo-previews-container">
                {{-- Light Mode Preview (Header/Website) --}}
                <div class="preview-box preview-box-light">
                    <div class="preview-label">
                        <span class="material-symbols-outlined" style="font-size: 13px; vertical-align: middle;">light_mode</span>
                        Preview di Background Terang (Header / Dokumen)
                    </div>
                    <div class="preview-image-wrap">
                        <img id="previewImgLight" src="{{ $currentLogoSrc }}" alt="Preview Terang">
                    </div>
                </div>

                {{-- Dark Mode Preview (Sidebar/Loader) --}}
                <div class="preview-box preview-box-dark">
                    <div class="preview-label">
                        <span class="material-symbols-outlined" style="font-size: 13px; vertical-align: middle;">dark_mode</span>
                        Preview di Background Gelap (Sidebar Admin / Footer)
                    </div>
                    <div class="preview-image-wrap">
                        <img id="previewImgDark" src="{{ $currentLogoSrc }}" alt="Preview Gelap">
                    </div>
                </div>
            </div>

            {{-- Actions Bar & Status Badge --}}
            <div class="logo-actions-bar">
                <div id="logoBadgeWrap">
                    @if($hasCustomLogo)
                        <span class="badge-status-pill badge-saved" id="statusBadge">
                            <span class="material-symbols-outlined" style="font-size: 14px;">check_circle</span>
                            Logo khusus aktif tersimpan
                        </span>
                    @else
                        <span class="badge-status-pill badge-default" id="statusBadge">
                            <span class="material-symbols-outlined" style="font-size: 14px;">info</span>
                            Menggunakan logo default sistem
                        </span>
                    @endif
                </div>

                <div style="display: flex; gap: 8px; align-items: center;">
                    <button type="button" class="btn-action-sm btn-action-choose" onclick="document.getElementById('logoFileInput').click()">
                        <span class="material-symbols-outlined" style="font-size: 14px;">upload_file</span>
                        Pilih File Logo
                    </button>

                    <button type="button" class="btn-action-sm btn-action-revert" id="btnRevertLogo" style="display: none;" onclick="revertLogoSelection()">
                        <span class="material-symbols-outlined" style="font-size: 14px;">undo</span>
                        Batal
                    </button>

                    @if($hasCustomLogo)
                        <button type="button" class="btn-action-sm btn-action-delete" id="btnDeleteLogo" onclick="markLogoForDeletion()">
                            <span class="material-symbols-outlined" style="font-size: 14px;">delete</span>
                            Hapus Logo
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <hr class="form-divider">

        <!-- 3. GOOGLE MAPS -->
        <div class="section-header">
            <div class="section-icon" style="background: #f0fdf4; color: #16a34a;">
                <span class="material-symbols-outlined">map</span>
            </div>
            <div>
                <h3 class="section-title">Integrasi Google Maps</h3>
                <p class="section-desc">Peta interaktif lokasi kantor pada halaman Hubungi Kami</p>
            </div>
        </div>

        <div class="form-group">
            <label>Embed URL Google Maps</label>
            <input type="url" name="map" value="{{ old('map', $pengaturan->map) }}" placeholder="https://www.google.com/maps/embed?pb=...">
            <div class="help" style="font-size: 12px; color: #94a3b8; margin-top: 6px;">
                Petunjuk: Buka Google Maps &rarr; Klik Bagikan / Share &rarr; Pilih "Sematkan Peta" (Embed a map) &rarr; Salin URL pada atribut <code>src="..."</code> saja.
            </div>
            @error('map') <div class="field-error-text"><span class="material-symbols-outlined" style="font-size: 15px;">error</span> {{ $message }}</div> @enderror
        </div>

        <hr class="form-divider">

        <!-- 4. FOOTER & COPYRIGHT -->
        <div class="section-header">
            <div class="section-icon" style="background: #faf5ff; color: #9333ea;">
                <span class="material-symbols-outlined">copyright</span>
            </div>
            <div>
                <h3 class="section-title">Footer & Hak Cipta</h3>
                <p class="section-desc">Teks informasi legal hak cipta yang muncul di bagian paling bawah website</p>
            </div>
        </div>

        <div class="form-group">
            <label>Teks Hak Cipta (Copyright)</label>
            <input type="text" name="copyright" value="{{ old('copyright', $pengaturan->copyright) }}" placeholder="&copy; 2026 Indo Consulting. Hak cipta dilindungi.">
            @error('copyright') <div class="field-error-text"><span class="material-symbols-outlined" style="font-size: 15px;">error</span> {{ $message }}</div> @enderror
        </div>

        {{-- Form Actions --}}
        <div style="display: flex; align-items: center; gap: 14px; margin-top: 36px; padding-top: 16px; border-top: 1px solid #f1f5f9;">
            <button type="submit" class="btn btn-primary" id="btnSubmitForm" style="padding: 11px 32px; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
                <span class="material-symbols-outlined" style="font-size: 18px;">save</span>
                Simpan Pengaturan
            </button>
            <span id="savingSpinner" style="display: none; font-size: 13px; color: #64748b; align-items: center; gap: 6px;">
                <span class="material-symbols-outlined" style="font-size: 16px; animation: spin 1s linear infinite;">progress_activity</span>
                Menyimpan data...
            </span>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const originalSrc = "{{ $currentLogoSrc }}";
    const defaultSrc  = "{{ asset('images/logo.png') }}";
    const hadCustom   = {{ $hasCustomLogo ? 'true' : 'false' }};

    const fileInput   = document.getElementById('logoFileInput');
    const removeInput = document.getElementById('removeLogoInput');
    const dropzone    = document.getElementById('logoDropzone');
    const imgLight    = document.getElementById('previewImgLight');
    const imgDark     = document.getElementById('previewImgDark');
    const badgeWrap   = document.getElementById('logoBadgeWrap');
    const btnRevert   = document.getElementById('btnRevertLogo');
    const btnDelete   = document.getElementById('btnDeleteLogo');
    const form        = document.getElementById('pengaturanForm');
    const submitBtn   = document.getElementById('btnSubmitForm');
    const spinner     = document.getElementById('savingSpinner');

    // Drag and drop handlers
    ['dragenter', 'dragover'].forEach(eventName => {
        dropzone.addEventListener(eventName, function (e) {
            e.preventDefault();
            e.stopPropagation();
            dropzone.classList.add('dragover');
        });
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropzone.addEventListener(eventName, function (e) {
            e.preventDefault();
            e.stopPropagation();
            dropzone.classList.remove('dragover');
        });
    });

    dropzone.addEventListener('drop', function (e) {
        const files = e.dataTransfer.files;
        if (files && files[0]) {
            fileInput.files = files;
            processSelectedFile(files[0]);
        }
    });

    fileInput.addEventListener('change', function () {
        if (this.files && this.files[0]) {
            processSelectedFile(this.files[0]);
        }
    });

    function processSelectedFile(file) {
        // Validate size (5MB max)
        if (file.size > 5 * 1024 * 1024) {
            alert('Ukuran file logo terlalu besar. Maksimal 5 MB.');
            fileInput.value = '';
            return;
        }

        // Validate type
        const validTypes = ['image/png', 'image/jpeg', 'image/webp', 'image/svg+xml'];
        if (!validTypes.includes(file.type) && !file.name.match(/\.(png|jpe?g|webp|svg)$/i)) {
            alert('Format file tidak didukung. Harap pilih gambar PNG, JPG, WebP, atau SVG.');
            fileInput.value = '';
            return;
        }

        // Reset removal flag
        removeInput.value = "0";

        // Read and update preview
        const reader = new FileReader();
        reader.onload = function (e) {
            imgLight.src = e.target.result;
            imgDark.src  = e.target.result;

            badgeWrap.innerHTML = `
                <span class="badge-status-pill badge-pending">
                    <span class="material-symbols-outlined" style="font-size: 14px;">pending</span>
                    Logo baru dipilih: ${file.name} (Simpan untuk menerapkan)
                </span>
            `;

            btnRevert.style.display = 'inline-flex';
            if (btnDelete) btnDelete.style.display = 'none';
        };
        reader.readAsDataURL(file);
    }

    window.revertLogoSelection = function () {
        fileInput.value = '';
        removeInput.value = "0";
        imgLight.src = originalSrc;
        imgDark.src  = originalSrc;

        if (hadCustom) {
            badgeWrap.innerHTML = `
                <span class="badge-status-pill badge-saved">
                    <span class="material-symbols-outlined" style="font-size: 14px;">check_circle</span>
                    Logo khusus aktif tersimpan
                </span>
            `;
            if (btnDelete) btnDelete.style.display = 'inline-flex';
        } else {
            badgeWrap.innerHTML = `
                <span class="badge-status-pill badge-default">
                    <span class="material-symbols-outlined" style="font-size: 14px;">info</span>
                    Menggunakan logo default sistem
                </span>
            `;
        }
        btnRevert.style.display = 'none';
    };

    window.markLogoForDeletion = function () {
        if (!confirm('Apakah Anda yakin ingin menghapus logo kustom perusahaan dan kembali ke logo default?')) {
            return;
        }

        fileInput.value = '';
        removeInput.value = "1";
        imgLight.src = defaultSrc;
        imgDark.src  = defaultSrc;

        badgeWrap.innerHTML = `
            <span class="badge-status-pill badge-removed">
                <span class="material-symbols-outlined" style="font-size: 14px;">delete_forever</span>
                Logo akan dihapus saat tombol Simpan ditekan
            </span>
        `;

        btnRevert.style.display = 'inline-flex';
        if (btnDelete) btnDelete.style.display = 'none';
    };

    // Form submit indicator
    form.addEventListener('submit', function () {
        submitBtn.disabled = true;
        submitBtn.style.opacity = '0.7';
        spinner.style.display = 'inline-flex';
    });
});
</script>
@endpush

