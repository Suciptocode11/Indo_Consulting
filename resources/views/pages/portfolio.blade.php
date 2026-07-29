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
        <div class="space-y-6" data-stagger>
            @forelse($projects as $i => $proj)
            @if($i === 0)
            {{-- Featured Project (first, full width) --}}
            <div class="reveal bg-white rounded-2xl overflow-hidden border border-outline-variant/60 soft-shadow-md card-hover group" x-show="filter === 'all' || filter === '{{ $proj->kategoriProject->title ?? '' }}'" x-transition>
                <div class="grid lg:grid-cols-2">
                    <div class="relative h-64 lg:h-auto overflow-hidden">
                        @if($proj->img && !str_starts_with($proj->img, 'http'))
                            <img alt="{{ $proj->title }}" src="{{ asset('storage/' . $proj->img) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @elseif($proj->img)
                            <img alt="{{ $proj->title }}" src="{{ $proj->img }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-r from-primary/30 to-transparent"></div>
                    </div>
                    <div class="p-8 flex flex-col justify-center">
                        <span class="text-label-sm text-secondary font-outfit font-semibold uppercase tracking-wider mb-3">{{ $proj->kategoriProject->title ?? '' }}</span>
                        <h3 class="text-headline-md font-outfit font-semibold text-primary mb-4">{{ $proj->title }}</h3>
                        <p class="text-body-lg text-on-surface-variant leading-relaxed mb-6">{{ $proj->content ?? '' }}</p>
                    </div>
                </div>
            </div>
            @else
            {{-- Supporting Projects --}}
            @if($i === 1) <div class="grid grid-cols-1 md:grid-cols-2 gap-6"> @endif
                <div class="reveal bg-white rounded-2xl overflow-hidden border border-outline-variant/60 soft-shadow-md card-hover group flex flex-col" x-show="filter === 'all' || filter === '{{ $proj->kategoriProject->title ?? '' }}'" x-transition>
                    <div class="relative h-48 overflow-hidden">
                        @if($proj->img && !str_starts_with($proj->img, 'http'))
                            <img alt="{{ $proj->title }}" src="{{ asset('storage/' . $proj->img) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @elseif($proj->img)
                            <img alt="{{ $proj->title }}" src="{{ $proj->img }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @endif
                    </div>
                    <div class="p-6 flex flex-col flex-1">
                        <span class="text-label-sm text-secondary font-outfit font-semibold uppercase tracking-wider mb-2">{{ $proj->kategoriProject->title ?? '' }}</span>
                        <h3 class="text-body-lg font-outfit font-semibold text-primary mb-2">{{ $proj->title }}</h3>
                        <p class="text-body-md text-on-surface-variant leading-relaxed flex-1">{{ $proj->content ?? '' }}</p>
                    </div>
                </div>
            @if($loop->last) </div> @endif
            @endif
            @empty
            <p class="text-center text-on-surface-variant py-12">Belum ada data proyek.</p>
            @endforelse
        </div>
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
                <a href="{{ route('kontak-kami') }}" class="bg-white text-primary hover:bg-white/90 inline-flex items-center gap-2 px-8 py-4 rounded-full text-label-md font-outfit font-semibold flex-shrink-0 transition-all duration-300 hover:scale-105 active:scale-95 shadow-md">
                    Konsultasi Sekarang
                    <span class="material-symbols-outlined text-xl">arrow_forward</span>
                </a>
            </div>
        </div>
    </div>
</section>

</div>

@endsection
