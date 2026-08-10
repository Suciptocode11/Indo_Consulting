@extends('layouts.app')

@section('title', 'Indo Consulting - Bergerak Bertumbuh Bersama')
@section('description', 'Indo Consulting adalah lembaga konsultan terkemuka bidang Manajemen Pendidikan, Pengembangan SDM, Keuangan dan Pajak, Teknologi Informasi, Hukum dan Perizinan.')

@section('content')

{{-- ===== HERO SECTION ===== --}}
<section class="hero-pattern relative overflow-hidden min-h-[calc(100dvh-4rem)] lg:min-h-[calc(100dvh-4.5rem)] flex items-center">
    {{-- Decorative Background Ambient Glow --}}
    <div class="absolute top-1/4 -left-20 w-72 h-72 bg-secondary/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-10 -right-20 w-80 h-80 bg-blue-600/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-container mx-auto px-responsive relative z-10 py-16 sm:py-24 lg:py-20 w-full">
        <div class="grid lg:grid-cols-2 gap-8 lg:gap-16 items-center">

            {{-- Left: Copy --}}
            <div class="space-y-8 sm:space-y-10">
                {{-- Eyebrow Badge --}}
                <div class="reveal inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-md border border-white/15 text-white/90 text-sm font-medium">
                    <span class="w-2.5 h-2.5 rounded-full bg-secondary animate-pulse"></span>
                    <span>{{ $pageContent['hero_eyebrow'] ?? 'Lembaga Konsultan Terkemuka' }}</span>
                </div>

                {{-- Headline --}}
                <h1 class="text-7xl sm:text-8xl md:text-9xl lg:text-display-lg font-outfit font-bold text-white leading-[1.05] tracking-tight reveal" style="letter-spacing:-0.03em;">
                    {{ $pageContent['hero_heading_1'] ?? 'Bergerak' }}<br>
                    <span class="text-secondary">{{ $pageContent['hero_heading_2'] ?? 'Bertumbuh' }}</span><br>
                    {{ $pageContent['hero_heading_3'] ?? 'Bersama' }}
                </h1>

                {{-- Description --}}
                <p class="text-2xl sm:text-3xl lg:text-body-lg text-white/80 max-w-xl font-outfit leading-relaxed reveal">
                    {{ $pageContent['hero_description'] ?? 'Indo Consulting adalah lembaga konsultan terkemuka bidang Manajemen Pendidikan, Pengembangan SDM, Keuangan, Teknologi Informasi, serta Hukum dan Perizinan.' }}
                </p>

                {{-- Action Buttons --}}
                <div class="flex flex-col sm:flex-row gap-4 reveal pt-4">
                    <a href="{{ route('kontak-kami') }}" class="btn-primary inline-flex items-center justify-center gap-2 px-10 py-5 rounded-xl sm:rounded-full text-lg sm:text-label-md font-outfit font-semibold text-center shadow-lg shadow-secondary/20 hover:shadow-secondary/30 transition-all">
                        <span>{{ $pageContent['hero_btn_primary'] ?? 'Konsultasi Sekarang' }}</span>
                        <span class="material-symbols-outlined text-lg">arrow_forward</span>
                    </a>
                    <a href="{{ route('tentang-kami') }}" class="btn-ghost-light inline-flex items-center justify-center gap-2 px-10 py-5 rounded-xl sm:rounded-full text-lg sm:text-label-md font-outfit font-semibold text-center">
                        <span>{{ $pageContent['hero_btn_secondary'] ?? 'Pelajari Lebih Lanjut' }}</span>
                    </a>
                </div>
            </div>

            {{-- Right / Desktop Only Image (Hidden on Mobile) --}}
            <div class="hidden lg:block relative reveal">
                <div class="relative rounded-2xl overflow-hidden shadow-2xl border border-white/15 group">
                    @if(!empty($pageContent['hero_image']) && $pageContent['hero_image'] !== '')
                        <img
                            src="{{ str_starts_with($pageContent['hero_image'], 'http') ? $pageContent['hero_image'] : asset('storage/' . $pageContent['hero_image']) }}"
                            alt="Tim konsultan profesional Indo Consulting"
                            class="w-full h-[500px] object-cover transition-transform duration-700 group-hover:scale-105"
                        >
                    @else
                        <img
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuBJFJscYh7O0kxSXjZlMyZuqxWqdUpYYCu1sVrD-G0Jw-iNN6VqOAACQ1cui_xjtTV8XvuAWWiKxOqhkT4BVC6S0wRZQGI5PO0k3EkIHypoA7YYT0l-sZD8TfGWo2nS1s3biW5_HOFUU5MgClto_rwZ3eWXYQwAvBMg8z0s_gUbEdMrk5x7x-VKsL02lWws4-WgqVGH-_aq2LCSNiaxPOTQfiaHbI_ORTl_56lCbCNu52JqqvWvzRut3x_70dOGU4NewkEkF96koQ"
                            alt="Tim konsultan profesional Indo Consulting"
                            class="w-full h-[500px] object-cover transition-transform duration-700 group-hover:scale-105"
                        >
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-primary/40 to-transparent"></div>
                </div>
            </div>

        </div>
    </div>
