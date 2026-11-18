@props([
    'name' => 'bukti',
    'id' => 'bukti_' . uniqid(),
    'label' => 'Bukti / Foto Pembayaran',
    'help' => 'Format: JPG, PNG, WEBP, atau PDF (Maksimal 5MB)',
    'currentFile' => null,
    'deleteName' => 'hapus_bukti',
    'required' => false,
])

@once
@push('styles')
<style>
    /* ── Dropzone File Upload Component ───────────────────────────── */
    .dz-container {
        display: flex;
        flex-direction: column;
        gap: 6px;
        margin-bottom: 18px;
    }
    .dz-label {
        font-size: 12px;
        font-weight: 700;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .dz-optional {
        font-size: 11px;
        font-weight: 400;
        color: #94a3b8;
        text-transform: none;
        letter-spacing: normal;
    }

    /* Current File Card (Edit mode) */
    .dz-current-file {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 14px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        margin-bottom: 8px;
        transition: background .15s;
    }
    .dz-current-thumb {
        width: 48px;
        height: 48px;
        border-radius: 8px;
        overflow: hidden;
        background: #fff;
        border: 1px solid #cbd5e1;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .dz-current-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .dz-current-info {
        flex: 1;
        min-width: 0;
    }
    .dz-current-name {
        font-size: 12px;
        font-weight: 600;
        color: #1e293b;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .dz-current-sub {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 3px;
        font-size: 11px;
    }
    .dz-tag-current {
        background: #e2e8f0;
        color: #475569;
        padding: 1px 6px;
        border-radius: 4px;
        font-size: 10px;
        font-weight: 700;
    }
    .dz-view-link {
        color: #4f46e5;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 2px;
        font-weight: 600;
    }
    .dz-view-link:hover { text-decoration: underline; }
    .dz-delete-check {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 12px;
        font-weight: 600;
        color: #dc2626;
        cursor: pointer;
        padding: 4px 8px;
        background: #fee2e2;
        border-radius: 6px;
        transition: background .15s;
    }
    .dz-delete-check:hover { background: #fecaca; }

    /* Dropzone Box */
    .dz-dropzone {
        position: relative;
        border: 2px dashed #cbd5e1;
        border-radius: 12px;
        background: #f8fafc;
        padding: 12px 14px;
        text-align: center;
        cursor: pointer;
        transition: all .2s ease-in-out;
        overflow: hidden;
    }
    .dz-dropzone:hover, .dz-dropzone.dz-dragover {
        border-color: #bb0027;
        background: #fff5f5;
    }
    .dz-dropzone.dz-has-file {
        border-color: #22c55e;
        border-style: solid;
        background: #f0fdf4;
        padding: 10px 12px;
    }
    .dz-input {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
        z-index: 10;
    }
    .dz-dropzone.dz-has-file .dz-input {
        display: none;
    }

    /* Prompt Inside Box */
    .dz-prompt {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 4px;
        pointer-events: none;
    }
    .dz-icon-circle {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        color: #64748b;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 1px 3px rgba(0,0,0,0.03);
        transition: all .2s ease;
    }
    .dz-icon-circle .material-symbols-outlined {
        font-size: 20px;
    }
    .dz-dropzone:hover .dz-icon-circle, .dz-dropzone.dz-dragover .dz-icon-circle {
        background: #fee2e2;
        color: #bb0027;
        border-color: #fecaca;
        transform: scale(1.08);
    }
    .dz-prompt-text {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }
    .dz-prompt-main {
        font-size: 13px;
        font-weight: 600;
        color: #1e293b;
    }
    .dz-highlight {
        color: #bb0027;
        font-weight: 700;
        text-decoration: underline;
    }
    .dz-prompt-sub {
        font-size: 11px;
        color: #94a3b8;
    }
    .dz-pill-row {
        display: flex;
        gap: 5px;
        margin-top: 4px;
    }
    .dz-pill {
        font-size: 10px;
        font-weight: 700;
        color: #64748b;
        background: #e2e8f0;
        padding: 2px 6px;
        border-radius: 4px;
        letter-spacing: 0.3px;
    }

    /* Preview Card */
    .dz-preview {
        display: flex;
        align-items: center;
        gap: 12px;
        text-align: left;
        position: relative;
        z-index: 20;
    }
    .dz-preview-thumb-wrap {
        width: 54px;
        height: 54px;
        border-radius: 8px;
        overflow: hidden;
        background: #ffffff;
        border: 1px solid #bbf7d0;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    .dz-preview-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .dz-preview-pdf {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    .dz-preview-meta {
        flex: 1;
        min-width: 0;
    }
    .dz-preview-filename {
        font-size: 13px;
        font-weight: 700;
        color: #0f172a;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .dz-preview-size {
        font-size: 11px;
        color: #64748b;
        margin-top: 1px;
    }
    .dz-preview-badge {
        display: inline-flex;
        align-items: center;
        gap: 3px;
        font-size: 10px;
        font-weight: 700;
        color: #15803d;
        background: #dcfce7;
        padding: 1px 7px;
        border-radius: 20px;
        margin-top: 4px;
        border: 1px solid #bbf7d0;
    }
    .dz-preview-actions {
        display: flex;
        gap: 6px;
        align-items: center;
        flex-shrink: 0;
    }
    .dz-btn-remove {
        background: #fee2e2;
        border: 1px solid #fecaca;
        color: #dc2626;
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all .15s;
    }
    .dz-btn-remove:hover {
        background: #dc2626;
        color: #fff;
    }
    .dz-btn-reselect {
        background: #fff;
        border: 1px solid #cbd5e1;
        color: #475569;
        font-size: 11px;
        font-weight: 600;
        padding: 5px 10px;
        border-radius: 8px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: all .15s;
    }
    .dz-btn-reselect:hover {
        background: #f1f5f9;
        color: #0f172a;
    }
</style>
@endpush
@endonce

<div class="dz-container" id="container_{{ $id }}">
    @if($label)
        <label class="dz-label" for="{{ $id }}">
            <span class="material-symbols-outlined" style="font-size:16px; color:#bb0027;">photo_camera</span>
            <span>{{ $label }}</span>
            @if($required)
                <span style="color:#dc2626;">*</span>
            @else
                <span class="dz-optional">(opsional)</span>
            @endif
        </label>
    @endif

    {{-- File Saat Ini (Edit Mode) --}}
    @if($currentFile)
        @php
            $ext = strtolower(pathinfo($currentFile, PATHINFO_EXTENSION));
            $isImg = in_array($ext, ['jpg', 'jpeg', 'png', 'webp']);
        @endphp
        <div class="dz-current-file" id="current_{{ $id }}">
            <div class="dz-current-thumb">
                @if($isImg)
                    <img src="{{ asset('storage/' . $currentFile) }}" alt="Bukti saat ini">
                @else
                    <span class="material-symbols-outlined" style="font-size:28px; color:#dc2626;">picture_as_pdf</span>
                @endif
            </div>
            <div class="dz-current-info">
                <div class="dz-current-name">{{ basename($currentFile) }}</div>
                <div class="dz-current-sub">
                    <span class="dz-tag-current">File Tersimpan</span>
                    <a href="{{ asset('storage/' . $currentFile) }}" target="_blank" class="dz-view-link">
                        <span class="material-symbols-outlined" style="font-size:13px;">open_in_new</span> Lihat Bukti
                    </a>
                </div>
            </div>
            @if($deleteName)
                <label class="dz-delete-check" title="Centang jika ingin menghapus file ini saat disimpan">
                    <input type="checkbox" name="{{ $deleteName }}" value="1" id="del_{{ $id }}">
                    <span>Hapus</span>
                </label>
            @endif
        </div>
    @endif

    {{-- Dropzone Area --}}
    <div class="dz-dropzone" id="dz_{{ $id }}">
        <input type="file"
               name="{{ $name }}"
               id="{{ $id }}"
               class="dz-input"
               accept=".jpg,.jpeg,.png,.webp,.pdf"
               {{ $required ? 'required' : '' }}>

        {{-- Prompt UI (Empty State) --}}
        <div class="dz-prompt" id="prompt_{{ $id }}">
            <div class="dz-icon-circle">
                <span class="material-symbols-outlined">add_photo_alternate</span>
            </div>
            <div class="dz-prompt-text">
                <span class="dz-prompt-main">
                    Tarik & lepas foto bukti di sini, atau <span class="dz-highlight">Pilih File</span>
                </span>
                <span class="dz-prompt-sub">{{ $help }}</span>
            </div>
            <div class="dz-pill-row">
                <span class="dz-pill">JPG</span>
                <span class="dz-pill">PNG</span>
                <span class="dz-pill">WEBP</span>
                <span class="dz-pill">PDF</span>
            </div>
        </div>

        {{-- Live Preview UI (File Selected State) --}}
        <div class="dz-preview" id="preview_{{ $id }}" style="display:none;">
            <div class="dz-preview-thumb-wrap">
                <img id="img_prev_{{ $id }}" class="dz-preview-img" style="display:none;" alt="Preview Foto">
                <div id="pdf_prev_{{ $id }}" class="dz-preview-pdf" style="display:none;">
                    <span class="material-symbols-outlined" style="font-size:26px; color:#dc2626;">picture_as_pdf</span>
                    <span style="font-size:9px; font-weight:800; color:#dc2626; margin-top:-2px;">PDF</span>
                </div>
            </div>
            <div class="dz-preview-meta">
                <div class="dz-preview-filename" id="name_prev_{{ $id }}">—</div>
                <div class="dz-preview-size" id="size_prev_{{ $id }}">—</div>
                <div class="dz-preview-badge">
                    <span class="material-symbols-outlined" style="font-size:12px;">check_circle</span>
                    Siap diunggah
                </div>
            </div>
            <div class="dz-preview-actions">
                <button type="button" class="dz-btn-reselect" id="btn_reselect_{{ $id }}" title="Pilih file lain">
                    <span class="material-symbols-outlined" style="font-size:14px;">sync</span> Ganti
                </button>
                <button type="button" class="dz-btn-remove" id="btn_remove_{{ $id }}" title="Batalkan pilihan file">
                    <span class="material-symbols-outlined" style="font-size:16px;">close</span>
                </button>
            </div>
        </div>
    </div>
    @error($name) <div style="color:#dc2626; font-size:11px; margin-top:4px;">{{ $message }}</div> @enderror
</div>

@once
@push('scripts')
<script>
    function formatBytes(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    function initDropzone(id) {
        const input      = document.getElementById(id);
        const dz         = document.getElementById('dz_' + id);
        const promptEl   = document.getElementById('prompt_' + id);
        const previewEl  = document.getElementById('preview_' + id);
        const imgPrev    = document.getElementById('img_prev_' + id);
        const pdfPrev    = document.getElementById('pdf_prev_' + id);
        const namePrev   = document.getElementById('name_prev_' + id);
        const sizePrev   = document.getElementById('size_prev_' + id);
        const btnRemove  = document.getElementById('btn_remove_' + id);
        const btnReselect= document.getElementById('btn_reselect_' + id);
        const delCheck   = document.getElementById('del_' + id);

        if (!input || !dz) return;

        function renderFile(file) {
            if (!file) {
                resetDropzone();
                return;
            }

            namePrev.textContent = file.name;
            sizePrev.textContent = formatBytes(file.size);

            const isImg = file.type.startsWith('image/');
            if (isImg) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imgPrev.src = e.target.result;
                    imgPrev.style.display = 'block';
                    pdfPrev.style.display = 'none';
                };
                reader.readAsDataURL(file);
            } else {
                imgPrev.style.display = 'none';
                pdfPrev.style.display = 'flex';
            }

            promptEl.style.display  = 'none';
            previewEl.style.display = 'flex';
            dz.classList.add('dz-has-file');

            // Auto-check delete old file if replacing in edit mode
            if (delCheck) {
                delCheck.checked = true;
            }
        }

        function resetDropzone() {
            input.value = '';
            promptEl.style.display  = 'flex';
            previewEl.style.display = 'none';
            imgPrev.style.display   = 'none';
            pdfPrev.style.display   = 'none';
            imgPrev.src             = '';
            dz.classList.remove('dz-has-file');
        }

        input.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                renderFile(this.files[0]);
            } else {
                resetDropzone();
            }
        });

        // Drag & drop handlers
        ['dragenter', 'dragover'].forEach(eventName => {
            dz.addEventListener(eventName, function(e) {
                e.preventDefault();
                e.stopPropagation();
                dz.classList.add('dz-dragover');
            }, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dz.addEventListener(eventName, function(e) {
                e.preventDefault();
                e.stopPropagation();
                dz.classList.remove('dz-dragover');
            }, false);
        });

        dz.addEventListener('drop', function(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            if (files && files.length > 0) {
                input.files = files;
                renderFile(files[0]);
            }
        }, false);

        btnRemove.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            resetDropzone();
        });

        btnReselect.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            input.click();
        });
    }
</script>
@endpush
@endonce

<script>
    document.addEventListener('DOMContentLoaded', function() {
        initDropzone('{{ $id }}');
    });
    // In case script runs after DOMContentLoaded (e.g. modals)
    if (document.readyState === 'complete' || document.readyState === 'interactive') {
        setTimeout(function() { initDropzone('{{ $id }}'); }, 50);
    }
</script>

