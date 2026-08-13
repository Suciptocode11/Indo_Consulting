@extends('layouts.app')

@section('title', 'News & Events - Indo Consulting')
@section('description', 'Berita terbaru dan acara mendatang dari Indo Consulting.')

@section('content')

<div x-data="{ filter: 'all' }">

{{-- Page Header --}}
<div class="pt-16 lg:pt-18 bg-surface">
    <div class="max-w-container mx-auto px-responsive pt-12 pb-10 border-b border-outline-variant/40">
        <span class="text-label-sm text-secondary font-outfit font-semibold uppercase tracking-widest">{{ $pageContent['page_label'] ?? 'Informasi Terkini' }}</span>
        <h1 class="text-3xl md:text-headline-lg font-outfit font-bold text-primary mt-2">{!! $pageContent['page_heading'] ?? 'News &amp; Events' !!}</h1>

        {{-- Filter Buttons (dynamic) --}}
        <div class="flex flex-wrap gap-3 mt-6">
            <button @click="filter = 'all'" :class="filter === 'all' ? 'bg-secondary text-white shadow-md' : 'bg-white text-on-surface border border-outline-variant/40'" class="px-5 py-2 rounded-full text-label-md font-outfit font-semibold transition-all duration-300 hover:shadow-md hover:scale-105 hover:bg-secondary hover:text-white hover:border-secondary active:scale-95">Semua</button>
            @foreach($categories as $cat)
            <button @click="filter = '{{ $cat }}'" :class="filter === '{{ $cat }}' ? 'bg-secondary text-white shadow-md' : 'bg-white text-on-surface border border-outline-variant/40'" class="px-5 py-2 rounded-full text-label-md font-outfit font-semibold transition-all duration-300 hover:shadow-md hover:scale-105 hover:bg-secondary hover:text-white hover:border-secondary active:scale-95">{{ $cat }}</button>
            @endforeach
        </div>
    </div>
</div>

{{-- News Grid --}}
<section class="py-block-gap bg-surface-container-low">
    <div class="max-w-container mx-auto px-responsive">
        <div class="space-y-6" data-stagger>
            @forelse($blogs as $i => $article)
            @if($i === 0)
            {{-- Featured Article (first, full width) --}}
            <a href="{{ route('blog.show', $article->slug) }}" class="reveal bg-white rounded-2xl overflow-hidden border border-outline-variant/60 soft-shadow-md card-hover group block" x-show="filter === 'all' || filter === '{{ $article->kategori->title ?? '' }}'" x-transition>
                <div class="grid lg:grid-cols-2">
                    <div class="relative h-64 lg:h-auto overflow-hidden">
                        @if($article->img && !str_starts_with($article->img, 'http'))
                            <img src="{{ asset('storage/' . $article->img) }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @elseif($article->img)
                            <img src="{{ $article->img }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full bg-surface-container flex items-center justify-center"><span class="material-symbols-outlined text-6xl text-on-surface-variant/30">newspaper</span></div>
                        @endif
                    </div>
                    <div class="p-8 flex flex-col justify-center">
                        <div class="flex items-center gap-3 mb-4 flex-wrap">
                            <span class="text-label-sm font-outfit font-semibold text-secondary">{{ $article->kategori->title ?? '' }}</span>
                            <span class="text-on-surface-variant/40">·</span>
                            <time class="text-label-sm text-on-surface-variant/70">{{ $article->date }}</time>
                            <span class="text-on-surface-variant/40">·</span>
                            <span class="text-label-sm text-on-surface-variant/70 flex items-center gap-1"><span class="material-symbols-outlined text-sm">visibility</span> {{ number_format($article->hit ?? 0) }}</span>
                        </div>
                        <h3 class="text-headline-md font-outfit font-semibold text-primary mb-4">{{ $article->title }}</h3>
                        <p class="text-body-lg text-on-surface-variant leading-relaxed mb-6">{{ $article->caption ?? '' }}</p>
                        <div class="pt-4 border-t border-outline-variant/20">
                            <span class="inline-flex items-center gap-2 text-label-lg font-outfit font-semibold text-secondary group-hover:gap-3 transition-all duration-300">
                                Lihat Detail
                                <span class="material-symbols-outlined text-lg">arrow_forward</span>
                            </span>
                        </div>
                    </div>
                </div>
            </a>
            @else
            {{-- Supporting Articles (2-col grid) --}}
            @if($i === 1) <div class="grid grid-cols-1 md:grid-cols-2 gap-6"> @endif
                <a href="{{ route('blog.show', $article->slug) }}" class="reveal bg-white rounded-2xl overflow-hidden border border-outline-variant/60 soft-shadow-md card-hover group flex flex-col h-full" x-show="filter === 'all' || filter === '{{ $article->kategori->title ?? '' }}'" x-transition>
                    <div class="relative h-48 overflow-hidden flex-shrink-0">
                        @if($article->img && !str_starts_with($article->img, 'http'))
                            <img src="{{ asset('storage/' . $article->img) }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @elseif($article->img)
                            <img src="{{ $article->img }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full bg-surface-container flex items-center justify-center"><span class="material-symbols-outlined text-5xl text-on-surface-variant/30">newspaper</span></div>
                        @endif
                    </div>
                    <div class="p-6 flex flex-col flex-1">
                        <div class="flex items-center gap-3 mb-3 flex-wrap">
                            <span class="text-label-sm font-outfit font-semibold text-secondary">{{ $article->kategori->title ?? '' }}</span>
                            <span class="text-on-surface-variant/40">·</span>
                            <time class="text-label-sm text-on-surface-variant/70">{{ $article->date }}</time>
                            <span class="text-on-surface-variant/40">·</span>
                            <span class="text-label-sm text-on-surface-variant/70 flex items-center gap-1"><span class="material-symbols-outlined text-sm">visibility</span> {{ number_format($article->hit ?? 0) }}</span>
                        </div>
                        <h3 class="text-body-lg font-outfit font-semibold text-primary mb-3 line-clamp-2">{{ $article->title }}</h3>
                        <p class="text-body-md text-on-surface-variant leading-relaxed mb-4 flex-1 line-clamp-3">{{ $article->caption ?? '' }}</p>
                        <div class="mt-auto pt-3 border-t border-outline-variant/20">
                            <span class="inline-flex items-center gap-2 text-label-md font-outfit font-semibold text-secondary group-hover:gap-3 transition-all duration-300">
                                Lihat Detail
                                <span class="material-symbols-outlined text-base">arrow_forward</span>
                            </span>
                        </div>
                    </div>
                </a>
            @if($loop->last) </div> @endif
            @endif
            @empty
            <p class="text-center text-on-surface-variant py-12">Belum ada berita atau acara.</p>
            @endforelse
        </div>
    </div>
</section>

</div>

@endsection
