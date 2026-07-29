<div class="image-upload-widget" id="widget-{{ $key }}">
    <div class="image-upload-dropzone" id="dropzone-{{ $key }}">
        {{-- Hidden file input --}}
        <input
            type="file"
            name="{{ $name }}"
            id="file-{{ $key }}"
            accept="image/jpeg,image/png,image/webp,image/gif"
            data-key="{{ $key }}"
        >

        {{-- Preview state (shown when image is set) --}}
        <div class="image-preview-wrap" id="preview-{{ $key }}"
            @if(!empty($value)) style="display:block;" @endif>
            <img
                id="preview-img-{{ $key }}"
                src="{{ !empty($value) ? (str_starts_with($value, 'http') ? $value : asset('storage/' . $value)) : '' }}"
                alt="Preview"
            >
            <div class="image-preview-overlay">
                <label for="file-{{ $key }}" class="image-action-btn btn-change-img" onclick="event.stopPropagation();">
                    <span class="material-symbols-outlined" style="font-size:15px;">upload</span>
                    Ganti Foto
                </label>
                <button type="button" class="image-action-btn btn-remove-img" onclick="removeImage('{{ $key }}')">
                    <span class="material-symbols-outlined" style="font-size:15px;">delete</span>
                    Hapus
                </button>
            </div>
        </div>

        {{-- Empty state (shown when no image) --}}
        <div class="image-empty-state" id="empty-{{ $key }}"
            @if(!empty($value)) style="display:none;" @endif>
            <div class="upload-icon">
                <span class="material-symbols-outlined">add_photo_alternate</span>
            </div>
            <div>
                <strong>Klik atau seret foto ke sini</strong>
                <span>JPG, PNG, WebP – maks. 5 MB</span>
            </div>
        </div>
    </div>

    {{-- Status Badge --}}
    <div id="badge-{{ $key }}">
        @if(!empty($value))
            <span class="current-image-badge">
                <span class="material-symbols-outlined" style="font-size:13px;">check_circle</span>
                Foto tersimpan
            </span>
        @else
            <span class="no-image-badge">
                <span class="material-symbols-outlined" style="font-size:13px;">image_not_supported</span>
                Belum ada foto
            </span>
        @endif
    </div>

    {{-- Optional hidden inputs for standard forms (to flag image removal) --}}
    @if(isset($arrayInput) && $arrayInput)
        <input type="hidden" name="contents[{{ $key }}]" id="hidden-{{ $key }}" value="{{ old('contents.' . $key, $value) }}">
    @else
        <input type="checkbox" name="remove_img_{{ $key }}" id="remove-img-{{ $key }}" value="1" style="display: none;">
    @endif
</div>
