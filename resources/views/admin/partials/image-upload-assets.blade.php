@push('styles')
<style>
/* ─── Image Upload Widget ─── */
.image-upload-widget {
    position: relative;
    max-width: 100%;
}

.image-upload-dropzone {
    position: relative;
    border: 2px dashed #cbd5e1;
    border-radius: 12px;
    overflow: hidden;
    background: #f8fafc;
    transition: all 0.25s ease;
    cursor: pointer;
}

.image-upload-dropzone:hover,
.image-upload-dropzone.dragover {
    border-color: #020220;
    background: #f0f4ff;
}

.image-upload-dropzone input[type="file"] {
    position: absolute;
    inset: 0;
    opacity: 0;
    cursor: pointer;
    width: 100%;
    height: 100%;
    z-index: 10;
}

/* Preview State */
.image-preview-wrap {
    display: none;
    position: relative;
}
.image-preview-wrap img {
    width: 100%;
    height: 220px;
    object-fit: cover;
    display: block;
    border-radius: 10px;
}
.image-preview-overlay {
    position: absolute;
    inset: 0;
    background: rgba(2,2,32,0.45);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    border-radius: 10px;
    opacity: 0;
    transition: opacity 0.2s ease;
}
.image-preview-wrap:hover .image-preview-overlay {
    opacity: 1;
}
.image-action-btn {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 7px 14px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    font-family: 'Outfit', sans-serif;
    transition: transform 0.15s;
}
.image-action-btn:hover { transform: scale(1.05); }
.btn-change-img { background: #fff; color: #020220; }
.btn-remove-img { background: #ef4444; color: #fff; }

/* Empty State */
.image-empty-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 36px 20px;
    gap: 10px;
    color: #94a3b8;
    text-align: center;
    pointer-events: none;
}
.image-empty-state .upload-icon {
    width: 52px;
    height: 52px;
    border-radius: 12px;
    background: #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 4px;
}
.image-empty-state .material-symbols-outlined {
    font-size: 26px;
    color: #94a3b8;
}
.image-empty-state strong {
    font-size: 14px;
    color: #475569;
    font-weight: 600;
    display: block;
}
.image-empty-state span {
    font-size: 12px;
    color: #94a3b8;
}

/* Current image indicator */
.current-image-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 11px;
    color: #16a34a;
    background: #dcfce7;
    border-radius: 20px;
    padding: 3px 10px;
    margin-top: 8px;
    font-weight: 600;
}
.no-image-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 11px;
    color: #94a3b8;
    background: #f1f5f9;
    border-radius: 20px;
    padding: 3px 10px;
    margin-top: 8px;
    font-weight: 500;
}
</style>
@endpush

@push('scripts')
<script>
// ─── Image Upload Logic ───────────────────────────────────────────────

document.addEventListener('DOMContentLoaded', function () {
    // Bind each file input
    document.querySelectorAll('input[type="file"][data-key]').forEach(function (input) {
        const key = input.dataset.key;

        // File selected via input
        input.addEventListener('change', function () {
            if (this.files && this.files[0]) {
                handleFileSelected(key, this.files[0]);
            }
        });

        // Drag and drop on dropzone
        const dropzone = document.getElementById('dropzone-' + key);
        if (dropzone) {
            dropzone.addEventListener('dragover', function (e) {
                e.preventDefault();
                this.classList.add('dragover');
            });
            dropzone.addEventListener('dragleave', function () {
                this.classList.remove('dragover');
            });
            dropzone.addEventListener('drop', function (e) {
                e.preventDefault();
                this.classList.remove('dragover');
                const file = e.dataTransfer.files[0];
                if (file && file.type.startsWith('image/')) {
                    // Manually assign to file input
                    const dt = new DataTransfer();
                    dt.items.add(file);
                    document.getElementById('file-' + key).files = dt.files;
                    handleFileSelected(key, file);
                }
            });
        }
    });
});

function handleFileSelected(key, file) {
    // Validate size (5MB)
    if (file.size > 5 * 1024 * 1024) {
        alert('Ukuran file terlalu besar. Maksimal 5 MB.');
        return;
    }

    const reader = new FileReader();
    reader.onload = function (e) {
        showImagePreview(key, e.target.result);
        
        // Update hidden value to flag that a new file is selected, if hidden input exists
        const hiddenInput = document.getElementById('hidden-' + key);
        if (hiddenInput) {
            hiddenInput.value = '__new_file__';
        }
        
        // Uncheck the "remove" checkbox if it exists (for standard forms)
        const removeCheckbox = document.getElementById('remove-img-' + key);
        if (removeCheckbox) {
            removeCheckbox.checked = false;
        }
    };
    reader.readAsDataURL(file);
}

function showImagePreview(key, src) {
    const previewWrap = document.getElementById('preview-' + key);
    const previewImg  = document.getElementById('preview-img-' + key);
    const emptyState  = document.getElementById('empty-' + key);
    const badge       = document.getElementById('badge-' + key);

    if(previewImg) previewImg.src = src;
    if(previewWrap) previewWrap.style.display = 'block';
    if(emptyState) emptyState.style.display  = 'none';
    if(badge) badge.innerHTML = '<span class="current-image-badge"><span class="material-symbols-outlined" style="font-size:13px;">check_circle</span> Foto baru dipilih – belum disimpan</span>';
}

function removeImage(key) {
    if (!confirm('Hapus foto ini?')) return;

    const previewWrap = document.getElementById('preview-' + key);
    const emptyState  = document.getElementById('empty-' + key);
    const badge       = document.getElementById('badge-' + key);
    const fileInput   = document.getElementById('file-' + key);
    const hiddenInput = document.getElementById('hidden-' + key);
    const removeCheckbox = document.getElementById('remove-img-' + key);

    // Reset UI
    if(previewWrap) previewWrap.style.display = 'none';
    if(emptyState) emptyState.style.display  = 'flex';
    if(badge) badge.innerHTML = '<span class="no-image-badge"><span class="material-symbols-outlined" style="font-size:13px;">image_not_supported</span> Foto dihapus – simpan untuk konfirmasi</span>';

    // Clear file input
    if(fileInput) fileInput.value = '';

    // Signal removal via hidden input (for page-contents array)
    if(hiddenInput) hiddenInput.value = '';
    
    // Signal removal via checkbox (for standard forms like services)
    if(removeCheckbox) removeCheckbox.checked = true;
}
</script>
@endpush
