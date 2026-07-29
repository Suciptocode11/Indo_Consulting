@extends('layouts.app')

@section('title', 'Our Expert - Indo Consulting')
@section('description', 'Kenali tim ahli profesional Indo Consulting yang siap membantu bisnis Anda berkembang.')

@section('content')

<div x-data="{ filter: 'all', openModal: false, selectedMember: null }">

{{-- Page Header --}}
<div class="pt-16 lg:pt-18 bg-surface">
    <div class="max-w-container mx-auto px-responsive pt-12 pb-10 border-b border-outline-variant/40">
        <span class="text-label-sm text-secondary font-outfit font-semibold uppercase tracking-widest">{{ $pageContent['page_label'] ?? 'Tim Ahli' }}</span>
        <h1 class="text-3xl md:text-headline-lg font-outfit font-bold text-primary mt-2">{!! $pageContent['page_heading'] ?? 'Our Expert' !!}</h1>
        <p class="text-body-md text-on-surface-variant mt-2 max-w-xl">Para profesional dengan rekam jejak terbukti di bidangnya masing-masing.</p>

        @php
        $expertiseGroups = $members->pluck('jabatan')->filter()->unique()->values();
        @endphp

        <div class="flex flex-wrap gap-3 mt-6">
            <button @click="filter = 'all'" :class="filter === 'all' ? 'bg-secondary text-white shadow-md' : 'bg-white text-on-surface border border-outline-variant/40'" class="px-5 py-2 rounded-full text-label-md font-outfit font-semibold transition-all duration-300 hover:shadow-md hover:scale-105 hover:bg-secondary hover:text-white hover:border-secondary active:scale-95">Semua</button>
            @foreach($expertiseGroups as $group)
            <button @click="filter = '{{ $group }}'" :class="filter === '{{ $group }}' ? 'bg-secondary text-white shadow-md' : 'bg-white text-on-surface border border-outline-variant/40'" class="px-5 py-2 rounded-full text-label-md font-outfit font-semibold transition-all duration-300 hover:shadow-md hover:scale-105 hover:bg-secondary hover:text-white hover:border-secondary active:scale-95">{{ $group }}</button>
            @endforeach
        </div>
    </div>
</div>

{{-- Expert Grid --}}
<section class="py-block-gap bg-surface-container-low">
    <div class="max-w-container mx-auto px-responsive">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($members as $member)
            <div class="reveal bg-white rounded-2xl overflow-hidden border border-outline-variant/60 soft-shadow-md card-hover group flex flex-col" x-show="filter === 'all' || filter === '{{ $member->jabatan ?? '' }}'" x-transition>
                <div class="relative aspect-[4/5] overflow-hidden">
                    @if($member->foto && !str_starts_with($member->foto, 'http'))
                        <img src="{{ asset('storage/' . $member->foto) }}" alt="{{ $member->nama }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @elseif($member->foto)
                        <img src="{{ $member->foto }}" alt="{{ $member->nama }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                        <div class="w-full h-full bg-surface-container flex items-center justify-center">
                            <span class="material-symbols-outlined text-8xl text-on-surface-variant/30">person</span>
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-primary/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </div>
                <div class="p-5 flex flex-col flex-1">
                    @if($member->jabatan)
                        <span class="text-label-xs text-secondary font-outfit font-semibold uppercase tracking-wider mb-1">{{ $member->jabatan }}</span>
                    @endif
                    <h3 class="text-body-lg font-outfit font-bold text-primary">{{ $member->nama }}</h3>
                    @if($member->profil)
                        <p class="text-body-sm text-on-surface-variant/70 leading-relaxed mt-1 line-clamp-2">{{ strip_tags($member->profil) }}</p>
                    @endif
                    @if($member->keahlian)
                        <div class="flex flex-wrap gap-1.5 mt-3">
                            @foreach(array_slice(explode(',', $member->keahlian), 0, 3) as $skill)
                                <span class="bg-surface-container-low text-on-surface-variant text-label-xs font-semibold px-2 py-0.5 rounded-md">{{ trim($skill) }}</span>
                            @endforeach
                        </div>
                    @endif
                    <button @click="openModal = true; selectedMember = {
                        nama: '{{ addslashes($member->nama) }}',
                        jabatan: '{{ addslashes($member->jabatan ?? '') }}',
                        foto: '{{ $member->foto ? (str_starts_with($member->foto, 'http') ? $member->foto : asset('storage/' . $member->foto)) : '' }}',
                        profil: `{!! addslashes($member->profil ?? '') !!}`,
                        keahlian: '{{ addslashes($member->keahlian ?? '') }}'
                    }" class="mt-3 text-secondary text-label-sm font-outfit font-semibold hover:underline cursor-pointer inline-flex items-center gap-1">
                        Lihat Profil <span class="material-symbols-outlined text-base">arrow_forward</span>
                    </button>
                </div>
            </div>
            @empty
            <p class="text-center text-on-surface-variant py-12 col-span-3">Belum ada data expert.</p>
            @endforelse
        </div>
    </div>
