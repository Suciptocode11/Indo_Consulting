@extends('admin.layouts.app')

@section('title', 'Gallery')
@section('page-title', 'Gallery')

@section('content')
<div x-data="{ tab: '{{ $tab }}' }">
    {{-- Tab Navigation --}}
    <div style="display: flex; gap: 4px; margin-bottom: 24px; border-bottom: 1px solid #e2e8f0; padding-bottom: 0;">
        <button @click="tab = 'albums'" :class="tab === 'albums' ? 'bg-primary text-white' : 'bg-surface-container text-on-surface-variant'" class="px-5 py-2.5 rounded-t-lg font-semibold text-sm transition-all" style="border: none; cursor: pointer; font-family: 'Outfit', sans-serif;">
            <span class="material-symbols-outlined" style="font-size: 18px; vertical-align: middle; margin-right: 4px;">photo_library</span> Album
        </button>
        <button @click="tab = 'photos'" :class="tab === 'photos' ? 'bg-primary text-white' : 'bg-surface-container text-on-surface-variant'" class="px-5 py-2.5 rounded-t-lg font-semibold text-sm transition-all" style="border: none; cursor: pointer; font-family: 'Outfit', sans-serif;">
            <span class="material-symbols-outlined" style="font-size: 18px; vertical-align: middle; margin-right: 4px;">photo</span> Foto
        </button>
        <button @click="tab = 'videos'" :class="tab === 'videos' ? 'bg-primary text-white' : 'bg-surface-container text-on-surface-variant'" class="px-5 py-2.5 rounded-t-lg font-semibold text-sm transition-all" style="border: none; cursor: pointer; font-family: 'Outfit', sans-serif;">
            <span class="material-symbols-outlined" style="font-size: 18px; vertical-align: middle; margin-right: 4px;">videocam</span> Video
        </button>
    </div>

    {{-- =================== TAB: ALBUM =================== --}}
    <div x-show="tab === 'albums'" x-transition>
        <div style="display: flex; justify-content: flex-end; margin-bottom: 16px;">
            <a href="{{ route('admin.gallery.album-create') }}" class="btn btn-primary">
                <span class="material-symbols-outlined">add</span> Tambah Album
            </a>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 12px;">
            @forelse($albums as $album)
                <div style="background: white; border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden;">
                    @if($album->img)
                        <img src="{{ asset('storage/' . $album->img) }}" style="width: 100%; height: 140px; object-fit: cover;" alt="{{ $album->title }}">
                    @else
                        <div style="width: 100%; height: 140px; background: #f1f5f9; display: flex; align-items: center; justify-content: center;">
                            <span class="material-symbols-outlined" style="font-size: 40px; color: #cbd5e1;">photo_library</span>
                        </div>
                    @endif
                    <div style="padding: 10px 12px;">
                        <div style="display: flex; justify-content: space-between; align-items: start;">
                            <div style="flex: 1; min-width: 0;">
                                <strong style="font-size: 13px; display: block; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $album->title }}</strong>
                                <span style="font-size: 11px; color: #64748b;">{{ $album->photos_count ?? 0 }} foto</span>
                            </div>
                            <span class="badge {{ $album->status === 'Show' ? 'badge-success' : 'badge-danger' }}" style="font-size: 10px;">{{ $album->status }}</span>
                        </div>
                        <div style="display: flex; gap: 6px; margin-top: 8px;">
                            <a href="{{ route('admin.gallery.album-edit', $album) }}" class="btn btn-secondary btn-sm" style="flex: 1; justify-content: center;">
                                <span class="material-symbols-outlined" style="font-size: 14px;">edit</span> Kelola
                            </a>
                            <form method="POST" action="{{ route('admin.gallery.album-destroy', $album) }}" onsubmit="return confirm('Hapus album dan semua fotonya?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <span class="material-symbols-outlined" style="font-size: 14px;">delete</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <p style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #94a3b8;">Belum ada album.</p>
            @endforelse
        </div>
    </div>

    {{-- =================== TAB: FOTO =================== --}}
    <div x-show="tab === 'photos'" x-transition>
        <div style="display: flex; justify-content: flex-end; margin-bottom: 16px;">
            <form method="POST" action="{{ route('admin.gallery.foto-store') }}" enctype="multipart/form-data" style="display: flex; gap: 8px; align-items: flex-end;">
                @csrf
                <div style="display: flex; flex-direction: column; gap: 4px;">
                    <label style="font-size: 11px; color: #64748b; font-weight: 600; font-family: 'Outfit', sans-serif;">File Foto</label>
                    <input type="file" name="img" accept="image/*" required style="padding: 6px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 12px; font-family: 'Outfit', sans-serif;">
                </div>
                <div style="display: flex; flex-direction: column; gap: 4px;">
                    <label style="font-size: 11px; color: #64748b; font-weight: 600; font-family: 'Outfit', sans-serif;">Keterangan Foto</label>
                    <input type="text" name="caption" placeholder="Contoh: Rapat Tim 2024..." style="padding: 8px 12px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 12px; font-family: 'Outfit', sans-serif; width: 200px;">
                </div>
                <div style="display: flex; flex-direction: column; gap: 4px;">
                    <label style="font-size: 11px; color: #64748b; font-weight: 600; font-family: 'Outfit', sans-serif;">Album (Opsional)</label>
                    <select name="id_album" style="padding: 8px 12px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 12px; font-family: 'Outfit', sans-serif;">
                        <option value="">Standalone</option>
                        @foreach($albums as $a)
                            <option value="{{ $a->id }}">{{ $a->title }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary btn-sm">Upload</button>
            </form>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 10px;">
            @forelse($photos as $foto)
                <div x-data="{ editMode: false }" style="position: relative; border-radius: 10px; overflow: hidden; border: 1px solid #e2e8f0; background: #f8fafc;">
                    <img src="{{ asset('storage/' . $foto->img) }}" style="width: 100%; height: 140px; object-fit: cover;" alt="Foto">
                    
                    <!-- View Mode -->
                    <div x-show="!editMode" style="padding: 6px 8px;">
                        <div style="display: flex; justify-content: space-between; align-items: start; gap: 4px;">
                            <div style="flex: 1; min-width: 0;">
                                <span style="font-size: 11px; color: #64748b; display: block; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $foto->caption ?? ($foto->album->title ?? 'Standalone') }}">
                                    {{ $foto->caption ?? ($foto->album->title ?? 'Standalone') }}
                                </span>
                            </div>
                            <div style="display: flex; gap: 4px; flex-shrink: 0;">
                                <button @click="editMode = true" style="background: none; border: none; cursor: pointer; color: #3b82f6; padding: 2px;" title="Edit Caption">
                                    <span class="material-symbols-outlined" style="font-size: 16px;">edit</span>
                                </button>
                                <form method="POST" action="{{ route('admin.gallery.foto-destroy', $foto) }}" onsubmit="return confirm('Hapus foto ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" style="background: none; border: none; cursor: pointer; color: #dc2626; padding: 2px;">
                                        <span class="material-symbols-outlined" style="font-size: 16px;">delete</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Edit Mode -->
                    <div x-show="editMode" style="padding: 6px 8px;">
                        <form method="POST" action="{{ route('admin.gallery.foto-update', $foto) }}">
                            @csrf @method('PUT')
                            <div style="display: flex; flex-direction: column; gap: 4px;">
                                <input type="text" name="caption" value="{{ $foto->caption }}" placeholder="Keterangan foto..." style="width: 100%; padding: 4px 6px; border: 1px solid #e2e8f0; border-radius: 6px; font-size: 11px; font-family: 'Outfit', sans-serif;">
                                <div style="display: flex; gap: 4px;">
                                    <button type="submit" class="btn btn-primary" style="flex: 1; padding: 4px 8px; font-size: 10px;">Simpan</button>
                                    <button type="button" @click="editMode = false" class="btn btn-secondary" style="flex: 1; padding: 4px 8px; font-size: 10px;">Batal</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @empty
                <p style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #94a3b8;">Belum ada foto.</p>
            @endforelse
        </div>
    </div>

    {{-- =================== TAB: VIDEO =================== --}}
    <div x-show="tab === 'videos'" x-transition>
        <div style="display: flex; justify-content: flex-end; margin-bottom: 16px;">
            <a href="{{ route('admin.gallery.video-create') }}" class="btn btn-primary">
                <span class="material-symbols-outlined">add</span> Tambah Video
            </a>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 12px;">
            @forelse($videos as $vid)
                <div style="background: white; border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden;">
                    @if(str_contains($vid->source, 'youtube'))
                        <iframe src="{{ $vid->source }}" style="width: 100%; height: 160px; border: 0;" allowfullscreen loading="lazy"></iframe>
                    @elseif($vid->source)
                        <video src="{{ asset('storage/' . $vid->source) }}" style="width: 100%; height: 160px; object-fit: cover;" preload="metadata"></video>
                    @else
                        <div style="width: 100%; height: 160px; background: #f1f5f9; display: flex; align-items: center; justify-content: center;">
                            <span class="material-symbols-outlined" style="font-size: 40px; color: #cbd5e1;">videocam</span>
                        </div>
                    @endif
                    <div style="padding: 10px 12px;">
                        <div style="display: flex; justify-content: space-between; align-items: start;">
                            <strong style="font-size: 13px; flex: 1; min-width: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $vid->title }}</strong>
                            <span class="badge {{ $vid->status === 'Show' ? 'badge-success' : 'badge-danger' }}" style="font-size: 10px;">{{ $vid->status }}</span>
                        </div>
                        <div style="display: flex; gap: 6px; margin-top: 8px;">
                            <a href="{{ route('admin.gallery.video-edit', $vid) }}" class="btn btn-secondary btn-sm" style="flex: 1; justify-content: center;">
                                <span class="material-symbols-outlined" style="font-size: 14px;">edit</span> Edit
                            </a>
                            <form method="POST" action="{{ route('admin.gallery.video-destroy', $vid) }}" onsubmit="return confirm('Yakin hapus?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <span class="material-symbols-outlined" style="font-size: 14px;">delete</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <p style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #94a3b8;">Belum ada video.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
