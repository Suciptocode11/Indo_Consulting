@extends('layouts.app')

@section('title', 'Portfolio - Indo Consulting')
@section('description', 'Portofolio proyek Indo Consulting — karya nyata yang membawa dampak bagi klien kami.')

@section('content')

<div x-data="{ filter: 'all' }">

{{-- Page Header --}}
<div class="pt-16 lg:pt-18 bg-surface">
    <div class="max-w-container mx-auto px-responsive pt-12 pb-10 border-b border-outline-variant/40">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <span class="text-label-sm text-secondary font-outfit font-semibold uppercase tracking-widest">{{ $pageContent['page_label'] ?? 'Karya Kami' }}</span>
                <h1 class="text-3xl md:text-headline-lg font-outfit font-bold text-primary mt-2">{{ $pageContent['page_heading'] ?? 'Portfolio' }}</h1>
            </div>
        </div>

        @php
        $categories = $projects->pluck('kategoriProject.title')->filter()->unique()->values();
        @endphp

        {{-- Filter Buttons (dynamic) --}}
        <div class="flex flex-wrap gap-3 mt-6">
            <button @click="filter = 'all'" :class="filter === 'all' ? 'bg-secondary text-white shadow-md' : 'bg-white text-on-surface border border-outline-variant/40'" class="px-5 py-2 rounded-full text-label-md font-outfit font-semibold transition-all duration-300 hover:shadow-md hover:scale-105 hover:bg-secondary hover:text-white hover:border-secondary active:scale-95">Semua</button>
            @foreach($categories as $cat)
            <button @click="filter = '{{ $cat }}'" :class="filter === '{{ $cat }}' ? 'bg-secondary text-white shadow-md' : 'bg-white text-on-surface border border-outline-variant/40'" class="px-5 py-2 rounded-full text-label-md font-outfit font-semibold transition-all duration-300 hover:shadow-md hover:scale-105 hover:bg-secondary hover:text-white hover:border-secondary active:scale-95">{{ $cat }}</button>
            @endforeach
        </div>
    </div>
</div>

{{-- Project Grid --}}
<section class="py-block-gap bg-surface-container-low">
    <div class="max-w-container mx-auto px-responsive">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" data-stagger>
            @forelse($projects as $proj)
            <div class="reveal bg-white rounded-2xl overflow-hidden border border-outline-variant/60 soft-shadow-md card-hover group flex flex-col h-full"
                 x-show="filter === 'all' || filter === '{{ $proj->kategoriProject->title ?? '' }}'"
                 x-transition>
                <a href="{{ route('portfolio.show', $proj->slug) }}" class="relative overflow-hidden h-56 block">
                    @if($proj->img && !str_starts_with($proj->img, 'http'))
                        <img alt="{{ $proj->title }}" src="{{ asset('storage/' . $proj->img) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @elseif($proj->img)
                        <img alt="{{ $proj->title }}" src="{{ $proj->img }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-primary/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </a>
                <div class="p-6 flex flex-col flex-grow">
                    <span class="inline-flex items-center gap-2 bg-secondary/10 text-secondary px-3 py-1.5 rounded-full text-label-sm font-semibold mb-3 w-fit">
                        {{ $proj->kategoriProject->title ?? '' }}
                    </span>
                    <h3 class="text-headline-sm font-outfit font-semibold text-primary mb-2 flex-grow">
                        <a href="{{ route('portfolio.show', $proj->slug) }}" class="hover:text-secondary transition-colors">
                            {{ $proj->title }}
                        </a>
                    </h3>
                    <p class="text-body-sm text-on-surface-variant leading-relaxed line-clamp-3 mb-4">{{ $proj->content ?? '' }}</p>
                    <div class="pt-4 border-t border-outline-variant/20 mt-auto">
                        <a href="{{ route('portfolio.show', $proj->slug) }}" class="inline-flex items-center gap-1.5 text-secondary text-label-md font-semibold group-hover:gap-2.5 transition-all duration-200">
                            Lihat Detail <span class="material-symbols-outlined text-base">arrow_forward</span>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full">
                <p class="text-center text-on-surface-variant py-12">Belum ada data proyek.</p>
            </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($projects->hasPages())
        <div class="mt-12 flex justify-center">
            {{ $projects->links() }}
        </div>
        @endif
    </div>
</section>

{{-- CTA --}}
<section class="py-20 bg-surface">
    <div class="max-w-container mx-auto px-responsive">
        <div class="bg-primary rounded-3xl p-10 md:p-12 soft-shadow-md reveal">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <div>
                    <h2 class="text-headline-sm font-outfit font-bold text-white">{{ $pageContent['cta_heading'] ?? 'Ingin hasil seperti ini?' }}</h2>
                    <p class="text-body-md text-white/70 mt-1">{{ $pageContent['cta_description'] ?? '' }}</p>
                </div>
                <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer" class="bg-white text-primary hover:bg-white/90 inline-flex items-center gap-2 px-8 py-4 rounded-full text-label-md font-outfit font-semibold flex-shrink-0 transition-all duration-300 hover:scale-105 active:scale-95 shadow-md">
                    Konsultasi Sekarang
                    <span class="material-symbols-outlined text-xl">arrow_forward</span>
                </a>
            </div>
        </div>
    </div>
</section>

</div>

@endsection