</section>


{{-- ===== PROGRAM SECTION ===== --}}
<section class="py-32 bg-surface" id="program">
    <div class="max-w-container mx-auto px-responsive">

        <div class="text-center mb-14 reveal">
            <h2 class="text-headline-lg font-outfit font-bold text-primary">{{ $pageContent['programs_heading'] ?? 'Program Kami' }}</h2>
            <p class="text-body-md text-on-surface-variant mt-3 max-w-xl mx-auto">{{ $pageContent['programs_description'] ?? '' }}</p>
        </div>

        {{-- BENTO GRID - Asymmetric layout (NOT equal columns) --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 auto-rows-fr" data-stagger>
            @if($services->isNotEmpty())
                {{-- Card 1 - LARGE (first service) --}}
                @php $srv = $services->shift(); @endphp
                <div class="reveal lg:col-span-7 bg-white rounded-2xl p-8 soft-shadow-md card-hover group cursor-pointer">
                    <div class="w-16 h-16 bg-secondary/10 rounded-xl flex items-center justify-center mb-6 group-hover:bg-secondary/20 transition-colors">
                        <span class="material-symbols-outlined text-5xl text-secondary">{{ $srv->icon }}</span>
                    </div>
                    <h3 class="text-headline-md font-outfit font-semibold text-primary mb-4">{{ $srv->title }}</h3>
                    <p class="text-body-lg text-on-surface-variant leading-relaxed mb-5">{{ $srv->short ?? $srv->content }}</p>
                    <a href="{{ route('program.show', $srv->slug) }}" class="inline-flex items-center gap-1.5 text-secondary text-label-md font-semibold group-hover:gap-3 transition-all duration-200">
                        Selengkapnya <span class="material-symbols-outlined text-lg">arrow_forward</span>
                    </a>
                </div>

            @foreach($services as $i => $srv)
            @php $span = ($i % 2 === 0) ? 'lg:col-span-5' : 'lg:col-span-7'; $pad = ($i % 2 === 0) ? 'p-7' : 'p-8'; $size = ($i % 2 === 0) ? 'text-headline-sm' : 'text-headline-md'; $iconBox = ($i % 2 === 0) ? 'w-14 h-14' : 'w-16 h-16'; $iconText = ($i % 2 === 0) ? 'text-4xl' : 'text-5xl'; $textSize = ($i % 2 === 0) ? 'text-body-md' : 'text-body-lg'; @endphp
            <div class="reveal {{ $span }} bg-white rounded-2xl {{ $pad }} soft-shadow-md card-hover group cursor-pointer">
                <div class="{{ $iconBox }} bg-secondary/10 rounded-xl flex items-center justify-center mb-5 group-hover:bg-secondary/20 transition-colors">
                    <span class="material-symbols-outlined {{ $iconText }} text-secondary">{{ $srv->icon ?? 'school' }}</span>
                </div>
                <h3 class="{{ $size }} font-outfit font-semibold text-primary mb-3">{{ $srv->title }}</h3>
                <p class="{{ $textSize }} text-on-surface-variant leading-relaxed mb-4">{{ $srv->short ?? $srv->content }}</p>
                <a href="{{ route('program.show', $srv->slug) }}" class="inline-flex items-center gap-1 text-secondary text-label-md font-semibold group-hover:gap-2 transition-all duration-200">
                    Selengkapnya <span class="material-symbols-outlined text-base">arrow_forward</span>
                </a>
            </div>
            @endforeach
            @endif
        </div>

        <div class="text-center mt-12 reveal">
            <a href="{{ route('program') }}" class="btn-secondary inline-block px-8 py-3.5 rounded-xl text-label-md font-outfit font-semibold">
                Lihat Semua Program
            </a>
        </div>
    </div>
</section>

{{-- ===== ABOUT SECTION ===== --}}
<section class="py-block-gap bg-surface-container-low" id="about">
    <div class="max-w-container mx-auto px-responsive">
        <div class="grid lg:grid-cols-2 gap-16 items-center">

            {{-- Left: Image --}}
            <div class="relative reveal">
                <div class="rounded-2xl overflow-hidden soft-shadow">
                    @if(!empty($pageContent['about_image']) && $pageContent['about_image'] !== '')
                        <img
                            src="{{ str_starts_with($pageContent['about_image'], 'http') ? $pageContent['about_image'] : asset('storage/' . $pageContent['about_image']) }}"
                            alt="Profesional Indo Consulting"
                            class="w-full h-[480px] object-cover"
                        >
                    @else
                        <div class="w-full h-[480px] bg-surface-container flex items-center justify-center">
                            <span class="material-symbols-outlined text-on-surface-variant/20" style="font-size: 120px;">groups</span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Right: Content --}}
            <div class="space-y-6 reveal">
                <h2 class="text-headline-lg font-outfit font-bold text-primary">{{ $pageContent['about_heading'] ?? 'Tentang Indo Consulting' }}</h2>
                <p class="text-body-lg text-on-surface-variant leading-relaxed">
                    <strong class="text-primary">Indo Consulting</strong> adalah lembaga konsultan terkemuka yang berfokus memberikan solusi bisnis inovatif dan terintegrasi untuk mendukung pertumbuhan dan keberlanjutan perusahaan di berbagai industri.
                </p>
                <p class="text-body-md text-on-surface-variant leading-relaxed">
                    Didukung oleh tim profesional berpengalaman, Indo Consulting berkomitmen memberikan layanan berkualitas tinggi dalam bidang Strategi Bisnis, Keuangan &amp; Investasi, Hukum, serta Riset, Pendidikan, dan Pelatihan. Kepercayaan klien adalah prioritas utama kami.
                </p>

                {{-- Feature list --}}
                <ul class="space-y-3 bg-white rounded-xl p-5 border border-outline-variant/40">
                    @foreach(['feature_1', 'feature_2', 'feature_3', 'feature_4'] as $fk)
                        @if(!empty($pageContent[$fk]))
                        <li class="flex items-center gap-3">
                            <span class="w-5 h-5 rounded-full bg-secondary/15 flex items-center justify-center flex-shrink-0">
                                <span class="material-symbols-outlined text-secondary text-sm icon-filled">check</span>
                            </span>
                            <span class="text-body-md text-on-surface-variant">{{ $pageContent[$fk] }}</span>
                        </li>
                        @endif
                    @endforeach
                </ul>

                <a href="{{ route('tentang-kami') }}" class="btn-primary inline-block px-8 py-3.5 rounded-xl text-label-md font-outfit font-semibold mt-2">
                    Selengkapnya
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ===== PORTFOLIO SECTION ===== --}}
<section class="py-block-gap bg-surface" id="portfolio">
    <div class="max-w-container mx-auto px-responsive">

        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-12 gap-4 reveal">
            <div>
                <h2 class="text-headline-lg font-outfit font-bold text-primary">{{ $pageContent['portfolio_heading'] ?? 'Portfolio Kami' }}</h2>
                <p class="text-body-md text-on-surface-variant mt-2">{{ $pageContent['portfolio_description'] ?? '' }}</p>
            </div>
            <a href="{{ route('portfolio') }}" class="text-secondary text-label-md font-semibold hover:underline underline-offset-4 flex items-center gap-1 whitespace-nowrap">
                Lihat Semua <span class="material-symbols-outlined text-base">arrow_forward</span>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" data-stagger>
            @foreach($projects as $proj)
            <div class="reveal bg-white rounded-2xl overflow-hidden soft-shadow-md border border-outline-variant/60 card-hover group flex flex-col h-full">
                <a href="{{ route('portfolio.show', $proj->slug) }}" class="relative overflow-hidden h-56 block">
                    <img alt="{{ $proj->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="{{ $proj->img && !str_starts_with($proj->img, 'http') ? asset('storage/' . $proj->img) : $proj->img }}">
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
            @endforeach
        </div>
    </div>
