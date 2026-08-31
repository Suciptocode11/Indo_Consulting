@extends('layouts.app')

@section('title', 'Partners & Clients - Indo Consulting')
@section('description', 'Mitra dan klien terpercaya Indo Consulting dari berbagai sektor industri.')

@section('content')

<div x-data="{ filter: 'all' }">

{{-- Page Header --}}
<div class="pt-16 lg:pt-18 bg-surface">
    <div class="max-w-container mx-auto px-responsive pt-12 pb-10 border-b border-outline-variant/40">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <span class="text-label-sm text-secondary font-outfit font-semibold italic tracking-normal">{{ $pageContent['page_label'] ?? 'Kepercayaan Klien' }}</span>
                <h1 class="text-3xl md:text-headline-lg font-outfit font-bold text-primary mt-2">{!! $pageContent['page_heading'] ?? 'Partners &amp; Clients' !!}</h1>
            </div>
        </div>

        @php
        $sectors = $clients->pluck('sector')->filter()->unique()->values();
        @endphp

        {{-- Filter Buttons (dynamic from DB) --}}
        <div class="flex flex-wrap gap-3 mt-6">
            <button @click="filter = 'all'" :class="filter === 'all' ? 'bg-secondary text-white shadow-md' : 'bg-white text-on-surface border border-outline-variant/40'" class="px-5 py-2 rounded-full text-label-md font-outfit font-semibold transition-all duration-300 hover:shadow-md hover:scale-105 hover:bg-secondary hover:text-white hover:border-secondary active:scale-95">Semua</button>
            @foreach($sectors as $sector)
            <button @click="filter = '{{ $sector }}'" :class="filter === '{{ $sector }}' ? 'bg-secondary text-white shadow-md' : 'bg-white text-on-surface border border-outline-variant/40'" class="px-5 py-2 rounded-full text-label-md font-outfit font-semibold transition-all duration-300 hover:shadow-md hover:scale-105 hover:bg-secondary hover:text-white hover:border-secondary active:scale-95">{{ $sector }}</button>
            @endforeach
        </div>
    </div>
</div>

{{-- Partner Grid --}}
<section class="py-block-gap bg-surface-container">
    <div class="max-w-container mx-auto px-responsive">
        <h2 class="text-headline-sm font-outfit font-bold text-primary mb-8 reveal">Mitra Strategis Kami</h2>
        <div class="space-y-8" data-stagger>
            @if($clients->isEmpty())
                <p class="text-center text-on-surface-variant py-12">Belum ada data mitra/klien.</p>
            @else
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($clients as $client)
                    @php
                        $hasUrl = !empty($client->url);
                        $url = $hasUrl ? $client->url : '#';
                        // Ensure URL has protocol
                        if ($hasUrl && !preg_match('/^https?:\/\//i', $url)) {
                            $url = 'https://' . $url;
                        }
                    @endphp
                    
                    @if($hasUrl)
                    <a href="{{ $url }}" target="_blank" rel="noopener noreferrer" class="reveal bg-white rounded-2xl border border-outline-variant/40 p-6 flex flex-col items-center text-center card-hover group soft-shadow h-full transition-all duration-300 hover:border-secondary/40 hover:shadow-xl cursor-pointer"
                       x-show="filter === 'all' || filter === '{{ $client->sector ?? '' }}'"
                       x-transition>
                        @if($client->img)
                            <div class="w-20 h-20 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                                <img src="{{ asset('storage/' . $client->img) }}" alt="{{ $client->title }}" class="max-w-full max-h-full object-contain">
                            </div>
                        @else
                            <div class="w-20 h-20 rounded-xl bg-surface-container flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                                <span class="material-symbols-outlined text-3xl text-on-surface-variant">corporate_fare</span>
                            </div>
                        @endif
                        <p class="text-body-lg font-outfit font-semibold text-primary leading-snug flex-grow flex items-center justify-center group-hover:text-secondary transition-colors duration-300">{{ $client->title }}</p>
                        @if($client->sector)
                            <span class="mt-2 text-label-sm text-on-surface-variant">{{ $client->sector }}</span>
                        @endif
                    </a>
                    @else
                    <div class="reveal bg-white rounded-2xl border border-outline-variant/40 p-6 flex flex-col items-center text-center card-hover group soft-shadow h-full"
                         x-show="filter === 'all' || filter === '{{ $client->sector ?? '' }}'"
                         x-transition>
                        @if($client->img)
                            <div class="w-20 h-20 flex items-center justify-center mb-4 group-hover:scale-105 transition-transform duration-300">
                                <img src="{{ asset('storage/' . $client->img) }}" alt="{{ $client->title }}" class="max-w-full max-h-full object-contain">
                            </div>
                        @else
                            <div class="w-20 h-20 rounded-xl bg-surface-container flex items-center justify-center mb-4 group-hover:scale-105 transition-transform duration-300">
                                <span class="material-symbols-outlined text-3xl text-on-surface-variant">corporate_fare</span>
                            </div>
                        @endif
                        <p class="text-body-lg font-outfit font-semibold text-primary leading-snug flex-grow flex items-center justify-center">{{ $client->title }}</p>
                        @if($client->sector)
                            <span class="mt-2 text-label-sm text-on-surface-variant">{{ $client->sector }}</span>
                        @endif
                    </div>
                    @endif
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</section>

