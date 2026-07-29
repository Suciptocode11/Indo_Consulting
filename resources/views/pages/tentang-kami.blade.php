@extends('layouts.app')

@section('title', 'Tentang Kami - Indo Consulting')
@section('description', 'Mengenal lebih dekat visi, misi, dan perjalanan Indo Consulting dalam mentransformasi bisnis Indonesia.')

@section('content')

{{-- Page Header --}}
<div class="pt-16 lg:pt-18 pb-0 bg-surface">
    <div class="max-w-container mx-auto px-responsive pt-12 pb-10 border-b border-outline-variant/40">
        <span class="text-label-sm text-secondary font-outfit font-semibold italic tracking-normal">Tentang Kami</span>
        <h1 class="text-3xl md:text-headline-lg font-outfit font-bold text-primary mt-2">Mitra Strategis untuk Bisnis yang Berkelanjutan</h1>
    </div>
</div>

{{-- Company Story --}}
<section class="py-12 bg-surface">
    <div class="max-w-container mx-auto px-responsive">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div class="space-y-6 reveal">
                <p class="text-body-lg text-on-surface-variant leading-relaxed">
                    {{ $pageContent['about_text_1'] ?? 'Indo Consulting adalah perusahaan konsultan terkemuka yang berfokus pada pemberian solusi bisnis inovatif untuk mendukung pertumbuhan dan keberlanjutan perusahaan di berbagai industri.' }}
                </p>
                <p class="text-body-md text-on-surface-variant leading-relaxed">
                    {{ $pageContent['about_text_2'] ?? 'Didukung oleh tim profesional berpengalaman, Indo Consulting berkomitmen memberikan layanan berkualitas tinggi dalam bidang Strategi Bisnis, Keuangan & Investasi, Hukum, serta Riset, Pendidikan, dan Pelatihan.' }}
                </p>
                <div class="flex gap-10 pt-4 border-t border-outline-variant/30">
                    @foreach([[$pageContent['stats_1_number'] ?? '17', $pageContent['stats_1_label'] ?? 'Tahun Pengalaman'], [$pageContent['stats_2_number'] ?? '127', $pageContent['stats_2_label'] ?? 'Klien Puas'], [$pageContent['stats_3_number'] ?? '538', $pageContent['stats_3_label'] ?? 'Proyek Selesai']] as $s)
                    <div>
                        <p class="text-2xl font-outfit font-bold text-primary">{{ $s[0] }}</p>
                        <p class="text-label-sm text-on-surface-variant tracking-wide mt-1">{{ $s[1] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="reveal">
                @php
                    $aboutImageDefault = 'https://lh3.googleusercontent.com/aida-public/AB6AXuDcWNYerVWBJoiV54oU70du3c4R4QDo9dm3eKvXSBge11qvyH-g1z1SHxiZNspBjS_Q1QoSBYG05Sqg1zSvr1QPDIrVtk9sOjjf8eekbHgucKP3Yi9EHQGveE8jwaAVdSM0agwbTGGfyGCppkdQ4lguEoO3ZXz0rVYSKAbir6cUe0eapraMq7EwrT_BCu3HiP928UfYCHeelH075l0zQgWU5r592ZlqbTpASzHn4a3c32FGuJ7nKc81zeBL5kHD7US2ETGYjMjNDQ';
                    $aboutImageSrc = (!empty($pageContent['about_image']))
                        ? (str_starts_with($pageContent['about_image'], 'http')
                            ? $pageContent['about_image']
                            : asset('storage/' . $pageContent['about_image']))
                        : $aboutImageDefault;
                @endphp
                <img
                    src="{{ $aboutImageSrc }}"
                    alt="Tim Indo Consulting"
                    class="w-full h-[400px] object-cover rounded-2xl shadow-sm border border-outline-variant/30"
                >
            </div>
        </div>
    </div>
</section>

{{-- Visi Misi --}}
<section class="py-32 bg-surface-container">
    <div class="max-w-container mx-auto px-responsive">
        <div class="grid lg:grid-cols-12 gap-10">
            {{-- Visi --}}
            <div class="lg:col-span-4 reveal">
                <div class="bg-primary rounded-2xl p-10 h-full flex flex-col">
                    <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center mb-6">
                        <span class="material-symbols-outlined text-white text-2xl">visibility</span>
                    </div>
                    <h2 class="text-headline-sm font-outfit font-bold text-white mb-4">Visi</h2>
                    <p class="text-body-md text-white/75 leading-relaxed">
                        {{ $visiMisi->where('type', 'visi')->first()->description ?? 'Menjadi mitra terpercaya...' }}
                    </p>
                </div>
            </div>

            {{-- Misi --}}
            <div class="lg:col-span-8">
                <h2 class="text-headline-sm font-outfit font-bold text-primary mb-6 reveal">Misi</h2>
                <div class="grid sm:grid-cols-2 gap-4" data-stagger>
                    @foreach($visiMisi->where('type', 'misi') as $m)
                    <div class="reveal bg-white rounded-xl p-6 soft-shadow">
                        <div class="flex items-center gap-3 mb-3">
                            <span class="material-symbols-outlined text-secondary text-xl">{{ $m->icon ?? 'check' }}</span>
                            <h3 class="font-outfit font-semibold text-primary text-body-md">{{ $m->title ?? '' }}</h3>
                        </div>
                        <p class="text-body-md text-on-surface-variant leading-relaxed">{{ $m->description ?? '' }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Keunggulan --}}
<section class="py-block-gap bg-surface-container-low">
    <div class="max-w-container mx-auto px-responsive">
        <h2 class="text-headline-md font-outfit font-bold text-primary mb-10 reveal">Keunggulan Indo Consulting</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6" data-stagger>
            @foreach($keunggulan as $a)
            <div class="reveal bg-white p-6 rounded-2xl border border-outline-variant/40 soft-shadow flex items-start gap-4">
                <div class="w-12 h-12 bg-secondary/10 rounded-xl flex items-center justify-center flex-shrink-0">
                    <span class="material-symbols-outlined text-2xl text-secondary">{{ $a->icon ?? 'check' }}</span>
                </div>
                <div>
                    <h3 class="text-headline-sm font-outfit font-semibold text-primary mb-2">{{ $a->title }}</h3>
                    <p class="text-body-md text-on-surface-variant leading-relaxed">{{ $a->description }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-20 bg-surface">
    <div class="max-w-container mx-auto px-responsive">
        <div class="bg-primary rounded-3xl p-10 md:p-12 soft-shadow-md reveal">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <div>
                    <h2 class="text-headline-sm font-outfit font-bold text-white">Siap bertumbuh bersama kami?</h2>
                    <p class="text-body-md text-white/70 mt-2">Konsultasikan kebutuhan bisnis Anda dengan tim ahli kami.</p>
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