</section>

{{-- ===== PARTNERS MARQUEE ===== --}}
<section class="py-16 bg-surface-container border-y border-outline-variant/40 overflow-hidden">
    <div class="max-w-container mx-auto px-responsive mb-10 reveal">
        <h2 class="text-headline-md font-outfit font-bold text-primary text-center">{!! $pageContent['partners_heading'] ?? 'Mitra &amp; Klien Kami' !!}</h2>
    </div>

    {{-- Marquee --}}
    <div class="relative overflow-hidden">
        {{-- Side Gradient Fades for Premium Look --}}
        <div class="pointer-events-none absolute inset-y-0 left-0 w-16 sm:w-28 bg-gradient-to-r from-surface-container to-transparent z-10"></div>
        <div class="pointer-events-none absolute inset-y-0 right-0 w-16 sm:w-28 bg-gradient-to-l from-surface-container to-transparent z-10"></div>

        <div class="marquee-wrap">
            @php
                $marqueeItems = collect($clients);
                // Multiplikasi item jika kurang dari 12 agar 1 set marquee cukup lebar mengisi layar monitor besar tanpa jeda/gap
                if ($marqueeItems->count() > 0) {
                    while ($marqueeItems->count() < 12) {
                        $marqueeItems = $marqueeItems->concat($clients);
                    }
                }
            @endphp
            {{-- Set 1 --}}
            <div class="marquee-set">
                @foreach($marqueeItems as $partner)
                <div class="flex items-center px-4 py-2 flex-shrink-0">
                    @if($partner->img && !str_starts_with($partner->img, 'http'))
                        <img src="{{ asset('storage/' . $partner->img) }}" alt="{{ $partner->title }}" class="h-16 sm:h-20 w-auto object-contain transition-transform duration-300 hover:scale-105">
                    @else
                        <span class="text-label-lg font-outfit font-semibold text-on-surface-variant/80 whitespace-nowrap">{{ $partner->title }}</span>
                    @endif
                </div>
                @endforeach
            </div>
            {{-- Set 2 (duplicate untuk seamless loop) --}}
            <div class="marquee-set">
                @foreach($marqueeItems as $partner)
                <div class="flex items-center px-4 py-2 flex-shrink-0">
                    @if($partner->img && !str_starts_with($partner->img, 'http'))
                        <img src="{{ asset('storage/' . $partner->img) }}" alt="{{ $partner->title }}" class="h-16 sm:h-20 w-auto object-contain transition-transform duration-300 hover:scale-105">
                    @else
                        <span class="text-label-lg font-outfit font-semibold text-on-surface-variant/80 whitespace-nowrap">{{ $partner->title }}</span>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ===== NEWS & EVENTS SECTION ===== --}}
