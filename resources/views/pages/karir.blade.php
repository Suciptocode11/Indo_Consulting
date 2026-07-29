@extends('layouts.app')

@section('title', 'Karir - Indo Consulting')
@section('description', 'Bergabunglah dengan tim profesional Indo Consulting. Kirim lamaran Anda sekarang.')

@section('content')

{{-- Hero --}}
<section class="bg-surface-container pt-16 lg:pt-18">
    <div class="max-w-container mx-auto px-responsive py-16 text-center">
        <span class="text-label-sm text-secondary font-outfit font-semibold uppercase tracking-widest">Karir</span>
        <h1 class="text-3xl md:text-headline-lg font-outfit font-bold text-primary mt-2">Bergabunglah Bersama Tim Kami</h1>
        <p class="text-body-lg text-on-surface-variant mt-3 max-w-2xl mx-auto">Kami selalu mencari profesional berbakat yang bersemangat memberikan dampak nyata bagi dunia bisnis Indonesia. Kirim lamaran Anda sekarang!</p>
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

        <form method="POST" action="{{ route('pendaftaran.store') }}" enctype="multipart/form-data" class="space-y-8">
            @csrf

            {{-- Foto Profil --}}
            <div class="bg-surface-container-low rounded-2xl p-6 border border-outline-variant/40">
                <h3 class="text-headline-sm font-outfit font-bold text-primary mb-4">Foto Profil</h3>
                <div class="flex items-center gap-6">
                    <div id="fotoPreview" class="w-24 h-24 rounded-xl bg-surface-container flex items-center justify-center overflow-hidden border-2 border-dashed border-outline-variant/60">
                        <span class="material-symbols-outlined text-on-surface-variant/30 text-4xl">person</span>
                    </div>
                    <div>
                        <input type="file" name="foto" id="fotoInput" accept="image/*" class="block w-full text-sm text-on-surface-variant file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-secondary file:text-white hover:file:bg-secondary/90 file:cursor-pointer">
                        <p class="text-label-sm text-on-surface-variant/60 mt-1">Format: JPG, PNG, WebP. Max 2MB.</p>
                    </div>
                </div>
            </div>

            {{-- Data Diri --}}
            <div class="bg-surface-container-low rounded-2xl p-6 border border-outline-variant/40">
                <h3 class="text-headline-sm font-outfit font-bold text-primary mb-4">Data Diri</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-label-md font-outfit font-semibold text-on-surface-variant mb-1.5">Nama Lengkap *</label>
                        <input type="text" name="nama" value="{{ old('nama') }}" required class="w-full px-4 py-3 rounded-xl border border-outline-variant/60 bg-white text-body-md focus:outline-none focus:ring-2 focus:ring-secondary/40 focus:border-secondary">
                    </div>
                    <div>
                        <label class="block text-label-md font-outfit font-semibold text-on-surface-variant mb-1.5">Email *</label>
                        <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-3 rounded-xl border border-outline-variant/60 bg-white text-body-md focus:outline-none focus:ring-2 focus:ring-secondary/40 focus:border-secondary">
                    </div>
                    <div>
                        <label class="block text-label-md font-outfit font-semibold text-on-surface-variant mb-1.5">Telepon / WhatsApp</label>
                        <input type="text" name="telepon" value="{{ old('telepon') }}" placeholder="+62 8xx-xxxx-xxxx" class="w-full px-4 py-3 rounded-xl border border-outline-variant/60 bg-white text-body-md focus:outline-none focus:ring-2 focus:ring-secondary/40 focus:border-secondary">
                    </div>
                    <div>
                        <label class="block text-label-md font-outfit font-semibold text-on-surface-variant mb-1.5">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="w-full px-4 py-3 rounded-xl border border-outline-variant/60 bg-white text-body-md focus:outline-none focus:ring-2 focus:ring-secondary/40 focus:border-secondary">
                    </div>
                    <div>
                        <label class="block text-label-md font-outfit font-semibold text-on-surface-variant mb-1.5">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="w-full px-4 py-3 rounded-xl border border-outline-variant/60 bg-white text-body-md focus:outline-none focus:ring-2 focus:ring-secondary/40 focus:border-secondary">
                            <option value="">-- Pilih --</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin') === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin') === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-label-md font-outfit font-semibold text-on-surface-variant mb-1.5">Provinsi</label>
                        <select name="provinsi" id="provinsiSelect" class="w-full px-4 py-3 rounded-xl border border-outline-variant/60 bg-white text-body-md focus:outline-none focus:ring-2 focus:ring-secondary/40 focus:border-secondary">
                            <option value="">-- Pilih Provinsi --</option>
                            <option value="11|Aceh" {{ old('provinsi') === '11|Aceh' ? 'selected' : '' }}>Aceh (11)</option>
                            <option value="12|Sumatera Utara" {{ old('provinsi') === '12|Sumatera Utara' ? 'selected' : '' }}>Sumatera Utara (12)</option>
                            <option value="13|Sumatera Barat" {{ old('provinsi') === '13|Sumatera Barat' ? 'selected' : '' }}>Sumatera Barat (13)</option>
                            <option value="14|Riau" {{ old('provinsi') === '14|Riau' ? 'selected' : '' }}>Riau (14)</option>
                            <option value="15|Jambi" {{ old('provinsi') === '15|Jambi' ? 'selected' : '' }}>Jambi (15)</option>
                            <option value="16|Sumatera Selatan" {{ old('provinsi') === '16|Sumatera Selatan' ? 'selected' : '' }}>Sumatera Selatan (16)</option>
                            <option value="17|Bengkulu" {{ old('provinsi') === '17|Bengkulu' ? 'selected' : '' }}>Bengkulu (17)</option>
                            <option value="18|Lampung" {{ old('provinsi') === '18|Lampung' ? 'selected' : '' }}>Lampung (18)</option>
                            <option value="19|Kep. Bangka Belitung" {{ old('provinsi') === '19|Kep. Bangka Belitung' ? 'selected' : '' }}>Kep. Bangka Belitung (19)</option>
                            <option value="21|Kep. Riau" {{ old('provinsi') === '21|Kep. Riau' ? 'selected' : '' }}>Kep. Riau (21)</option>
                            <option value="31|DKI Jakarta" {{ old('provinsi') === '31|DKI Jakarta' ? 'selected' : '' }}>DKI Jakarta (31)</option>
                            <option value="32|Jawa Barat" {{ old('provinsi') === '32|Jawa Barat' ? 'selected' : '' }}>Jawa Barat (32)</option>
                            <option value="33|Jawa Tengah" {{ old('provinsi') === '33|Jawa Tengah' ? 'selected' : '' }}>Jawa Tengah (33)</option>
                            <option value="34|DI Yogyakarta" {{ old('provinsi') === '34|DI Yogyakarta' ? 'selected' : '' }}>DI Yogyakarta (34)</option>
                            <option value="35|Jawa Timur" {{ old('provinsi') === '35|Jawa Timur' ? 'selected' : '' }}>Jawa Timur (35)</option>
                            <option value="36|Banten" {{ old('provinsi') === '36|Banten' ? 'selected' : '' }}>Banten (36)</option>
                            <option value="51|Bali" {{ old('provinsi') === '51|Bali' ? 'selected' : '' }}>Bali (51)</option>
                            <option value="52|Nusa Tenggara Barat" {{ old('provinsi') === '52|Nusa Tenggara Barat' ? 'selected' : '' }}>Nusa Tenggara Barat (52)</option>
                            <option value="53|Nusa Tenggara Timur" {{ old('provinsi') === '53|Nusa Tenggara Timur' ? 'selected' : '' }}>Nusa Tenggara Timur (53)</option>
                            <option value="61|Kalimantan Barat" {{ old('provinsi') === '61|Kalimantan Barat' ? 'selected' : '' }}>Kalimantan Barat (61)</option>
                            <option value="62|Kalimantan Tengah" {{ old('provinsi') === '62|Kalimantan Tengah' ? 'selected' : '' }}>Kalimantan Tengah (62)</option>
                            <option value="63|Kalimantan Selatan" {{ old('provinsi') === '63|Kalimantan Selatan' ? 'selected' : '' }}>Kalimantan Selatan (63)</option>
                            <option value="64|Kalimantan Timur" {{ old('provinsi') === '64|Kalimantan Timur' ? 'selected' : '' }}>Kalimantan Timur (64)</option>
                            <option value="65|Kalimantan Utara" {{ old('provinsi') === '65|Kalimantan Utara' ? 'selected' : '' }}>Kalimantan Utara (65)</option>
                            <option value="71|Sulawesi Utara" {{ old('provinsi') === '71|Sulawesi Utara' ? 'selected' : '' }}>Sulawesi Utara (71)</option>
                            <option value="72|Sulawesi Tengah" {{ old('provinsi') === '72|Sulawesi Tengah' ? 'selected' : '' }}>Sulawesi Tengah (72)</option>
                            <option value="73|Sulawesi Selatan" {{ old('provinsi') === '73|Sulawesi Selatan' ? 'selected' : '' }}>Sulawesi Selatan (73)</option>
                            <option value="74|Sulawesi Tenggara" {{ old('provinsi') === '74|Sulawesi Tenggara' ? 'selected' : '' }}>Sulawesi Tenggara (74)</option>
                            <option value="75|Gorontalo" {{ old('provinsi') === '75|Gorontalo' ? 'selected' : '' }}>Gorontalo (75)</option>
                            <option value="76|Sulawesi Barat" {{ old('provinsi') === '76|Sulawesi Barat' ? 'selected' : '' }}>Sulawesi Barat (76)</option>
                            <option value="81|Maluku" {{ old('provinsi') === '81|Maluku' ? 'selected' : '' }}>Maluku (81)</option>
                            <option value="82|Maluku Utara" {{ old('provinsi') === '82|Maluku Utara' ? 'selected' : '' }}>Maluku Utara (82)</option>
                            <option value="91|Papua" {{ old('provinsi') === '91|Papua' ? 'selected' : '' }}>Papua (91)</option>
                            <option value="92|Papua Barat" {{ old('provinsi') === '92|Papua Barat' ? 'selected' : '' }}>Papua Barat (92)</option>
                        </select>
                        <input type="hidden" name="kode_provinsi" id="kodeProvinsi" value="{{ old('kode_provinsi') }}">
                    </div>
                    <div>
                        <label class="block text-label-md font-outfit font-semibold text-on-surface-variant mb-1.5">Daerah Asal (Kota/Kabupaten)</label>
                        <input type="text" name="daerah_asal" value="{{ old('daerah_asal') }}" class="w-full px-4 py-3 rounded-xl border border-outline-variant/60 bg-white text-body-md focus:outline-none focus:ring-2 focus:ring-secondary/40 focus:border-secondary">
                    </div>
                </div>
                <div class="mt-5">
                    <label class="block text-label-md font-outfit font-semibold text-on-surface-variant mb-1.5">Alamat Lengkap</label>
                    <textarea name="alamat" rows="2" class="w-full px-4 py-3 rounded-xl border border-outline-variant/60 bg-white text-body-md focus:outline-none focus:ring-2 focus:ring-secondary/40 focus:border-secondary">{{ old('alamat') }}</textarea>
                </div>
            </div>

            {{-- Pendidikan & Pengalaman --}}
            <div class="bg-surface-container-low rounded-2xl p-6 border border-outline-variant/40">
                <h3 class="text-headline-sm font-outfit font-bold text-primary mb-4">Pendidikan & Pengalaman</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-label-md font-outfit font-semibold text-on-surface-variant mb-1.5">Pendidikan Terakhir</label>
                        <select name="pendidikan" class="w-full px-4 py-3 rounded-xl border border-outline-variant/60 bg-white text-body-md focus:outline-none focus:ring-2 focus:ring-secondary/40 focus:border-secondary">
                            <option value="">-- Pilih --</option>
                            <option value="SMA/SMK" {{ old('pendidikan') === 'SMA/SMK' ? 'selected' : '' }}>SMA/SMK</option>
                            <option value="D3" {{ old('pendidikan') === 'D3' ? 'selected' : '' }}>D3</option>
                            <option value="S1" {{ old('pendidikan') === 'S1' ? 'selected' : '' }}>S1</option>
                            <option value="S2" {{ old('pendidikan') === 'S2' ? 'selected' : '' }}>S2</option>
                            <option value="S3" {{ old('pendidikan') === 'S3' ? 'selected' : '' }}>S3</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-label-md font-outfit font-semibold text-on-surface-variant mb-1.5">Institusi</label>
                        <input type="text" name="institusi" value="{{ old('institusi') }}" placeholder="Nama sekolah/universitas" class="w-full px-4 py-3 rounded-xl border border-outline-variant/60 bg-white text-body-md focus:outline-none focus:ring-2 focus:ring-secondary/40 focus:border-secondary">
                    </div>
                    <div>
                        <label class="block text-label-md font-outfit font-semibold text-on-surface-variant mb-1.5">Pengalaman Kerja</label>
                        <select name="pengalaman" class="w-full px-4 py-3 rounded-xl border border-outline-variant/60 bg-white text-body-md focus:outline-none focus:ring-2 focus:ring-secondary/40 focus:border-secondary">
                            <option value="">-- Pilih --</option>
                            <option value="0 tahun (Fresh Graduate)" {{ old('pengalaman') === '0 tahun (Fresh Graduate)' ? 'selected' : '' }}>Fresh Graduate</option>
                            <option value="1-2 tahun" {{ old('pengalaman') === '1-2 tahun' ? 'selected' : '' }}>1-2 Tahun</option>
                            <option value="3-5 tahun" {{ old('pengalaman') === '3-5 tahun' ? 'selected' : '' }}>3-5 Tahun</option>
                            <option value="5-10 tahun" {{ old('pengalaman') === '5-10 tahun' ? 'selected' : '' }}>5-10 Tahun</option>
                            <option value="Lebih dari 10 tahun" {{ old('pengalaman') === 'Lebih dari 10 tahun' ? 'selected' : '' }}>Lebih dari 10 Tahun</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-label-md font-outfit font-semibold text-on-surface-variant mb-1.5">Keahlian</label>
                        <input type="text" name="keahlian" value="{{ old('keahlian') }}" placeholder="Pisahkan dengan koma: HR, Leadership, dll" class="w-full px-4 py-3 rounded-xl border border-outline-variant/60 bg-white text-body-md focus:outline-none focus:ring-2 focus:ring-secondary/40 focus:border-secondary">
                    </div>
                </div>
            </div>

            {{-- Profil Singkat --}}
            <div class="bg-surface-container-low rounded-2xl p-6 border border-outline-variant/40">
                <h3 class="text-headline-sm font-outfit font-bold text-primary mb-4">Profil Singkat</h3>
                <div>
                    <textarea name="profil_singkat" rows="3" placeholder="Ceritakan tentang diri Anda secara singkat..." maxlength="500" class="w-full px-4 py-3 rounded-xl border border-outline-variant/60 bg-white text-body-md focus:outline-none focus:ring-2 focus:ring-secondary/40 focus:border-secondary">{{ old('profil_singkat') }}</textarea>
                    <p class="text-label-sm text-on-surface-variant/60 mt-1">Maksimal 500 karakter. Profil ini akan tampil di halaman Our Expert jika lamaran diterima.</p>
                </div>
            </div>

            {{-- Lamaran --}}
            <div class="bg-surface-container-low rounded-2xl p-6 border border-outline-variant/40">
                <h3 class="text-headline-sm font-outfit font-bold text-primary mb-4">Lamaran</h3>
                <div class="space-y-5">
                    <div>
                        <label class="block text-label-md font-outfit font-semibold text-on-surface-variant mb-1.5">Bidang Konsultasi</label>
                        <select name="posisi" class="w-full px-4 py-3 rounded-xl border border-outline-variant/60 bg-white text-body-md focus:outline-none focus:ring-2 focus:ring-secondary/40 focus:border-secondary">
                            <option value="">-- Pilih Bidang --</option>
                            @foreach($services as $service)
                                @php $konsultan = 'Konsultan ' . $service->title; @endphp
                                <option value="{{ $konsultan }}" {{ old('posisi') === $konsultan ? 'selected' : '' }}>{{ $konsultan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-label-md font-outfit font-semibold text-on-surface-variant mb-1.5">Surat Motivasi</label>
                        <textarea name="surat_motivasi" rows="4" placeholder="Ceritakan motivasi Anda bergabung dengan Indo Consulting..." class="w-full px-4 py-3 rounded-xl border border-outline-variant/60 bg-white text-body-md focus:outline-none focus:ring-2 focus:ring-secondary/40 focus:border-secondary">{{ old('surat_motivasi') }}</textarea>
                    </div>
                    <div>
                        <label class="block text-label-md font-outfit font-semibold text-on-surface-variant mb-1.5">Upload CV (PDF)</label>
                        <input type="file" name="cv" accept=".pdf" class="block w-full text-sm text-on-surface-variant file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-secondary file:text-white hover:file:bg-secondary/90 file:cursor-pointer">
                        <p class="text-label-sm text-on-surface-variant/60 mt-1">Format: PDF. Max 5MB.</p>
                    </div>
                </div>
            </div>

            {{-- Link Sosial Media (Opsional) --}}
            <div class="bg-surface-container-low rounded-2xl p-6 border border-outline-variant/40">
                <h3 class="text-headline-sm font-outfit font-bold text-primary mb-4">Sosial Media (Opsional)</h3>
                <p class="text-label-sm text-on-surface-variant/60 mb-4">Bagikan profil sosial media Anda. Hanya akan terlihat oleh admin.</p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-label-md font-outfit font-semibold text-on-surface-variant mb-1.5">WhatsApp</label>
                        <input type="text" name="link_wa" value="{{ old('link_wa') }}" placeholder="+62 8xx-xxxx-xxxx" class="w-full px-4 py-3 rounded-xl border border-outline-variant/60 bg-white text-body-md focus:outline-none focus:ring-2 focus:ring-secondary/40 focus:border-secondary">
                    </div>
                    <div>
                        <label class="block text-label-md font-outfit font-semibold text-on-surface-variant mb-1.5">LinkedIn</label>
                        <input type="url" name="link_linkedin" value="{{ old('link_linkedin') }}" placeholder="https://linkedin.com/in/..." class="w-full px-4 py-3 rounded-xl border border-outline-variant/60 bg-white text-body-md focus:outline-none focus:ring-2 focus:ring-secondary/40 focus:border-secondary">
                    </div>
                    <div>
                        <label class="block text-label-md font-outfit font-semibold text-on-surface-variant mb-1.5">Instagram</label>
                        <input type="url" name="link_instagram" value="{{ old('link_instagram') }}" placeholder="https://instagram.com/..." class="w-full px-4 py-3 rounded-xl border border-outline-variant/60 bg-white text-body-md focus:outline-none focus:ring-2 focus:ring-secondary/40 focus:border-secondary">
                    </div>
                    <div>
                        <label class="block text-label-md font-outfit font-semibold text-on-surface-variant mb-1.5">Facebook</label>
                        <input type="url" name="link_facebook" value="{{ old('link_facebook') }}" placeholder="https://facebook.com/..." class="w-full px-4 py-3 rounded-xl border border-outline-variant/60 bg-white text-body-md focus:outline-none focus:ring-2 focus:ring-secondary/40 focus:border-secondary">
                    </div>
                </div>
            </div>

            {{-- Submit --}}
            <div class="text-center">
                <button type="submit" class="bg-secondary hover:bg-secondary/90 text-white px-10 py-4 rounded-full text-label-lg font-outfit font-semibold transition-all duration-300 hover:scale-105 active:scale-95 shadow-md">
                    Kirim Lamaran
                </button>
            </div>
        </form>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const provinsiSelect = document.getElementById('provinsiSelect');
    const kodeProvinsi = document.getElementById('kodeProvinsi');

    provinsiSelect.addEventListener('change', function() {
        const val = this.value;
        if (val) {
            const code = val.split('|')[0];
            kodeProvinsi.value = code;
        } else {
            kodeProvinsi.value = '';
        }
    });

    if (provinsiSelect.value) {
        kodeProvinsi.value = provinsiSelect.value.split('|')[0];
    }

    const fotoInput = document.getElementById('fotoInput');
    const fotoPreview = document.getElementById('fotoPreview');

    fotoInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                fotoPreview.innerHTML = '<img src="' + e.target.result + '" class="w-full h-full object-cover">';
            };
            reader.readAsDataURL(file);
        }
    });
});
</script>

@endsection