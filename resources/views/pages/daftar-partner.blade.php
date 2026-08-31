@extends('layouts.app')

@section('title', 'Daftar Partner & Client - Indo Consulting')
@section('description', 'Daftarkan perusahaan Anda sebagai partner atau client Indo Consulting.')

@section('content')

{{-- Hero --}}
<section class="bg-surface-container pt-16 lg:pt-18">
    <div class="max-w-container mx-auto px-responsive py-16 text-center">
        <span class="text-label-sm text-secondary font-outfit font-semibold uppercase tracking-widest">Pendaftaran Partner & Client</span>
        <h1 class="text-3xl md:text-headline-lg font-outfit font-bold text-primary mt-2">Bergabung Sebagai Partner Kami</h1>
        <p class="text-body-lg text-on-surface-variant mt-3 max-w-2xl mx-auto">Daftarkan perusahaan Anda untuk menjadi bagian dari jaringan partner dan client Indo Consulting.</p>
    </div>
</section>

{{-- Form Pendaftaran --}}
<section class="py-16 bg-surface">
    <div class="max-w-3xl mx-auto px-responsive">

        @if(session('success'))
        <div class="bg-green-50 border border-green-200 rounded-xl p-5 mb-8 flex items-center gap-3">
            <span class="material-symbols-outlined text-green-600 text-2xl">check_circle</span>
            <p class="text-body-md text-green-800">{{ session('success') }}</p>
        </div>
        @endif

        @if($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-xl p-5 mb-8">
            <p class="text-body-md text-red-800 font-semibold mb-2">Terjadi kesalahan:</p>
            <ul class="list-disc list-inside text-sm text-red-700">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('partner.store') }}" enctype="multipart/form-data" class="space-y-8">
            @csrf

            {{-- Informasi Perusahaan --}}
            <div class="bg-surface-container-low rounded-2xl p-6 border border-outline-variant/40">
                <h3 class="text-headline-sm font-outfit font-bold text-primary mb-4">Informasi Perusahaan</h3>
                <div class="space-y-5">
                    <div>
                        <label class="block text-label-md font-outfit font-semibold text-on-surface-variant mb-1.5">Nama Perusahaan *</label>
                        <input type="text" name="company_name" value="{{ old('company_name') }}" required class="w-full px-4 py-3 rounded-xl border border-outline-variant/60 bg-white text-body-md focus:outline-none focus:ring-2 focus:ring-secondary/40 focus:border-secondary">
                    </div>
                    <div>
                        <label class="block text-label-md font-outfit font-semibold text-on-surface-variant mb-1.5">Sektor Industri</label>
                        <input type="text" name="sector" value="{{ old('sector') }}" placeholder="Contoh: Teknologi, Manufaktur, Retail" class="w-full px-4 py-3 rounded-xl border border-outline-variant/60 bg-white text-body-md focus:outline-none focus:ring-2 focus:ring-secondary/40 focus:border-secondary">
                    </div>
                    <div>
                        <label class="block text-label-md font-outfit font-semibold text-on-surface-variant mb-1.5">Website</label>
                        <input type="url" name="website" value="{{ old('website') }}" placeholder="https://..." class="w-full px-4 py-3 rounded-xl border border-outline-variant/60 bg-white text-body-md focus:outline-none focus:ring-2 focus:ring-secondary/40 focus:border-secondary">
                    </div>
                    <div>
                        <label class="block text-label-md font-outfit font-semibold text-on-surface-variant mb-1.5">Alamat Perusahaan</label>
                        <textarea name="address" rows="2" class="w-full px-4 py-3 rounded-xl border border-outline-variant/60 bg-white text-body-md focus:outline-none focus:ring-2 focus:ring-secondary/40 focus:border-secondary">{{ old('address') }}</textarea>
                    </div>
                    <div>
                        <label class="block text-label-md font-outfit font-semibold text-on-surface-variant mb-1.5">Logo Perusahaan</label>
                        <input type="file" name="logo" accept="image/*" class="block w-full text-sm text-on-surface-variant file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-secondary file:text-white hover:file:bg-secondary/90 file:cursor-pointer">
                        <p class="text-label-sm text-on-surface-variant/60 mt-1">Format: JPG, PNG, SVG, WebP. Max 2MB.</p>
                    </div>
                </div>
            </div>

            {{-- Person in Charge --}}
            <div class="bg-surface-container-low rounded-2xl p-6 border border-outline-variant/40">
                <h3 class="text-headline-sm font-outfit font-bold text-primary mb-4">Person in Charge (PIC)</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-label-md font-outfit font-semibold text-on-surface-variant mb-1.5">Nama Lengkap *</label>
                        <input type="text" name="pic_name" value="{{ old('pic_name') }}" required class="w-full px-4 py-3 rounded-xl border border-outline-variant/60 bg-white text-body-md focus:outline-none focus:ring-2 focus:ring-secondary/40 focus:border-secondary">
                    </div>
                    <div>
                        <label class="block text-label-md font-outfit font-semibold text-on-surface-variant mb-1.5">Jabatan</label>
                        <input type="text" name="pic_position" value="{{ old('pic_position') }}" placeholder="Contoh: CEO, Marketing Manager" class="w-full px-4 py-3 rounded-xl border border-outline-variant/60 bg-white text-body-md focus:outline-none focus:ring-2 focus:ring-secondary/40 focus:border-secondary">
                    </div>
                    <div>
                        <label class="block text-label-md font-outfit font-semibold text-on-surface-variant mb-1.5">Email *</label>
                        <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-3 rounded-xl border border-outline-variant/60 bg-white text-body-md focus:outline-none focus:ring-2 focus:ring-secondary/40 focus:border-secondary">
                    </div>
                    <div>
                        <label class="block text-label-md font-outfit font-semibold text-on-surface-variant mb-1.5">Telepon / WhatsApp</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" placeholder="+62 8xx-xxxx-xxxx" class="w-full px-4 py-3 rounded-xl border border-outline-variant/60 bg-white text-body-md focus:outline-none focus:ring-2 focus:ring-secondary/40 focus:border-secondary">
                    </div>
                </div>
            </div>

            {{-- Profil & Alasan --}}
            <div class="bg-surface-container-low rounded-2xl p-6 border border-outline-variant/40">
                <h3 class="text-headline-sm font-outfit font-bold text-primary mb-4">Profil & Alasan Bergabung</h3>
                <div class="space-y-5">
                    <div>
                        <label class="block text-label-md font-outfit font-semibold text-on-surface-variant mb-1.5">Profil Singkat Perusahaan</label>
                        <textarea name="company_profile" rows="3" placeholder="Ceritakan tentang perusahaan Anda..." class="w-full px-4 py-3 rounded-xl border border-outline-variant/60 bg-white text-body-md focus:outline-none focus:ring-2 focus:ring-secondary/40 focus:border-secondary">{{ old('company_profile') }}</textarea>
                    </div>
                    <div>
                        <label class="block text-label-md font-outfit font-semibold text-on-surface-variant mb-1.5">Alasan Ingin Bergabung</label>
                        <textarea name="reason" rows="3" placeholder="Mengapa Anda ingin menjadi partner/client Indo Consulting?" class="w-full px-4 py-3 rounded-xl border border-outline-variant/60 bg-white text-body-md focus:outline-none focus:ring-2 focus:ring-secondary/40 focus:border-secondary">{{ old('reason') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Submit --}}
            <div class="text-center">
                <button type="submit" class="bg-secondary hover:bg-secondary/90 text-white px-10 py-4 rounded-full text-label-lg font-outfit font-semibold transition-all duration-300 hover:scale-105 active:scale-95 shadow-md">
                    Kirim Pendaftaran
                </button>
            </div>
        </form>
    </div>
</section>

@endsection