{{-- CTA Daftar Partner --}}
<section class="py-16 bg-surface">
    <div class="max-w-5xl mx-auto px-responsive">
        <div class="relative bg-primary rounded-2xl overflow-hidden">

            {{-- Subtle decorative bg --}}
            <div style="position:absolute;top:-80px;right:-80px;width:280px;height:280px;background:rgba(255,255,255,0.05);border-radius:9999px;pointer-events:none;"></div>
            <div style="position:absolute;bottom:-50px;right:120px;width:180px;height:180px;background:rgba(255,255,255,0.03);border-radius:9999px;pointer-events:none;"></div>

            <div class="relative flex flex-col md:flex-row items-center gap-0" style="padding: 2.5rem 3rem;">

                {{-- Left: Text content --}}
                <div style="flex:1; min-width:0;">
                    {{-- Eyebrow badge --}}
                    <div style="display:inline-flex;align-items:center;gap:5px;background:rgba(255,255,255,0.1);border:1px solid rgba(255,255,255,0.15);color:rgba(255,255,255,0.85);font-family:'Outfit',sans-serif;font-size:0.72rem;font-weight:600;letter-spacing:0.1em;text-transform:uppercase;padding:4px 12px;border-radius:9999px;margin-bottom:1rem;">
                        <span class="material-symbols-outlined" style="font-size:13px;line-height:1;">handshake</span>
                        Kemitraan Strategis
                    </div>
                    {{-- Heading --}}
                    <h2 style="font-family:'Outfit',sans-serif;font-weight:800;color:#ffffff;line-height:1.2;margin:0 0 0.6rem 0;font-size:clamp(1.6rem,2.5vw,2.2rem);">
                        Ingin menjadi Partner kami?
                    </h2>
                    {{-- Subtitle --}}
                    <p style="font-family:'Outfit',sans-serif;font-size:0.95rem;color:rgba(255,255,255,0.68);line-height:1.65;margin:0;">
                        Bergabunglah bersama jaringan partner strategis Indo Consulting<br class="hidden lg:block"> dan berkembang bersama kami.
                    </p>
                </div>

                {{-- Divider (desktop only) --}}
                <div class="hidden md:block" style="width:1px;height:80px;background:rgba(255,255,255,0.12);margin:0 2.5rem;flex-shrink:0;"></div>

                {{-- Right: CTA Button --}}
                <div style="flex-shrink:0;">
                    <a href="{{ route('partner.create') }}"
                       style="display:inline-flex;align-items:center;gap:0.6rem;background:#ffffff;color:#bb0027;font-family:'Outfit',sans-serif;font-weight:700;font-size:0.9rem;padding:0.85rem 1.75rem;border-radius:9999px;text-decoration:none;white-space:nowrap;box-shadow:0 4px 20px rgba(0,0,0,0.2);transition:transform 250ms ease, box-shadow 250ms ease;"
                       onmouseover="this.style.transform='scale(1.05)';this.style.boxShadow='0 8px 28px rgba(0,0,0,0.25)'"
                       onmouseout="this.style.transform='scale(1)';this.style.boxShadow='0 4px 20px rgba(0,0,0,0.2)'"
                       onmousedown="this.style.transform='scale(0.97)'"
                       onmouseup="this.style.transform='scale(1.05)'">
                        Daftar Sekarang
                        <span class="material-symbols-outlined" style="font-size:18px;line-height:1;">arrow_forward</span>
                    </a>
                </div>

            </div>
        </div>
    </div>
