@extends('layouts.app')

@section('title', $project->title . ' - Portfolio Indo Consulting')
@section('description', Str::limit(strip_tags($project->content ?? $project->title), 160))

@section('content')

{{-- Header --}}
<section class="bg-surface-container pt-16 lg:pt-18 pb-10 border-b border-outline-variant/40">
    <div class="max-w-container mx-auto px-responsive pt-8">
        <a href="{{ route('portfolio') }}" class="inline-flex items-center gap-1.5 text-secondary text-label-md font-outfit font-semibold hover:gap-2.5 transition-all duration-200 mb-6">
            <span class="material-symbols-outlined text-base">arrow_back</span> Kembali ke Portfolio
        </a>

        <div class="space-y-3">
            @if($project->kategoriProject)
            <span class="inline-flex items-center gap-2 bg-secondary/10 text-secondary px-3.5 py-1.5 rounded-full text-label-sm font-outfit font-semibold w-fit">
                <span class="material-symbols-outlined text-base">folder</span>
                {{ $project->kategoriProject->title }}
            </span>
            @endif

            <h1 class="text-3xl md:text-headline-lg font-outfit font-bold text-primary max-w-4xl leading-tight">
                {{ $project->title }}
            </h1>

            {{-- Metadata Badges --}}
            <div class="flex flex-wrap items-center gap-4 text-on-surface-variant/80 text-label-md pt-2">
                @if($project->date)
                <div class="flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-secondary text-lg">calendar_today</span>
                    <span>{{ $project->date }}</span>
                </div>
                @endif

                @if($project->lokasi)
                <div class="flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-secondary text-lg">location_on</span>
                    <span>{{ $project->lokasi }}</span>
                </div>
                @endif

                @if($project->service)
                <div class="flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-secondary text-lg">layers</span>
                    <span>{{ $project->service->title }}</span>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- Detail Content --}}
<section class="py-16 bg-surface">
    <div class="max-w-container mx-auto px-responsive">
        <div class="grid lg:grid-cols-12 gap-12">

            {{-- Main Content Column --}}
            <div class="lg:col-span-8 space-y-8">
                {{-- Main Image --}}
                @if($project->img)
                <div class="rounded-2xl overflow-hidden shadow-lg border border-outline-variant/30">
                    <img 
                        src="{{ str_starts_with($project->img, 'http') ? $project->img : asset('storage/' . $project->img) }}" 
                        alt="{{ $project->title }}" 
                        class="w-full h-auto max-h-[500px] object-cover"
                    >
                </div>
                @endif

                {{-- Project Description / Article --}}
                <div class="bg-white rounded-2xl p-8 md:p-10 border border-outline-variant/40 soft-shadow-sm space-y-4">
                    <h2 class="text-headline-sm font-outfit font-bold text-primary mb-4 pb-3 border-b border-outline-variant/30">Deskripsi Proyek</h2>
                    @if($project->content)
                        <div class="prose prose-lg max-w-none text-body-lg text-on-surface-variant leading-relaxed space-y-4">
                            {!! nl2br(e($project->content)) !!}
                        </div>
                    @else
                        <p class="text-on-surface-variant/70 italic">Tidak ada deskripsi rinci untuk proyek ini.</p>
                    @endif
                </div>

                {{-- Additional Project Photos Gallery (if any) --}}
                @if($project->photos && $project->photos->count() > 0)
                <div class="bg-white rounded-2xl p-8 md:p-10 border border-outline-variant/40 soft-shadow-sm space-y-6">
                    <h3 class="text-headline-sm font-outfit font-bold text-primary">Dokumentasi Proyek</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($project->photos as $photo)
                        <div class="rounded-xl overflow-hidden border border-outline-variant/30 group relative">
                            <img 
                                src="{{ str_starts_with($photo->img, 'http') ? $photo->img : asset('storage/' . $photo->img) }}" 
                                alt="Dokumentasi Proyek" 
                                class="w-full h-44 object-cover group-hover:scale-105 transition-transform duration-300"
                            >
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            {{-- Sidebar Column --}}
            <div class="lg:col-span-4">
                <div class="space-y-6 sticky top-24">
                    {{-- Info Card --}}
                    <div class="bg-surface-container-low rounded-2xl p-6 md:p-8 border border-outline-variant/40 soft-shadow-sm space-y-6">
                        <h3 class="text-headline-sm font-outfit font-bold text-primary pb-3 border-b border-outline-variant/30">Detail Informasi</h3>

                        @if($project->kategoriProject)
                        <div>
                            <p class="text-label-sm text-on-surface-variant/70 mb-1 font-medium">Kategori Proyek</p>
                            <p class="text-body-md font-outfit font-semibold text-primary">{{ $project->kategoriProject->title }}</p>
                        </div>
                        @endif

                        @if($project->service)
                        <div>
                            <p class="text-label-sm text-on-surface-variant/70 mb-1 font-medium">Layanan Terkait</p>
                            <a href="{{ route('program.show', $project->service->slug ?? '') }}" class="text-body-md font-outfit font-semibold text-secondary hover:underline">
                                {{ $project->service->title }}
                            </a>
                        </div>
                        @endif

                        @if($project->lokasi)
                        <div>
                            <p class="text-label-sm text-on-surface-variant/70 mb-1 font-medium">Lokasi</p>
                            <p class="text-body-md font-outfit font-semibold text-primary">{{ $project->lokasi }}</p>
                        </div>
                        @endif

                        @if($project->date)
                        <div>
                            <p class="text-label-sm text-on-surface-variant/70 mb-1 font-medium">Tahun / Tanggal</p>
                            <p class="text-body-md font-outfit font-semibold text-primary">{{ $project->date }}</p>
                        </div>
                        @endif

                        @if($project->url)
                        <div class="pt-2">
                            <a href="{{ $project->url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center gap-2 w-full bg-surface text-primary border border-outline-variant/60 hover:bg-white hover:border-secondary hover:text-secondary px-5 py-3 rounded-xl text-label-md font-outfit font-semibold transition-all shadow-sm">
                                <span>Kunjungi Link Proyek</span>
                                <span class="material-symbols-outlined text-lg">open_in_new</span>
                            </a>
                        </div>
                        @endif
                    </div>

                    {{-- CTA Card Sidebar --}}
                    <div class="bg-primary rounded-2xl p-6 md:p-8 text-white soft-shadow-md space-y-4">
                        <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center">
                            <span class="material-symbols-outlined text-white text-2xl">handshake</span>
                        </div>
                        <h4 class="text-headline-sm font-outfit font-bold">Tertarik Dengan Hasil Seperti Ini?</h4>
                        <p class="text-body-sm text-white/80 leading-relaxed">Konsultasikan proyek dan kebutuhan bisnis Anda bersama para ahli kami.</p>
                        <a href="{{ route('kontak-kami') }}" class="inline-flex items-center justify-center gap-2 w-full bg-white text-primary hover:bg-white/90 px-6 py-3.5 rounded-xl text-label-md font-outfit font-semibold transition-all duration-300 hover:scale-105 active:scale-95 shadow-md">
                            Konsultasi Sekarang
                            <span class="material-symbols-outlined text-lg">arrow_forward</span>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- Other Projects --}}
