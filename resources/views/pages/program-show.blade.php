@extends('layouts.app')

@section('title', $program->title . ' - Indo Consulting')
@section('description', $program->short ?? $program->title)

@section('content')

{{-- Hero --}}
<section class="bg-surface-container pt-16 lg:pt-18">
    <div class="max-w-container mx-auto px-responsive py-16">
        <a href="{{ route('program') }}" class="inline-flex items-center gap-1.5 text-secondary text-label-md font-outfit font-semibold hover:gap-2.5 transition-all duration-200 mb-8">
            <span class="material-symbols-outlined text-base">arrow_back</span> Kembali ke Program
        </a>

        <div class="flex items-center gap-4 mb-4">
            <div class="w-14 h-14 rounded-xl bg-secondary/10 flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-secondary text-3xl">{{ $program->icon ?? 'school' }}</span>
            </div>
            <h1 class="text-3xl md:text-headline-lg font-outfit font-bold text-primary">{{ $program->title }}</h1>
        </div>
    </div>
</section>

{{-- Detail Content --}}
<section class="py-16 bg-surface">
    <div class="max-w-container mx-auto px-responsive">
        <div class="grid lg:grid-cols-5 gap-12">

            {{-- Main Content --}}
            <div class="lg:col-span-3">
                @if($program->img && !str_starts_with($program->img, 'http'))
                    <img src="{{ asset('storage/' . $program->img) }}" alt="{{ $program->title }}" class="w-full h-72 md:h-96 object-cover rounded-2xl mb-8">
                @elseif($program->img)
                    <img src="{{ $program->img }}" alt="{{ $program->title }}" class="w-full h-72 md:h-96 object-cover rounded-2xl mb-8">
                @endif

                <div class="prose prose-lg max-w-none">
                    {!! $program->content !!}
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="lg:col-span-2">
                <div class="bg-surface-container-low rounded-2xl p-8 border border-outline-variant/40 sticky top-24">
                    <h3 class="text-headline-sm font-outfit font-bold text-primary mb-4">Tentang Program Ini</h3>

                    @if($program->short)
                    <div class="mb-4">
                        <p class="text-label-sm text-on-surface-variant/70 mb-1">Ringkasan</p>
                        <p class="text-body-md text-on-surface-variant">{{ $program->short }}</p>
                    </div>
                    @endif

                    <div class="mb-6">
                        <p class="text-label-sm text-on-surface-variant/70 mb-1">Kategori</p>
                        <p class="text-body-md text-on-surface-variant">{{ $program->slug }}</p>
                    </div>

                    <a href="{{ $pengaturan ? $pengaturan->whatsappUrl('Halo ' . ($pengaturan->company ?? 'Indo Consulting') . ', saya ingin konsultasi mengenai program ' . $program->title . '.') : $waUrl }}" target="_blank" rel="noopener noreferrer" class="btn-primary w-full justify-center text-center px-6 py-3.5 rounded-xl text-label-md font-outfit font-semibold">
                        Konsultasi Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Other Programs --}}
@if($otherPrograms->isNotEmpty())
<section class="py-16 bg-surface-container-low">
    <div class="max-w-container mx-auto px-responsive">
        <h2 class="text-headline-sm font-outfit font-bold text-primary mb-8">Program Lainnya</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($otherPrograms as $other)
            <a href="{{ route('program.show', $other->slug) }}" class="bg-white rounded-2xl p-6 border border-outline-variant/40 soft-shadow-md card-hover group transition-all">
                <div class="w-12 h-12 rounded-xl bg-secondary/10 flex items-center justify-center mb-4 group-hover:bg-secondary/20 transition-colors">
                    <span class="material-symbols-outlined text-secondary text-xl">{{ $other->icon ?? 'school' }}</span>
                </div>
                <h3 class="text-body-lg font-outfit font-bold text-primary mb-2">{{ $other->title }}</h3>
                <p class="text-body-md text-on-surface-variant leading-relaxed">{{ $other->short ?? '' }}</p>
                <span class="inline-flex items-center gap-1 text-secondary text-label-sm font-semibold mt-4 group-hover:gap-2 transition-all duration-200">
                    Lihat Detail <span class="material-symbols-outlined text-base">arrow_forward</span>
                </span>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- CTA --}}
<section class="py-20 bg-surface">
    <div class="max-w-container mx-auto px-responsive">
        <div class="bg-primary rounded-3xl p-10 md:p-12 soft-shadow-md reveal">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <div>
                    <h2 class="text-headline-sm font-outfit font-bold text-white">Butuh konsultasi program?</h2>
                    <p class="text-body-md text-white/65 mt-1">Tim ahli kami siap membantu menentukan solusi yang tepat.</p>
                </div>
                <a href="{{ $pengaturan ? $pengaturan->whatsappUrl('Halo ' . ($pengaturan->company ?? 'Indo Consulting') . ', saya ingin konsultasi mengenai program ' . $program->title . '.') : $waUrl }}" target="_blank" rel="noopener noreferrer" class="bg-white text-primary hover:bg-white/90 inline-flex items-center gap-2 px-8 py-4 rounded-full text-label-md font-outfit font-semibold flex-shrink-0 transition-all duration-300 hover:scale-105 active:scale-95 shadow-md">
                    Hubungi Kami
                    <span class="material-symbols-outlined text-xl">arrow_forward</span>
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
