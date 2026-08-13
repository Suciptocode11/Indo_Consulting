@extends('admin.layouts.app')

@section('title', 'Edit Album')
@section('page-title', 'Edit Album: ' . $album->title)

@section('content')
<a href="{{ route('admin.gallery.index', ['tab' => 'albums']) }}" style="display: inline-flex; align-items: center; gap: 4px; font-size: 13px; color: #64748b; text-decoration: none; margin-bottom: 16px;">
    <span class="material-symbols-outlined" style="font-size: 18px;">arrow_back</span> Kembali ke Gallery
</a>

<div class="card" style="max-width: 720px; margin-bottom: 24px;">
    <form method="POST" action="{{ route('admin.gallery.album-update', $album) }}" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="form-group">
            <label>Judul Album *</label>
            <input type="text" name="title" value="{{ old('title', $album->title) }}" required>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Cover Album</label>
                @if($album->img)
                    <div style="margin-bottom: 8px;"><img src="{{ asset('storage/' . $album->img) }}" style="height: 80px; border-radius: 8px; object-fit: cover;"></div>
                @endif
                <input type="file" name="img" accept="image/*">
            </div>
            <div class="form-group">
                <label>Tanggal</label>
                <input type="date" name="date" value="{{ old('date', $album->date) }}">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Slug</label>
                <input type="text" name="slug" value="{{ old('slug', $album->slug) }}">
            </div>
            <div class="form-group">
                <label>Status *</label>
                <select name="status" required>
                    <option value="Show" {{ old('status', $album->status) === 'Show' ? 'selected' : '' }}>Show</option>
                    <option value="Hide" {{ old('status', $album->status) === 'Hide' ? 'selected' : '' }}>Hide</option>
                </select>
            </div>
        </div>

        <div style="display: flex; gap: 10px; margin-top: 20px;">
            <button type="submit" class="btn btn-primary">Update Album</button>
        </div>
    </form>
</div>

<div class="card">
    <h3 style="font-size: 14px; font-weight: 600; color: #64748b; margin-bottom: 16px; text-transform: uppercase; letter-spacing: 0.5px;">Foto dalam Album ({{ $album->photos->count() }})</h3>

    <form method="POST" action="{{ route('admin.gallery.album-foto-store', $album) }}" enctype="multipart/form-data" style="margin-bottom: 20px; padding: 16px; background: #f8fafc; border-radius: 10px;">
        @csrf
        <div style="display: flex; gap: 10px; align-items: end;">
            <div style="flex: 1;">
                <label style="font-size: 13px; font-weight: 600; color: #334155; display: block; margin-bottom: 4px;">Upload Foto Baru</label>
                <input type="file" name="img" accept="image/*" required style="width: 100%; padding: 8px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 13px; font-family: 'Outfit', sans-serif;">
            </div>
            <div style="flex: 1;">
                <label style="font-size: 13px; font-weight: 600; color: #334155; display: block; margin-bottom: 4px;">Keterangan Foto</label>
                <input type="text" name="caption" placeholder="Contoh: Rapat Tim 2024..." style="width: 100%; padding: 8px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 13px; font-family: 'Outfit', sans-serif;">
            </div>
            <button type="submit" class="btn btn-primary btn-sm">Upload</button>
        </div>
    </form>

    @if($album->photos->isEmpty())
        <p style="text-align: center; padding: 30px; color: #94a3b8;">Belum ada foto.</p>
    @else
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); gap: 10px;">
            @foreach($album->photos as $foto)
                <div x-data="{ editMode: false }" style="position: relative; border-radius: 10px; overflow: hidden; border: 1px solid #e2e8f0; background: white;">
                    <img src="{{ asset('storage/' . $foto->img) }}" style="width: 100%; height: 130px; object-fit: cover;" alt="Foto">
                    
                    <!-- View Mode -->
                    <div x-show="!editMode" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; display: flex; flex-direction: column;">
                        <div style="flex: 1;"></div>
                        <div style="background: linear-gradient(to top, rgba(0,0,0,0.7), transparent); padding: 6px 8px;">
                            <div style="display: flex; justify-content: space-between; align-items: end; gap: 4px;">
                                @if($foto->caption)
                                    <span style="font-size: 10px; color: white; display: block; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; flex: 1;" title="{{ $foto->caption }}">{{ $foto->caption }}</span>
                                @else
                                    <span style="font-size: 10px; color: rgba(255,255,255,0.6); flex: 1;">Tanpa caption</span>
                                @endif
                                <div style="display: flex; gap: 4px;">
                                    <button @click="editMode = true" style="width: 24px; height: 24px; border-radius: 50%; background: rgba(255,255,255,0.9); border: none; cursor: pointer; display: flex; align-items: center; justify-content: center;" title="Edit Caption">
                                        <span class="material-symbols-outlined" style="font-size: 14px; color: #3b82f6;">edit</span>
                                    </button>
                                    <form method="POST" action="{{ route('admin.gallery.album-foto-destroy', [$album, $foto]) }}" onsubmit="return confirm('Hapus foto ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" style="width: 24px; height: 24px; border-radius: 50%; background: rgba(0,0,0,0.6); border: none; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                                            <span class="material-symbols-outlined" style="font-size: 14px; color: white;">close</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Edit Mode -->
                    <div x-show="editMode" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.85); padding: 8px; display: flex; flex-direction: column; justify-content: center;">
                        <form method="POST" action="{{ route('admin.gallery.foto-update', $foto) }}">
                            @csrf @method('PUT')
                            <div style="display: flex; flex-direction: column; gap: 6px;">
                                <input type="text" name="caption" value="{{ $foto->caption }}" placeholder="Keterangan foto..." style="width: 100%; padding: 6px 8px; border: 1px solid #e2e8f0; border-radius: 6px; font-size: 11px; font-family: 'Outfit', sans-serif;">
                                <div style="display: flex; gap: 4px;">
                                    <button type="submit" class="btn btn-primary" style="flex: 1; padding: 6px 8px; font-size: 10px;">Simpan</button>
                                    <button type="button" @click="editMode = false" class="btn btn-secondary" style="flex: 1; padding: 6px 8px; font-size: 10px;">Batal</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
