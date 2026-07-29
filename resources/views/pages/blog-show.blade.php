@extends('layouts.app')

@section('title', $blog->title . ' - Indo Consulting')
@section('description', $blog->caption ?? $blog->title)

@section('content')

{{-- Hero --}}
<section class="bg-surface-container pt-16 lg:pt-18">
    <div class="max-w-container mx-auto px-responsive py-16">
        <a href="{{ route('news-events') }}" class="inline-flex items-center gap-1.5 text-secondary text-label-md font-outfit font-semibold hover:gap-2.5 transition-all duration-200 mb-8">
            <span class="material-symbols-outlined text-base">arrow_back</span> Kembali ke Berita
        </a>

        <div class="flex items-center gap-3 mb-4">
            <span class="text-label-sm font-outfit font-semibold text-secondary">{{ $blog->kategori->title ?? '' }}</span>
            <span class="text-on-surface-variant/40">·</span>
            <time class="text-label-sm text-on-surface-variant/70">{{ $blog->date }}</time>
        </div>

        <h1 class="text-3xl md:text-headline-lg font-outfit font-bold text-primary mb-6">{{ $blog->title }}</h1>

        {{-- Meta: views + share --}}
        <div class="flex flex-wrap items-center gap-4">
            {{-- Views --}}
            <div class="flex items-center gap-1.5 text-on-surface-variant/60">
                <span class="material-symbols-outlined text-lg">visibility</span>
                <span class="text-label-sm font-outfit">{{ number_format($blog->hit) }} dilihat</span>
            </div>

            <span class="text-on-surface-variant/30">|</span>

            {{-- Share Buttons --}}
            <div class="flex items-center gap-2">
                <span class="text-label-sm text-on-surface-variant/60 font-outfit font-semibold">Share:</span>

                @php $shareUrl = url('/berita/' . $blog->slug); @endphp
                @php $shareText = $blog->title; @endphp

                {{-- WhatsApp --}}
                <a href="https://wa.me/?text={{ urlencode($shareText . ' ' . $shareUrl) }}" target="_blank" rel="noopener" class="w-9 h-9 rounded-lg bg-green-500/10 flex items-center justify-center text-green-600 hover:bg-green-500 hover:text-white transition-all duration-200" title="Share ke WhatsApp">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                </a>

                {{-- Twitter/X --}}
                <a href="https://twitter.com/intent/tweet?text={{ urlencode($shareText) }}&url={{ urlencode($shareUrl) }}" target="_blank" rel="noopener" class="w-9 h-9 rounded-lg bg-sky-500/10 flex items-center justify-center text-sky-500 hover:bg-sky-500 hover:text-white transition-all duration-200" title="Share ke Twitter/X">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                </a>

                {{-- Facebook --}}
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($shareUrl) }}" target="_blank" rel="noopener" class="w-9 h-9 rounded-lg bg-blue-600/10 flex items-center justify-center text-blue-600 hover:bg-blue-600 hover:text-white transition-all duration-200" title="Share ke Facebook">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                </a>

                {{-- Copy Link --}}
                <button onclick="navigator.clipboard.writeText('{{ $shareUrl }}'); this.querySelector('.link-icon').classList.add('hidden'); this.querySelector('.check-icon').classList.remove('hidden'); setTimeout(() => { this.querySelector('.link-icon').classList.remove('hidden'); this.querySelector('.check-icon').classList.add('hidden'); }, 2000)" class="w-9 h-9 rounded-lg bg-on-surface-variant/10 flex items-center justify-center text-on-surface-variant/60 hover:bg-on-surface-variant/20 hover:text-on-surface transition-all duration-200 relative" title="Salin link">
                    <span class="material-symbols-outlined text-lg link-icon">link</span>
                    <span class="material-symbols-outlined text-lg check-icon hidden text-green-600">check</span>
                </button>
            </div>
        </div>
    </div>
</section>