</section>



{{-- Testimonials Carousel --}}
<section class="py-block-gap bg-surface-container-low">
    <div class="max-w-4xl mx-auto px-margin-x">
        <h2 class="text-headline-sm font-outfit font-bold text-primary mb-8 text-center reveal">{{ $pageContent['testimonial_heading'] ?? 'Kata Mereka' }}</h2>
        @if($reviews->isNotEmpty())
        <div x-data="testimonialCarousel({{ $reviews->count() }})" class="relative px-6 md:px-16">
            {{-- Cards Container --}}
            <div class="overflow-hidden">
                <div class="flex transition-transform duration-500 ease-in-out" :style="'transform: translateX(calc(-' + (current * 100) + '% + ' + (current === 0 ? '0px' : '0px') + '))'">
                    @foreach($reviews as $i => $t)
                    <div class="w-full flex-shrink-0 px-3">
                        <div class="bg-white p-7 md:p-8 rounded-2xl border border-outline-variant/40 flex flex-col items-center text-center shadow-lg shadow-outline-variant/20 mx-auto max-w-lg transition-all duration-500"
                             :class="current === {{ $i }} ? 'scale-100 opacity-100' : 'scale-95 opacity-40'">
                            {{-- Stars --}}
                            @if($t->stars)
                            <div class="flex items-center gap-0.5 mb-4">
                                @for($s = 1; $s <= 5; $s++)
                                    @if($s <= (int)$t->stars)
                                        <span class="material-symbols-outlined text-secondary text-lg icon-filled">star</span>
                                    @else
                                        <span class="material-symbols-outlined text-on-surface-variant/25 text-lg">star</span>
                                    @endif
                                @endfor
                            </div>
                            @endif

                            {{-- Review Text --}}
                            <p class="text-body-md text-on-surface-variant italic leading-relaxed flex-1">"{{ $t->review }}"</p>

                            {{-- Author --}}
                            <div class="flex items-center gap-3 pt-5 mt-5 border-t border-outline-variant/20 w-full justify-center">
                                <div class="w-9 h-9 rounded-full bg-secondary/10 flex items-center justify-center flex-shrink-0">
                                    <span class="material-symbols-outlined text-secondary text-base">person</span>
                                </div>
                                <div class="text-left">
                                    <p class="text-label-sm font-outfit font-semibold text-primary">{{ $t->nama }}</p>
                                    <p class="text-label-xs text-on-surface-variant">{{ $t->pekerjaan }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Navigation Arrows --}}
            @if($reviews->count() > 1)
            <button @click="prev()" class="absolute left-0 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-white shadow-md border border-outline-variant/40 flex items-center justify-center hover:bg-surface-container transition-colors z-10">
                <span class="material-symbols-outlined text-primary text-lg">chevron_left</span>
            </button>
            <button @click="next()" class="absolute right-0 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-white shadow-md border border-outline-variant/40 flex items-center justify-center hover:bg-surface-container transition-colors z-10">
                <span class="material-symbols-outlined text-primary text-lg">chevron_right</span>
            </button>

            {{-- Dot Indicators --}}
            <div class="flex justify-center gap-2 mt-5">
                @foreach($reviews as $i => $t)
                <button @click="goTo({{ $i }})" :class="current === {{ $i }} ? 'bg-primary w-7' : 'bg-outline-variant/40 w-2.5'" class="h-2.5 rounded-full transition-all duration-300"></button>
                @endforeach
            </div>
            @endif
        </div>
        @else
            <p class="text-center text-on-surface-variant py-8">Belum ada testimoni.</p>
        @endif
    </div>
</section>

@push('scripts')
<script>
function testimonialCarousel(total) {
    return {
        current: 0,
        total: total,
        interval: null,
        init() {
            if (this.total > 1) {
                this.interval = setInterval(() => this.next(), 5000);
            }
        },
        next() {
            this.current = (this.current + 1) % this.total;
            this.resetInterval();
        },
        prev() {
            this.current = (this.current - 1 + this.total) % this.total;
            this.resetInterval();
        },
        goTo(index) {
            this.current = index;
            this.resetInterval();
        },
        resetInterval() {
            clearInterval(this.interval);
            if (this.total > 1) {
                this.interval = setInterval(() => this.next(), 5000);
            }
        }
    }
}
</script>
@endpush

</div>{{-- End Alpine.js wrapper --}}

@endsection