@if($otherProjects->isNotEmpty())
<section class="py-16 bg-surface-container-low border-t border-outline-variant/40">
    <div class="max-w-container mx-auto px-responsive">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 gap-4">
            <div>
                <h2 class="text-headline-sm font-outfit font-bold text-primary">Proyek Lainnya</h2>
                <p class="text-body-md text-on-surface-variant mt-1">Jelajahi hasil karya nyata dan solusi bisnis kami lainnya.</p>
            </div>
            <a href="{{ route('portfolio') }}" class="text-secondary text-label-md font-semibold hover:underline underline-offset-4 flex items-center gap-1 whitespace-nowrap">
                Lihat Semua Portfolio <span class="material-symbols-outlined text-base">arrow_forward</span>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" data-stagger>
            @foreach($otherProjects as $other)
            <div class="reveal bg-white rounded-2xl overflow-hidden border border-outline-variant/60 soft-shadow-md card-hover group flex flex-col h-full">
                <div class="relative overflow-hidden h-56">
                    @if($other->img && !str_starts_with($other->img, 'http'))
                        <img alt="{{ $other->title }}" src="{{ asset('storage/' . $other->img) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @elseif($other->img)
                        <img alt="{{ $other->title }}" src="{{ $other->img }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-primary/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </div>
                <div class="p-6 flex flex-col flex-grow">
                    @if($other->kategoriProject)
                    <span class="inline-flex items-center gap-2 bg-secondary/10 text-secondary px-3 py-1.5 rounded-full text-label-sm font-semibold mb-3 w-fit">
                        {{ $other->kategoriProject->title }}
                    </span>
                    @endif
                    <h3 class="text-headline-sm font-outfit font-semibold text-primary mb-2 flex-grow">{{ $other->title }}</h3>
                    <p class="text-body-sm text-on-surface-variant leading-relaxed line-clamp-3 mb-4">{{ $other->content ?? '' }}</p>
                    <div class="pt-4 border-t border-outline-variant/20 mt-auto">
                        <a href="{{ route('portfolio.show', $other->slug) }}" class="inline-flex items-center gap-1.5 text-secondary text-label-md font-semibold group-hover:gap-2.5 transition-all duration-200">
                            Lihat Detail <span class="material-symbols-outlined text-base">arrow_forward</span>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Bottom CTA Section --}}
<section class="py-20 bg-surface">
    <div class="max-w-container mx-auto px-responsive">
        <div class="bg-primary rounded-3xl p-10 md:p-12 soft-shadow-md reveal">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <div>
                    <h2 class="text-headline-sm font-outfit font-bold text-white">{{ $pageContent['cta_heading'] ?? 'Ingin hasil seperti ini?' }}</h2>
                    <p class="text-body-md text-white/70 mt-1">{{ $pageContent['cta_description'] ?? 'Konsultasikan kebutuhan bisnis Anda bersama tim ahli Indo Consulting.' }}</p>
                </div>
                <a href="{{ route('kontak-kami') }}" class="bg-white text-primary hover:bg-white/90 inline-flex items-center gap-2 px-8 py-4 rounded-full text-label-md font-outfit font-semibold flex-shrink-0 transition-all duration-300 hover:scale-105 active:scale-95 shadow-md">
                    Konsultasi Sekarang
                    <span class="material-symbols-outlined text-xl">arrow_forward</span>
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