{{-- Article Content --}}
<section class="py-16 bg-surface">
    <div class="max-w-container mx-auto px-responsive">
        <div class="grid lg:grid-cols-5 gap-12">

            {{-- Main Content --}}
            <div class="lg:col-span-3">
                @if($blog->img && !str_starts_with($blog->img, 'http'))
                    <img src="{{ asset('storage/' . $blog->img) }}" alt="{{ $blog->title }}" class="w-full h-72 md:h-96 object-cover rounded-2xl mb-8">
                @elseif($blog->img)
                    <img src="{{ $blog->img }}" alt="{{ $blog->title }}" class="w-full h-72 md:h-96 object-cover rounded-2xl mb-8">
                @endif

                @if($blog->caption)
                    <p class="text-body-lg text-on-surface-variant/80 italic mb-6 pb-6 border-b border-outline-variant/40">{{ $blog->caption }}</p>
                @endif

                <div class="prose prose-lg max-w-none">
                    {!! $blog->content !!}
                </div>

                @if($blog->tags)
                <div class="mt-8 pt-6 border-t border-outline-variant/40">
                    <p class="text-label-sm text-on-surface-variant/60 font-outfit font-semibold mb-2">Tags:</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach(explode(',', $blog->tags) as $tag)
                            <span class="px-3 py-1 rounded-full bg-secondary/10 text-secondary text-label-sm font-outfit font-semibold">{{ trim($tag) }}</span>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            {{-- Sidebar --}}
            <div class="lg:col-span-2">
                <div class="bg-surface-container-low rounded-2xl p-8 border border-outline-variant/40 sticky top-24">
                    <h3 class="text-headline-sm font-outfit font-bold text-primary mb-6">Informasi Berita</h3>

                    <div class="space-y-5">
                        <div>
                            <p class="text-label-sm text-on-surface-variant/60 mb-1">Kategori</p>
                            <p class="text-body-md text-on-surface-variant font-medium">{{ $blog->kategori->title ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-label-sm text-on-surface-variant/60 mb-1">Tanggal</p>
                            <p class="text-body-md text-on-surface-variant font-medium">{{ $blog->date ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-label-sm text-on-surface-variant/60 mb-1">Dilihat</p>
                            <p class="text-body-md text-on-surface-variant font-medium">{{ number_format($blog->hit) }} kali</p>
                        </div>
                    </div>

                    <hr class="my-6 border-outline-variant/40">

                    <h4 class="text-label-sm font-outfit font-semibold text-on-surface-variant/60 mb-4">Bagikan Berita Ini</h4>
                    <div class="space-y-2">
                        <a href="https://wa.me/?text={{ urlencode($blog->title . ' ' . url('/berita/' . $blog->slug)) }}" target="_blank" class="flex items-center justify-center gap-2.5 w-full px-4 py-3 rounded-xl bg-green-500 text-white text-label-md font-outfit font-semibold hover:bg-green-600 transition-all">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            WhatsApp
                        </a>
                        <div class="grid grid-cols-2 gap-2">
                            <a href="https://twitter.com/intent/tweet?text={{ urlencode($blog->title) }}&url={{ urlencode(url('/berita/' . $blog->slug)) }}" target="_blank" class="flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-sky-500 text-white text-label-md font-outfit font-semibold hover:bg-sky-600 transition-all">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                Twitter
                            </a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url('/berita/' . $blog->slug)) }}" target="_blank" class="flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-blue-600 text-white text-label-md font-outfit font-semibold hover:bg-blue-700 transition-all">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                Facebook
                            </a>
                        </div>
                    </div>

                    <a href="{{ route('news-events') }}" class="flex items-center justify-center gap-2 w-full px-6 py-3 mt-6 rounded-xl border-2 border-secondary text-secondary text-label-md font-outfit font-semibold hover:bg-secondary hover:text-white transition-all duration-300">
                        <span class="material-symbols-outlined text-lg">arrow_back</span>
                        Lihat Semua Berita
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Other News --}}
@if($otherBlogs->isNotEmpty())
<section class="py-16 bg-surface-container-low">
    <div class="max-w-container mx-auto px-responsive">
        <h2 class="text-headline-sm font-outfit font-bold text-primary mb-8">Berita Lainnya</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($otherBlogs as $other)
            <a href="{{ route('blog.show', $other->slug) }}" class="bg-white rounded-2xl overflow-hidden border border-outline-variant/40 soft-shadow-md card-hover group transition-all">
                @if($other->img && !str_starts_with($other->img, 'http'))
                    <div class="h-40 overflow-hidden">
                        <img src="{{ asset('storage/' . $other->img) }}" alt="{{ $other->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    </div>
                @endif
                <div class="p-6">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-label-sm font-outfit font-semibold text-secondary">{{ $other->kategori->title ?? '' }}</span>
                        <span class="text-on-surface-variant/40">·</span>
                        <time class="text-label-sm text-on-surface-variant/70">{{ $other->date }}</time>
                    </div>
                    <h3 class="text-body-lg font-outfit font-bold text-primary mb-2">{{ $other->title }}</h3>
                    <span class="inline-flex items-center gap-1 text-secondary text-label-sm font-semibold group-hover:gap-2 transition-all duration-200">
                        Baca Selengkapnya <span class="material-symbols-outlined text-base">arrow_forward</span>
                    </span>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
