@extends('layouts.app')

@section('title', 'Gallery - Indo Consulting')
@section('description', 'Galeri foto dan video kegiatan Indo Consulting.')

@section('content')

<div x-data="{ filter: 'all', showAlbum: null }">

{{-- Page Header --}}
<div class="pt-16 lg:pt-18 bg-surface">
    <div class="max-w-container mx-auto px-responsive pt-12 pb-10 border-b border-outline-variant/40">
        <span class="text-label-sm text-secondary font-outfit font-semibold uppercase tracking-widest">{{ $pageContent['page_label'] ?? 'Dokumentasi' }}</span>
        <h1 class="text-3xl md:text-headline-lg font-outfit font-bold text-primary mt-2">{!! $pageContent['page_heading'] ?? 'Gallery' !!}</h1>
    </div>
</div>

{{-- Gallery Grid --}}
<section class="py-block-gap bg-surface-container-low">
    <div class="max-w-container mx-auto px-responsive">

        {{-- Filter Buttons --}}
        <div class="flex flex-wrap gap-3 mb-8 reveal">
            <button @click="filter = 'all'" :class="filter === 'all' ? 'bg-secondary text-white shadow-md' : 'bg-white text-on-surface border border-outline-variant/40'" class="px-6 py-2.5 rounded-full text-label-md font-outfit font-semibold transition-all duration-300 hover:shadow-md hover:scale-105 hover:bg-secondary hover:text-white hover:border-secondary active:scale-95">Semua</button>
            @if($albums->isNotEmpty())
                <button @click="filter = 'album'" :class="filter === 'album' ? 'bg-secondary text-white shadow-md' : 'bg-white text-on-surface border border-outline-variant/40'" class="px-6 py-2.5 rounded-full text-label-md font-outfit font-semibold transition-all duration-300">Album</button>
            @endif
            @if($standalonePhotos->isNotEmpty())
                <button @click="filter = 'photo'" :class="filter === 'photo' ? 'bg-secondary text-white shadow-md' : 'bg-white text-on-surface border border-outline-variant/40'" class="px-6 py-2.5 rounded-full text-label-md font-outfit font-semibold transition-all duration-300">Foto</button>
            @endif
            @if($videos->isNotEmpty())
                <button @click="filter = 'video'" :class="filter === 'video' ? 'bg-secondary text-white shadow-md' : 'bg-white text-on-surface border border-outline-variant/40'" class="px-6 py-2.5 rounded-full text-label-md font-outfit font-semibold transition-all duration-300">Video</button>
            @endif
        </div>

        {{-- Uniform grid --}}
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4" data-stagger>

            {{-- Albums --}}
            @foreach($albums as $album)
            <div class="reveal group relative rounded-2xl overflow-hidden cursor-pointer aspect-square"
                 x-show="filter === 'all' || filter === 'album'" x-transition
                 @click="showAlbum = showAlbum === {{ $album->id }} ? null : {{ $album->id }}">
                @if($album->img && !str_starts_with($album->img, 'http'))
                    <img src="{{ asset('storage/' . $album->img) }}" alt="{{ $album->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                @elseif($album->img)
                    <img src="{{ $album->img }}" alt="{{ $album->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                @else
                    <div class="w-full h-full bg-surface-container flex items-center justify-center">
                        <span class="material-symbols-outlined text-6xl text-on-surface-variant/30">photo_library</span>
                    </div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-primary/70 to-transparent"></div>
                <div class="absolute bottom-3 left-4 right-4">
                    <p class="text-white font-outfit font-semibold text-label-md leading-snug">{{ $album->title }}</p>
                    <span class="text-white/70 text-label-sm">{{ $album->photos->count() }} foto</span>
                </div>
                <div class="absolute top-3 right-3 w-9 h-9 bg-black/50 backdrop-blur-sm rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                    <span class="material-symbols-outlined text-white text-lg" x-text="showAlbum === {{ $album->id }} ? 'close' : 'visibility'"></span>
                </div>
            </div>
            @endforeach

            {{-- Standalone Photos --}}
            @foreach($standalonePhotos as $foto)
            <div class="reveal group relative rounded-2xl overflow-hidden aspect-square" x-show="filter === 'all' || filter === 'photo'" x-transition>
                <img src="{{ asset('storage/' . $foto->img) }}" alt="Foto" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
            </div>
            @endforeach

            {{-- Videos --}}
            @foreach($videos as $vid)
            <div class="reveal group relative rounded-2xl overflow-hidden aspect-square" x-show="filter === 'all' || filter === 'video'" x-transition>
                @if(str_contains($vid->source, 'youtube'))
                    <iframe src="{{ $vid->source }}" class="w-full h-full" frameborder="0" allowfullscreen loading="lazy"></iframe>
                @else
                    <video src="{{ asset('storage/' . $vid->source) }}" class="w-full h-full object-cover" preload="metadata"></video>
                    <div class="absolute top-3 right-3 w-10 h-10 bg-black/60 backdrop-blur-sm rounded-full flex items-center justify-center">
                        <span class="material-symbols-outlined text-white text-xl">play_arrow</span>
                    </div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-primary/70 to-transparent pointer-events-none"></div>
                <div class="absolute bottom-3 left-4 right-4 pointer-events-none">
                    <p class="text-white font-outfit font-semibold text-label-md leading-snug">{{ $vid->title }}</p>
                </div>
            </div>
            @endforeach

        </div>

        @if($albums->isEmpty() && $standalonePhotos->isEmpty() && $videos->isEmpty())
            <p class="text-center text-on-surface-variant py-16">Belum ada konten gallery.</p>
        @endif

        {{-- Album Drill-down Modal --}}
        <template x-if="showAlbum !== null">
            <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 backdrop-blur-sm p-4" @click.self="showAlbum = null">
                <div class="bg-white rounded-2xl max-w-4xl w-full max-h-[85vh] overflow-y-auto p-6">
                    @foreach($albums as $album)
                    <div x-show="showAlbum === {{ $album->id }}">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-headline-sm font-outfit font-bold text-primary">{{ $album->title }}</h3>
                            <button @click="showAlbum = null" class="w-8 h-8 rounded-full bg-surface flex items-center justify-center hover:bg-surface-container">
                                <span class="material-symbols-outlined text-lg">close</span>
                            </button>
                        </div>
                        @if($album->photos->isEmpty())
                            <p class="text-center text-on-surface-variant py-8">Belum ada foto di album ini.</p>
                        @else
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                @foreach($album->photos as $foto)
                                <div class="rounded-lg overflow-hidden aspect-square">
                                    <img src="{{ asset('storage/' . $foto->img) }}" alt="Foto" class="w-full h-full object-cover">
                                </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </template>

    </div>
</section>

</div>

@endsection
