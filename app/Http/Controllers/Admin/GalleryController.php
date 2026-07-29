<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Foto;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    public function index()
    {
        $tab = request('tab', 'albums');

        $albums = Album::withCount('photos')->orderByDesc('id')->get();
        $photos = Foto::with('album')->orderByDesc('id')->get();
        $videos = Video::orderByDesc('id')->get();

        return view('admin.gallery.index', compact('albums', 'photos', 'videos', 'tab'));
    }

    // ========== ALBUM ==========

    public function albumCreate()
    {
        return view('admin.gallery.album-create');
    }

    public function albumStore(Request $request)
    {
        $validated = $request->validate([
            'title'  => 'required|string|max:100',
            'img'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'slug'   => 'nullable|string|max:255',
            'date'   => 'nullable|date',
            'status' => 'required|in:Show,Hide',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        if ($request->hasFile('img')) {
            $validated['img'] = $request->file('img')->store('albums', 'public');
        }

        Album::create($validated);

        return redirect()->route('admin.gallery.index', ['tab' => 'albums'])->with('success', 'Album berhasil ditambahkan.');
    }

    public function albumEdit(Album $album)
    {
        return view('admin.gallery.album-edit', compact('album'));
    }

    public function albumUpdate(Request $request, Album $album)
    {
        $validated = $request->validate([
            'title'  => 'required|string|max:100',
            'img'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'slug'   => 'nullable|string|max:255',
            'date'   => 'nullable|date',
            'status' => 'required|in:Show,Hide',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        if ($request->hasFile('img')) {
            if ($album->img && \Storage::disk('public')->exists($album->img)) {
                \Storage::disk('public')->delete($album->img);
            }
            $validated['img'] = $request->file('img')->store('albums', 'public');
        }

        $album->update($validated);

        return redirect()->route('admin.gallery.index', ['tab' => 'albums'])->with('success', 'Album berhasil diupdate.');
    }

    public function albumDestroy(Album $album)
    {
        foreach ($album->photos as $foto) {
            if ($foto->img && \Storage::disk('public')->exists($foto->img)) {
                \Storage::disk('public')->delete($foto->img);
            }
            $foto->delete();
        }

        if ($album->img && \Storage::disk('public')->exists($album->img)) {
            \Storage::disk('public')->delete($album->img);
        }

        $album->delete();

        return redirect()->route('admin.gallery.index', ['tab' => 'albums'])->with('success', 'Album dan semua foto berhasil dihapus.');
    }

    // ========== FOTO ==========

    public function fotoStore(Request $request)
    {
        $validated = $request->validate([
            'img'      => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'id_album' => 'nullable|integer|exists:album,id',
        ]);

        if ($request->hasFile('img')) {
            $validated['img'] = $request->file('img')->store('photos', 'public');
        }

        Foto::create($validated);

        $tab = !empty($validated['id_album']) ? 'albums' : 'photos';
        return redirect()->route('admin.gallery.index', ['tab' => $tab])->with('success', 'Foto berhasil ditambahkan.');
    }

    public function fotoDestroy(Foto $foto)
    {
        if ($foto->img && \Storage::disk('public')->exists($foto->img)) {
            \Storage::disk('public')->delete($foto->img);
        }

        $foto->delete();

        return redirect()->route('admin.gallery.index', ['tab' => 'photos'])->with('success', 'Foto berhasil dihapus.');
    }

    public function fotoStoreInAlbum(Request $request, Album $album)
    {
        $request->validate([
            'img' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $path = $request->file('img')->store('photos', 'public');

        Foto::create([
            'id_album' => $album->id,
            'img'      => $path,
        ]);

        return redirect()->route('admin.gallery.album-edit', $album)->with('success', 'Foto berhasil ditambahkan ke album.');
    }

    public function fotoDestroyFromAlbum(Album $album, Foto $foto)
    {
        if ($foto->id_album != $album->id) {
            return back()->with('error', 'Foto tidak termasuk di album ini.');
        }

        if ($foto->img && \Storage::disk('public')->exists($foto->img)) {
            \Storage::disk('public')->delete($foto->img);
        }

        $foto->delete();

        return redirect()->route('admin.gallery.album-edit', $album)->with('success', 'Foto berhasil dihapus dari album.');
    }

    // ========== VIDEO ==========

    public function videoCreate()
    {
        return view('admin.gallery.video-create');
    }

    public function videoStore(Request $request)
    {
        $sourceType = $request->input('source_type');

        $validated = $request->validate([
            'title'       => 'required|string|max:500',
            'source_type' => 'required|in:youtube,upload',
            'source_url'  => $sourceType === 'youtube' ? 'required|string|max:500' : 'nullable|string|max:500',
            'source_file' => $sourceType === 'upload' ? 'required|file|mimes:mp4,webm,ogg|max:51200' : 'nullable',
            'content'     => 'nullable|string',
            'date'        => 'nullable|date',
            'status'      => 'required|in:Show,Hide',
            'slug'        => 'nullable|string|max:255',
        ]);

        if ($sourceType === 'youtube') {
            $validated['source'] = $this->convertToEmbed($validated['source_url']);
        } elseif ($request->hasFile('source_file')) {
            $validated['source'] = $request->file('source_file')->store('videos', 'public');
        }

        unset($validated['source_type'], $validated['source_url'], $validated['source_file']);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        Video::create($validated);

        return redirect()->route('admin.gallery.index', ['tab' => 'videos'])->with('success', 'Video berhasil ditambahkan.');
    }

    public function videoEdit(Video $video)
    {
        return view('admin.gallery.video-edit', compact('video'));
    }

    public function videoUpdate(Request $request, Video $video)
    {
        $sourceType = $request->input('source_type');

        $validated = $request->validate([
            'title'       => 'required|string|max:500',
            'source_type' => 'required|in:youtube,upload',
            'source_url'  => $sourceType === 'youtube' ? 'nullable|string|max:500' : 'nullable|string|max:500',
            'source_file' => $sourceType === 'upload' ? 'nullable|file|mimes:mp4,webm,ogg|max:51200' : 'nullable',
            'content'     => 'nullable|string',
            'date'        => 'nullable|date',
            'status'      => 'required|in:Show,Hide',
            'slug'        => 'nullable|string|max:255',
        ]);

        if ($sourceType === 'youtube' && !empty($validated['source_url'])) {
            $validated['source'] = $this->convertToEmbed($validated['source_url']);
        } elseif ($sourceType === 'upload' && $request->hasFile('source_file')) {
            if ($video->source && !str_contains($video->source, 'youtube') && \Storage::disk('public')->exists($video->source)) {
                \Storage::disk('public')->delete($video->source);
            }
            $validated['source'] = $request->file('source_file')->store('videos', 'public');
        }

        unset($validated['source_type'], $validated['source_url'], $validated['source_file']);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $video->update($validated);

        return redirect()->route('admin.gallery.index', ['tab' => 'videos'])->with('success', 'Video berhasil diupdate.');
    }

    public function videoDestroy(Video $video)
    {
        if ($video->source && !str_contains($video->source, 'youtube') && \Storage::disk('public')->exists($video->source)) {
            \Storage::disk('public')->delete($video->source);
        }

        $video->delete();

        return redirect()->route('admin.gallery.index', ['tab' => 'videos'])->with('success', 'Video berhasil dihapus.');
    }

    private function convertToEmbed($url): string
    {
        if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([\w-]+)/', $url, $matches)) {
            return 'https://www.youtube.com/embed/' . $matches[1];
        }
        return $url;
    }
}