<section class="py-block-gap bg-surface" id="news">
    <div class="max-w-container mx-auto px-responsive">

        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-12 gap-4 reveal">
            <div>
                <h2 class="text-headline-lg font-outfit font-bold text-primary">{!! $pageContent['news_heading'] ?? 'Berita &amp; Acara' !!}</h2>
                <p class="text-body-md text-on-surface-variant mt-2">Informasi terkini seputar kegiatan Indo Consulting</p>
            </div>
            <a href="{{ route('news-events') }}" class="text-secondary text-label-md font-semibold hover:underline underline-offset-4 flex items-center gap-1 whitespace-nowrap">
                Lihat Semua <span class="material-symbols-outlined text-base">arrow_forward</span>
            </a>
        </div>

        {{-- FEATURED NEWS + 2-COL layout (NOT equal columns) --}}
        <div class="space-y-6" data-stagger>
            @php
            $newsItems = $blogs->values();
        @endphp

        @if($newsItems->isNotEmpty())
            {{-- FEATURED News (first item - prominent) --}}
            <a href="{{ route('blog.show', $newsItems[0]->slug) }}" class="reveal bg-white rounded-2xl overflow-hidden soft-shadow-md border border-outline-variant/60 card-hover group block">
                <div class="grid lg:grid-cols-2 gap-0">
                    <div class="relative h-64 lg:h-auto overflow-hidden">
                        @if($newsItems[0]->img && !str_starts_with($newsItems[0]->img, 'http'))
                            <img alt="{{ $newsItems[0]->title }}" src="{{ asset('storage/' . $newsItems[0]->img) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @elseif($newsItems[0]->img)
                            <img alt="{{ $newsItems[0]->title }}" src="{{ $newsItems[0]->img }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-primary/40 to-transparent"></div>
                    </div>
                    <div class="p-8 flex flex-col justify-center">
                        <time class="text-label-sm text-on-surface-variant/70 mb-3 flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-base">calendar_today</span>
                            {{ $newsItems[0]->date }}
                        </time>
                        <h3 class="text-headline-md font-outfit font-semibold text-primary mb-4">{{ $newsItems[0]->title }}</h3>
                        <p class="text-body-lg text-on-surface-variant leading-relaxed mb-6">{{ $newsItems[0]->caption ?? '' }}</p>
                        <span class="inline-flex items-center gap-1.5 text-secondary text-label-md font-semibold group-hover:gap-3 transition-all duration-200 w-fit">
                            Baca Selengkapnya <span class="material-symbols-outlined text-lg">arrow_forward</span>
                        </span>
                    </div>
                </div>
            </a>

            {{-- Supporting News (2-col grid) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($newsItems->slice(1) as $n)
                <a href="{{ route('blog.show', $n->slug) }}" class="reveal bg-white rounded-2xl overflow-hidden soft-shadow-md border border-outline-variant/60 card-hover group flex flex-col block">
                    <div class="relative h-48 overflow-hidden">
                        @if($n->img && !str_starts_with($n->img, 'http'))
                            <img alt="{{ $n->title }}" src="{{ asset('storage/' . $n->img) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @elseif($n->img)
                            <img alt="{{ $n->title }}" src="{{ $n->img }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @endif
                    </div>
                    <div class="p-6 flex flex-col flex-1">
                        <time class="text-label-sm text-on-surface-variant/70 mb-3 flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-base">calendar_today</span>
                            {{ $n->date }}
                        </time>
                        <h3 class="text-headline-sm font-outfit font-semibold text-primary mb-3">{{ $n->title }}</h3>
                        <p class="text-body-md text-on-surface-variant leading-relaxed flex-1">{{ $n->caption ?? '' }}</p>
                        <span class="mt-5 inline-flex items-center gap-1 text-secondary text-label-md font-semibold group-hover:gap-2 transition-all duration-200">
                            Baca Selengkapnya <span class="material-symbols-outlined text-base">arrow_forward</span>
                        </span>
                    </div>
                </a>
                @endforeach
            </div>
        @endif
        </div>
    </div>
</section>

{{-- ===== TESTIMONIALS CAROUSEL ===== --}}
<section class="py-block-gap bg-surface-container-low" id="testimoni">
    <div class="max-w-container mx-auto px-responsive">

        <div class="text-center mb-14 reveal">
            <h2 class="text-headline-lg font-outfit font-bold text-primary">{{ $pageContent['testimonial_heading'] ?? 'Apa Kata Klien Kami' }}</h2>
            <p class="text-body-md text-on-surface-variant mt-3 max-w-xl mx-auto">Kepercayaan dan kepuasan klien adalah standar terbaik kami</p>
        </div>

        @php
        @endphp

        {{-- Carousel Container --}}
        @if($reviews->isNotEmpty())
        <div x-data="{
            current: 0,
            total: {{ count($reviews) }},
            next() { this.current = (this.current + 1) % this.total },
            prev() { this.current = (this.current - 1 + this.total) % this.total }
        }" class="relative">

            {{-- Testimonials Slider --}}
            <div class="overflow-hidden">
                <div class="flex transition-transform duration-500 ease-out"
                     :style="'transform: translateX(-' + (current * 100) + '%)'">
                    @foreach($reviews as $t)
                    <div class="w-full flex-shrink-0 px-2">
                        <div class="bg-white p-10 rounded-2xl border border-outline-variant/60 soft-shadow-md mx-auto max-w-3xl">
                            <div class="flex flex-col items-center text-center gap-6">
                                {{-- Avatar & Info --}}
                                <div class="flex flex-col items-center">
                                    <div class="w-24 h-24 rounded-full bg-secondary/10 flex items-center justify-center border-4 border-outline-variant/40 mb-4">
    <span class="material-symbols-outlined text-secondary text-3xl">person</span>
</div>
                                    <h4 class="text-headline-sm font-outfit font-semibold text-primary">{{ $t->nama }}</h4>
                                    <span class="text-body-md text-on-surface-variant mb-3">{{ $t->pekerjaan }}</span>
                                    <div class="flex gap-1 text-secondary">
                                        @for($i = 0; $i < (int) $t->stars; $i++)
                                        <span class="material-symbols-outlined text-xl icon-filled">star</span>
                                        @endfor
                                    </div>
                                </div>
                                {{-- Testimonial Text --}}
                                <p class="text-body-lg text-on-surface-variant italic leading-relaxed">{{ $t->review }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Navigation Buttons --}}
            <button @click="prev"
                    class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 w-12 h-12 rounded-full bg-white border-2 border-outline-variant/40 flex items-center justify-center text-primary hover:bg-primary hover:text-white hover:border-primary transition-all duration-300 shadow-md hover:scale-110 active:scale-95 z-10"
                    aria-label="Previous testimonial">
                <span class="material-symbols-outlined text-2xl">chevron_left</span>
            </button>
            <button @click="next"
                    class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 w-12 h-12 rounded-full bg-white border-2 border-outline-variant/40 flex items-center justify-center text-primary hover:bg-primary hover:text-white hover:border-primary transition-all duration-300 shadow-md hover:scale-110 active:scale-95 z-10"
                    aria-label="Next testimonial">
                <span class="material-symbols-outlined text-2xl">chevron_right</span>
            </button>

            {{-- Dot Indicators --}}
            <div class="flex items-center justify-center gap-2 mt-8">
                @foreach($reviews as $index => $t)
                <button @click="current = {{ $index }}"
                        :class="current === {{ $index }} ? 'bg-primary w-8' : 'bg-outline-variant w-3'"
                        class="h-3 rounded-full transition-all duration-300 hover:bg-primary/70"
                        aria-label="Go to testimonial {{ $index + 1 }}">
                </button>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>

