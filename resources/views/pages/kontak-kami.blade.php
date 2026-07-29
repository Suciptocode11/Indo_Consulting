@extends('layouts.app')

@section('title', 'Kontak Kami - Indo Consulting')
@section('description', 'Hubungi tim konsultan Indo Consulting. Kami siap membantu Anda menemukan solusi bisnis terbaik.')

@section('content')



{{-- Contact Main --}}
<section class="py-32 bg-surface">
    <div class="max-w-container mx-auto px-responsive">
        <div class="grid lg:grid-cols-5 gap-12">

            {{-- Left: Info --}}
            <div class="lg:col-span-2 space-y-8 reveal">
                <div>
                    <h2 class="text-headline-md font-outfit font-bold text-primary mb-3">{{ $pageContent['page_heading'] ?? 'Mari Berdiskusi' }}</h2>
                    <p class="text-body-md text-on-surface-variant leading-relaxed">
                        {{ $pageContent['page_description'] ?? '' }}
                    </p>
                </div>

                {{-- Contact Cards --}}
                <div class="space-y-4">
                    @if($pengaturan && $pengaturan->phone)
                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $pengaturan->phone) }}" class="flex items-start gap-4 p-5 bg-surface-container-low rounded-2xl card-hover group soft-shadow">
                        <div class="w-12 h-12 rounded-xl bg-secondary/10 flex items-center justify-center flex-shrink-0 group-hover:bg-secondary/20 transition-colors">
                            <span class="material-symbols-outlined text-secondary text-2xl">call</span>
                        </div>
                        <div>
                            <p class="text-label-md font-outfit font-semibold text-on-surface-variant italic tracking-normal mb-1">Telepon</p>
                            <p class="text-body-md font-outfit font-semibold text-primary">{{ $pengaturan->phone }}</p>
                            <p class="text-label-sm text-on-surface-variant mt-0.5">{{ $pageContent['jam_kerja'] ?? 'Senin - Jumat, 08.00 - 17.00 WIB' }}</p>
                        </div>
                    </a>
                    @endif

                    @if($pengaturan && $pengaturan->email)
                    <a href="mailto:{{ $pengaturan->email }}" class="flex items-start gap-4 p-5 bg-surface-container-low rounded-2xl card-hover group soft-shadow">
                        <div class="w-12 h-12 rounded-xl bg-secondary/10 flex items-center justify-center flex-shrink-0 group-hover:bg-secondary/20 transition-colors">
                            <span class="material-symbols-outlined text-secondary text-2xl">mail</span>
                        </div>
                        <div>
                            <p class="text-label-md font-outfit font-semibold text-on-surface-variant italic tracking-normal mb-1">Email</p>
                            <p class="text-body-md font-outfit font-semibold text-primary">{{ $pengaturan->email }}</p>
                            <p class="text-label-sm text-on-surface-variant mt-0.5">{{ $pageContent['response_time'] ?? 'Respons dalam 1x24 jam kerja' }}</p>
                        </div>
                    </a>
                    @endif

                    @if($pengaturan && $pengaturan->address)
                    <div class="flex items-start gap-4 p-5 bg-surface-container-low rounded-2xl soft-shadow">
                        <div class="w-12 h-12 rounded-xl bg-secondary/10 flex items-center justify-center flex-shrink-0">
                            <span class="material-symbols-outlined text-secondary text-2xl">location_on</span>
                        </div>
                        <div>
                            <p class="text-label-md font-outfit font-semibold text-on-surface-variant italic tracking-normal mb-1">Kantor Pusat</p>
                            <p class="text-body-md font-outfit font-semibold text-primary">{{ $pengaturan->company }}</p>
                            <p class="text-label-sm text-on-surface-variant mt-0.5">{{ $pengaturan->address }}</p>
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Social Media --}}
                <div>
                    <p class="text-label-md font-outfit font-semibold text-on-surface-variant italic tracking-normal mb-4">Ikuti Kami</p>
                    <div class="flex gap-3">
                        @foreach($socialMedia as $sm)
                            @if($sm->url)
                                <a href="{{ $sm->url }}" target="_blank" rel="noopener noreferrer" class="w-11 h-11 rounded-xl bg-surface-container border border-outline-variant/40 flex items-center justify-center text-on-surface-variant hover:bg-secondary hover:text-white hover:border-secondary transition-all duration-200" aria-label="{{ $sm->label }}">
                                    @if($sm->platform === 'instagram')
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
                                    @elseif($sm->platform === 'youtube')
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                                    @elseif($sm->platform === 'whatsapp')
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"/></svg>
                                    @endif
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Right: Google Maps --}}
            <div class="lg:col-span-3 reveal">
                <div class="rounded-2xl overflow-hidden border border-outline-variant/40 soft-shadow" style="height: 520px;">
                    @if($pengaturan && $pengaturan->map)
                        @php
                            $mapUrl = $pengaturan->map;
                            // Auto-extract URL jika admin paste full iframe tag
                            if (str_contains($mapUrl, '<iframe')) {
                                preg_match('/src="([^"]+)"/', $mapUrl, $m);
                                $mapUrl = $m[1] ?? $mapUrl;
                            }
                        @endphp
                        <iframe
                            src="{{ $mapUrl }}"
                            width="100%"
                            height="100%"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            title="Lokasi Indo Consulting - Denpasar, Bali">
                        </iframe>
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-surface-container-low text-on-surface-variant">
                            <p>Google Maps belum dikonfigurasi.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>


