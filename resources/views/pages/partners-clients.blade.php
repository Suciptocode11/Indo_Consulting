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
                {{-- Featured Partners (first 4, larger) --}}
                @if($clients->count() > 4)
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                    @foreach($clients->take(4) as $client)
                    <div class="reveal bg-white rounded-2xl border border-outline-variant/40 p-6 flex flex-col items-center text-center card-hover group soft-shadow"
                         x-show="filter === 'all' || filter === '{{ $client->sector ?? '' }}'"
                         x-transition>
                        @if($client->img)
                            <img src="{{ asset('storage/' . $client->img) }}" alt="{{ $client->title }}" class="w-14 h-14 rounded-xl object-cover mb-4 group-hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="w-14 h-14 rounded-xl bg-surface-container flex items-center justify-center mb-4 group-hover:scale-105 transition-transform duration-300">
                                <span class="material-symbols-outlined text-3xl text-on-surface-variant">corporate_fare</span>
                            </div>
                        @endif
                        <p class="text-body-lg font-outfit font-semibold text-primary leading-snug">{{ $client->title }}</p>
                        @if($client->sector)
                            <span class="mt-2 text-label-sm text-on-surface-variant">{{ $client->sector }}</span>
                        @endif
                    </div>
                    @endforeach
                </div>
                @endif

                {{-- Supporting Partners (remaining, smaller) --}}
                @if($clients->count() > 4)
                <div class="grid grid-cols-3 sm:grid-cols-4 lg:grid-cols-6 gap-3">
                    @foreach($clients->slice(4) as $client)
                    <div class="reveal bg-white rounded-xl border border-outline-variant/40 p-4 flex flex-col items-center text-center card-hover group"
                         x-show="filter === 'all' || filter === '{{ $client->sector ?? '' }}'"
                         x-transition>
                        @if($client->img)
                            <img src="{{ asset('storage/' . $client->img) }}" alt="{{ $client->title }}" class="w-10 h-10 rounded-lg object-cover mb-3 group-hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="w-10 h-10 rounded-lg bg-surface-container flex items-center justify-center mb-3 group-hover:scale-105 transition-transform duration-300">
                                <span class="material-symbols-outlined text-xl text-on-surface-variant">corporate_fare</span>
                            </div>
                        @endif
                        <p class="text-label-md font-outfit font-semibold text-primary leading-snug">{{ $client->title }}</p>
                        @if($client->sector)
                            <span class="mt-1 text-label-sm text-on-surface-variant">{{ $client->sector }}</span>
                        @endif
                    </div>
                    @endforeach
                </div>
                @endif

                {{-- If 4 or less, single grid --}}
                @if($clients->count() <= 4)
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                    @foreach($clients as $client)
                    <div class="reveal bg-white rounded-2xl border border-outline-variant/40 p-6 flex flex-col items-center text-center card-hover group soft-shadow"
                         x-show="filter === 'all' || filter === '{{ $client->sector ?? '' }}'"
                         x-transition>
                        @if($client->img)
                            <img src="{{ asset('storage/' . $client->img) }}" alt="{{ $client->title }}" class="w-14 h-14 rounded-xl object-cover mb-4 group-hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="w-14 h-14 rounded-xl bg-surface-container flex items-center justify-center mb-4 group-hover:scale-105 transition-transform duration-300">
                                <span class="material-symbols-outlined text-3xl text-on-surface-variant">corporate_fare</span>
                            </div>
                        @endif
                        <p class="text-body-lg font-outfit font-semibold text-primary leading-snug">{{ $client->title }}</p>
                        @if($client->sector)
                            <span class="mt-2 text-label-sm text-on-surface-variant">{{ $client->sector }}</span>
                        @endif
                    </div>
                    @endforeach
                </div>
                @endif
            @endif
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