{{-- ===== CTA SECTION ===== --}}
<section class="py-20 bg-surface">
    <div class="max-w-container mx-auto px-responsive">
        <div class="bg-primary rounded-3xl p-12 md:p-16 soft-shadow-md relative overflow-hidden">
            <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 80% 50%, rgba(187,0,39,0.5) 0%, transparent 60%)"></div>
            <div class="text-center relative z-10 reveal">
                <h2 class="text-headline-lg font-outfit font-bold text-white mb-5">{{ $pageContent['cta_heading'] ?? 'Siap untuk Bertumbuh Bersama Kami?' }}</h2>
                <p class="text-body-lg text-white/65 max-w-xl mx-auto mb-10">Hubungi tim konsultan kami dan temukan solusi terbaik untuk bisnis Anda.</p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('kontak-kami') }}" class="bg-white text-primary hover:bg-white/90 inline-flex items-center justify-center gap-2 px-10 py-4 rounded-full text-label-md font-outfit font-semibold transition-all duration-300 hover:scale-105 active:scale-95 shadow-md">
                        Konsultasi Sekarang
                        <span class="material-symbols-outlined text-xl">arrow_forward</span>
                    </a>
                    <a href="{{ route('program') }}" class="btn-ghost-light inline-flex items-center justify-center gap-2 px-10 py-4 rounded-full text-label-md font-outfit font-semibold">
                        Lihat Program
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