{{-- FAQ --}}
<section class="py-block-gap bg-surface">
    <div class="max-w-container mx-auto px-margin-x">
        <div class="max-w-3xl mx-auto">
            <div class="text-center mb-12 reveal">
                <h2 class="text-headline-md font-outfit font-bold text-primary">{{ $pageContent['faq_heading'] ?? 'Pertanyaan yang Sering Diajukan' }}</h2>
            </div>

            <div class="space-y-4" data-stagger>
                @forelse($faqs as $i => $faq)
                <div class="reveal bg-surface-container-low rounded-2xl border border-outline-variant/40 overflow-hidden">
                    <button
                        onclick="toggleFaq({{ $i }})"
                        id="faq-btn-{{ $i }}"
                        class="w-full flex items-center justify-between px-6 py-5 text-left group"
                        aria-expanded="false"
                    >
                        <span class="text-body-md font-outfit font-semibold text-primary pr-4">{{ $faq->question }}</span>
                        <span class="material-symbols-outlined text-on-surface-variant flex-shrink-0 transition-transform duration-300" id="faq-icon-{{ $i }}">expand_more</span>
                    </button>
                    <div id="faq-answer-{{ $i }}" class="hidden px-6 pb-5">
                        <div class="border-t border-outline-variant/30 pt-4">
                            <p class="text-body-md text-on-surface-variant leading-relaxed">{{ $faq->answer }}</p>
                        </div>
                    </div>
                </div>
                @empty
                <p class="text-center text-on-surface-variant py-8">Belum ada FAQ.</p>
                @endforelse
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
function toggleFaq(index) {
    const answer = document.getElementById('faq-answer-' + index);
    const icon   = document.getElementById('faq-icon-' + index);
    const btn    = document.getElementById('faq-btn-' + index);
    const isOpen = !answer.classList.contains('hidden');

    // Close all
    document.querySelectorAll('[id^="faq-answer-"]').forEach(el => el.classList.add('hidden'));
    document.querySelectorAll('[id^="faq-icon-"]').forEach(el => { el.style.transform = ''; el.textContent = 'expand_more'; });
    document.querySelectorAll('[id^="faq-btn-"]').forEach(el => el.setAttribute('aria-expanded', 'false'));

    // Toggle current
    if (!isOpen) {
        answer.classList.remove('hidden');
        icon.style.transform = 'rotate(180deg)';
        icon.textContent = 'expand_less';
        btn.setAttribute('aria-expanded', 'true');
    }
}
</script>
@endpush