</section>

{{-- Modal Profil Lengkap --}}
<div x-show="openModal" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display: none;" @keydown.escape.window="openModal = false">
    <div class="absolute inset-0 bg-primary/40 backdrop-blur-sm" @click="openModal = false"></div>
    <div x-show="openModal" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95 translate-y-4" class="relative bg-white rounded-3xl shadow-2xl max-w-2xl w-full max-h-[85vh] overflow-y-auto">

        {{-- Close Button --}}
        <button @click="openModal = false" class="absolute top-4 right-4 z-10 w-10 h-10 rounded-full bg-white/90 flex items-center justify-center hover:bg-white transition-colors shadow-md">
            <span class="material-symbols-outlined text-lg">close</span>
        </button>

        {{-- Photo --}}
        <div class="relative h-72 overflow-hidden rounded-t-3xl bg-surface-container">
            <template x-if="selectedMember?.foto">
                <img :src="selectedMember.foto" class="w-full h-full object-contain">
            </template>
            <template x-if="!selectedMember?.foto">
                <div class="w-full h-full flex items-center justify-center">
                    <span class="material-symbols-outlined text-on-surface-variant/20" style="font-size: 80px;">person</span>
                </div>
            </template>
            <div class="absolute bottom-0 left-0 right-0 p-6 bg-gradient-to-t from-primary/80 via-primary/20 to-transparent text-white">
                <p x-text="selectedMember?.jabatan" class="text-label-sm font-outfit font-semibold uppercase tracking-wider opacity-80 mb-1"></p>
                <h2 x-text="selectedMember?.nama" class="text-headline-md font-outfit font-bold"></h2>
            </div>
        </div>

        {{-- Info --}}
        <div class="p-6 space-y-5">

            {{-- Profil --}}
            <div>
                <h4 class="text-label-sm font-outfit font-semibold text-on-surface-variant/60 uppercase tracking-wider mb-2">Profil</h4>
                <div x-text="selectedMember?.profil" class="text-body-md text-on-surface-variant leading-relaxed"></div>
            </div>

            {{-- Keahlian --}}
            <template x-if="selectedMember?.keahlian">
                <div>
                    <h4 class="text-label-sm font-outfit font-semibold text-on-surface-variant/60 uppercase tracking-wider mb-2">Keahlian</h4>
                    <div class="flex flex-wrap gap-1.5">
                        <template x-for="skill in (selectedMember?.keahlian || '').split(',')">
                            <span x-show="skill.trim()" x-text="skill.trim()" class="bg-secondary/10 text-secondary text-label-xs font-outfit font-semibold px-2.5 py-1 rounded-lg"></span>
                        </template>
                    </div>
                </div>
            </template>
        </div>
    </div>
</div>

</div>

{{-- Join CTA --}}
<section class="py-20 bg-surface">
    <div class="max-w-container mx-auto px-margin-x">
        <div class="bg-primary rounded-3xl p-10 md:p-12 soft-shadow-md">
            <div class="grid lg:grid-cols-2 gap-10 items-center">
                <div class="reveal">
                    <h2 class="text-headline-md font-outfit font-bold text-white mb-4">{{ $pageContent['cta_heading'] ?? 'Bergabunglah Bersama Tim Kami' }}</h2>
                    <p class="text-body-lg text-white/70 leading-relaxed">{{ $pageContent['cta_description'] ?? 'Kami selalu mencari profesional berbakat yang bersemangat memberikan dampak nyata bagi dunia bisnis Indonesia.' }}</p>
                </div>
                <div class="reveal lg:text-right">
                    <a href="{{ route('pendaftaran.create') }}" class="bg-white text-primary hover:bg-white/90 inline-flex items-center gap-2 px-8 py-4 rounded-full text-label-md font-outfit font-semibold transition-all duration-300 hover:scale-105 active:scale-95 shadow-md">
                        Daftar Sekarang
                        <span class="material-symbols-outlined text-xl">arrow_forward</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
