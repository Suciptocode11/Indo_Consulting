@extends('layouts.app')

@section('title', 'Program - Indo Consulting')
@section('description', 'Program konsultasi lengkap Indo Consulting untuk berbagai kebutuhan bisnis Anda.')

@section('content')

{{-- Page Header --}}
<div class="pt-16 lg:pt-18 bg-surface">
    <div class="max-w-container mx-auto px-responsive pt-12 pb-10 border-b border-outline-variant/40">
        <span class="text-label-sm text-secondary font-outfit font-semibold uppercase tracking-widest">{{ $pageContent['page_label'] ?? 'Layanan Kami' }}</span>
        <h1 class="text-3xl md:text-headline-lg font-outfit font-bold text-primary mt-2">{{ $pageContent['page_heading'] ?? 'Program Konsultasi' }}</h1>
        <p class="text-body-md text-on-surface-variant mt-2 max-w-xl">{{ $pageContent['page_description'] ?? '' }}</p>
    </div>
</div>

@php
$programs = $services->toArray();
@endphp

{{-- DIVERSE LAYOUTS (NOT all zigzag - skill Section 4.7) --}}

{{-- PROGRAM 1 & 2: ZIGZAG (max 2 consecutive) --}}
@foreach(array_slice($programs, 0, 2) as $i => $prog)
<section class="py-16 {{ $i % 2 === 0 ? 'bg-surface' : 'bg-surface-container' }} border-b border-outline-variant/40">
    <div class="max-w-container mx-auto px-responsive">
        <div class="grid lg:grid-cols-12 gap-12 items-center">
            <div class="lg:col-span-1 hidden lg:flex flex-col items-center gap-3 reveal">
                <span class="text-display-lg font-outfit font-bold text-primary/10 leading-none">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="lg:col-span-5 space-y-5 reveal {{ $i % 2 !== 0 ? 'lg:order-2' : '' }}">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-secondary/10 flex items-center justify-center flex-shrink-0">
                        <span class="material-symbols-outlined text-secondary text-xl">{{ $prog['icon'] ?? 'school' }}</span>
                    </div>
                    <h2 class="text-headline-sm font-outfit font-bold text-primary">{{ $prog['title'] }}</h2>
                </div>
                <p class="text-body-md text-on-surface-variant leading-relaxed">{{ $prog['short'] ?? $prog['content'] ?? '' }}</p>
                <a href="{{ route('program.show', $prog['slug']) }}" class="inline-flex items-center gap-1.5 text-secondary text-label-md font-outfit font-semibold hover:gap-2.5 transition-all duration-200 mt-2">
                    Lihat Lebih Detail <span class="material-symbols-outlined text-base">arrow_forward</span>
                </a>
            </div>
            <div class="lg:col-span-6 reveal {{ $i % 2 !== 0 ? 'lg:order-1' : '' }}">
                @if(!empty($prog['img']) && !str_starts_with($prog['img'], 'http'))
                    <img src="{{ asset('storage/' . $prog['img']) }}" alt="{{ $prog['title'] }}" class="w-full h-64 md:h-80 object-cover rounded-2xl border border-outline-variant/30">
                @elseif(!empty($prog['img']))
                    <img src="{{ $prog['img'] }}" alt="{{ $prog['title'] }}" class="w-full h-64 md:h-80 object-cover rounded-2xl border border-outline-variant/30">
                @endif
            </div>
        </div>
    </div>
</section>
@endforeach

{{-- PROGRAM 3+: Alternating layout for remaining programs --}}
@foreach(array_slice($programs, 2) as $i => $prog)
@php $bg = ($i % 2 === 0) ? 'bg-surface' : 'bg-surface-container'; $num = $i + 3; @endphp
<section class="py-16 {{ $bg }} border-b border-outline-variant/40">
    <div class="max-w-container mx-auto px-responsive">
        <div class="grid lg:grid-cols-12 gap-12 items-center">
            <div class="lg:col-span-1 hidden lg:flex flex-col items-center gap-3 reveal">
                <span class="text-display-lg font-outfit font-bold text-primary/10 leading-none">{{ str_pad($num, 2, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="lg:col-span-5 space-y-5 reveal {{ $i % 2 !== 0 ? 'lg:order-2' : '' }}">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-secondary/10 flex items-center justify-center flex-shrink-0">
                        <span class="material-symbols-outlined text-secondary text-xl">{{ $prog['icon'] ?? 'school' }}</span>
                    </div>
                    <h2 class="text-headline-sm font-outfit font-bold text-primary">{{ $prog['title'] }}</h2>
                </div>
                <p class="text-body-md text-on-surface-variant leading-relaxed">{{ $prog['short'] ?? $prog['content'] ?? '' }}</p>
                <a href="{{ route('program.show', $prog['slug']) }}" class="inline-flex items-center gap-1.5 text-secondary text-label-md font-outfit font-semibold hover:gap-2.5 transition-all duration-200 mt-2">
                    Lihat Lebih Detail <span class="material-symbols-outlined text-base">arrow_forward</span>
                </a>
            </div>
            <div class="lg:col-span-6 reveal {{ $i % 2 !== 0 ? 'lg:order-1' : '' }}">
                @if(!empty($prog['img']) && !str_starts_with($prog['img'], 'http'))
                    <img src="{{ asset('storage/' . $prog['img']) }}" alt="{{ $prog['title'] }}" class="w-full h-64 md:h-80 object-cover rounded-2xl border border-outline-variant/30">
                @elseif(!empty($prog['img']))
                    <img src="{{ $prog['img'] }}" alt="{{ $prog['title'] }}" class="w-full h-64 md:h-80 object-cover rounded-2xl border border-outline-variant/30">
                @endif
            </div>
        </div>
    </div>
</section>
@endforeach

{{-- CTA Card --}}
<section class="py-20 bg-surface">
    <div class="max-w-container mx-auto px-responsive">
        <div class="bg-primary rounded-3xl p-10 md:p-12 soft-shadow-md reveal">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <div>
                    <h2 class="text-headline-sm font-outfit font-bold text-white">Butuh konsultasi program?</h2>
                    <p class="text-body-md text-white/65 mt-1">Tim ahli kami siap membantu menentukan solusi yang tepat.</p>
                </div>
                <a href="{{ route('kontak-kami') }}" class="bg-white text-primary hover:bg-white/90 inline-flex items-center gap-2 px-8 py-4 rounded-full text-label-md font-outfit font-semibold flex-shrink-0 transition-all duration-300 hover:scale-105 active:scale-95 shadow-md">
                    Hubungi Kami
                    <span class="material-symbols-outlined text-xl">arrow_forward</span>
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
