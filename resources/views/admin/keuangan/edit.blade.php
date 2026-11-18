@extends('admin.layouts.app')

@section('title', 'Edit Transaksi')
@section('page-title', 'Manajemen Keuangan')

@push('styles')
<style>
    .form-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 28px 32px;
        max-width: 760px;
        margin: 0 auto;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }
    .form-card-title {
        font-size: 18px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 4px;
    }
    .form-card-sub {
        font-size: 13px;
        color: #64748b;
        margin: 0 0 24px;
    }

    .form-group {
        margin-bottom: 20px;
    }
    .form-group label {
        display: block;
        font-size: 12px;
        font-weight: 700;
        color: #334155;
        margin-bottom: 7px;
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }
    .form-group label .req {
        color: #dc2626;
    }

    .form-control {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #cbd5e1;
        border-radius: 9px;
        font-family: 'Outfit', sans-serif;
        font-size: 13px;
        color: #0f172a;
        background: #fff;
        outline: none;
        transition: border-color .15s, box-shadow .15s;
    }
    .form-control:focus {
        border-color: #bb0027;
        box-shadow: 0 0 0 3px rgba(187,0,39,.08);
    }

    /* Input Group Rp Badge */
    .input-group-rp {
        display: flex;
        align-items: stretch;
        width: 100%;
    }
    .input-group-addon-rp {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0 14px;
        background: #f1f5f9;
        color: #475569;
        font-weight: 700;
        font-size: 13px;
        border: 1px solid #cbd5e1;
        border-right: none;
        border-radius: 9px 0 0 9px;
        user-select: none;
        flex-shrink: 0;
    }
    .input-group-field-rp {
        flex: 1;
        border-radius: 0 9px 9px 0 !important;
        border: 1px solid #cbd5e1;
        padding: 10px 14px;
        font-size: 13px;
        font-family: 'Outfit', sans-serif;
        outline: none;
        background: #fff;
        color: #0f172a;
        font-weight: 600;
        transition: border-color .15s, box-shadow .15s;
        width: 100%;
    }
    .input-group-field-rp:focus {
        border-color: #bb0027;
        box-shadow: 0 0 0 3px rgba(187,0,39,.08);
    }

    /* Radio Jenis Transaksi */
    .radio-row {
        display: flex;
        gap: 20px;
        align-items: center;
        padding: 4px 0;
    }
    .radio-item {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 600;
        color: #334155;
        user-select: none;
    }
    .radio-item input[type="radio"] {
        width: 17px;
        height: 17px;
        accent-color: #bb0027;
        cursor: pointer;
    }

    /* Satuan & Volume Linked Grid */
    .grid-satuan-volume {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
    }
    @media (max-width: 600px) {
        .grid-satuan-volume {
            grid-template-columns: 1fr;
        }
    }

    /* Total Otomatis Box */
    .total-auto-wrap {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 14px 18px;
        margin-bottom: 20px;
    }
    .total-auto-label {
        font-size: 11px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }
    .total-auto-display {
        font-size: 22px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.5px;
        font-family: 'Outfit', sans-serif;
    }

    .btn-quick-add {
        font-size: 12px;
        font-weight: 600;
        color: #bb0027;
        background: transparent;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 0;
    }
    .btn-quick-add:hover {
        text-decoration: underline;
    }

    .error-msg {
        font-size: 11px;
        color: #dc2626;
        margin-top: 5px;
    }

    /* Modal Quick Kategori */
    .quick-modal-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(15,23,42,0.5);
        backdrop-filter: blur(2px);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .quick-modal-card {
        background: #fff;
        border-radius: 14px;
        width: 100%;
        max-width: 440px;
        padding: 24px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }
</style>
@endpush

@section('content')
<div style="max-width: 760px; margin: 0 auto;">
    <div style="margin-bottom: 16px;">
        <a href="{{ route('admin.keuangan.show', $keuangan->id) }}" class="btn btn-secondary btn-sm"
           style="display:inline-flex; align-items:center; gap:5px;">
            <span class="material-symbols-outlined" style="font-size:15px;">arrow_back</span> Kembali
        </a>
    </div>

    <div class="form-card">
        <h2 class="form-card-title">Edit Transaksi #{{ $keuangan->kode_transaksi }}</h2>
        <p class="form-card-sub">Perbarui informasi rincian transaksi keuangan ini.</p>

        <form method="POST" action="{{ route('admin.keuangan.update', $keuangan->id) }}" enctype="multipart/form-data" id="formTransaksi">
            @csrf
            @method('PUT')

            {{-- 1. PILIH PROGRAM / PROYEK --}}
            <div class="form-group">
                <label>Pilih Program / Proyek Klien</label>
                <select name="proyek_klien_id" id="proyek_klien_id" class="form-control" onchange="onProyekChange(this)">
                    <option value="">— Transaksi Kas Umum (Tanpa Terikat Proyek) —</option>
                    @if(isset($proyekKliens) && $proyekKliens->count() > 0)
                        <optgroup label="Proyek Klien Aktif">
                            @foreach($proyekKliens as $pk)
                                <option value="{{ $pk->id }}" data-service-id="{{ $pk->service_id }}" {{ old('proyek_klien_id', $keuangan->proyek_klien_id) == $pk->id ? 'selected' : '' }}>
                                    {{ $pk->nama_proyek }} (Klien: {{ $pk->nama_klien }})
                                </option>
                            @endforeach
                        </optgroup>
                    @endif
                </select>
            </div>

            {{-- Service Terkait (Hidden / Auto-synced) --}}
            <div class="form-group" id="wrap_service" style="display:none;">
                <label>Program Layanan Terkait</label>
                <select name="service_id" id="service_id" class="form-control">
                    <option value="">— Pilih Layanan Indo Consulting —</option>
                    @foreach($services as $svc)
                        <option value="{{ $svc->id }}" {{ old('service_id', $keuangan->service_id) == $svc->id ? 'selected' : '' }}>
                            {{ $svc->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- 2. TANGGAL TRANSAKSI --}}
            <div class="form-group">
                <label>Tanggal Transaksi <span class="req">*</span></label>
                <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', $keuangan->tanggal->format('Y-m-d')) }}" required>
                @error('tanggal') <div class="error-msg">{{ $message }}</div> @enderror
            </div>

            {{-- 3. TRANSAKSI (RADIO) --}}
            @php $currentTipe = old('tipe', $keuangan->tipe); @endphp
            <div class="form-group">
                <label>Transaksi <span class="req">*</span></label>
                <div class="radio-row">
                    <label class="radio-item">
                        <input type="radio" name="tipe" value="pemasukan" {{ $currentTipe === 'pemasukan' ? 'checked' : '' }} onchange="onTipeRadioChange(this.value)">
                        <span>Penerimaan (Pemasukan)</span>
                    </label>
                    <label class="radio-item">
                        <input type="radio" name="tipe" value="pengeluaran" {{ $currentTipe === 'pengeluaran' ? 'checked' : '' }} onchange="onTipeRadioChange(this.value)">
                        <span>Pengeluaran</span>
                    </label>
                </div>
                @error('tipe') <div class="error-msg">{{ $message }}</div> @enderror
            </div>

            {{-- 4. KATEGORI --}}
            <div class="form-group">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:7px;">
                    <label style="margin-bottom:0;">Kategori <span class="req">*</span></label>
                    <button type="button" class="btn-quick-add" onclick="openQuickKatModal()">
                        <span class="material-symbols-outlined" style="font-size:15px;">add_circle</span> Tambah Kategori
                    </button>
                </div>
                <select name="kategori_id" id="kategori_id" class="form-control" required>
                    <option value="">Pilih kategori</option>
                    @foreach($kategoris as $kat)
                        <option value="{{ $kat->id }}" data-tipe="{{ $kat->tipe }}"
                            {{ old('kategori_id', $keuangan->kategori_id) == $kat->id ? 'selected' : '' }}>
                            {{ $kat->nama }}
                        </option>
                    @endforeach
                </select>
                @error('kategori_id') <div class="error-msg">{{ $message }}</div> @enderror
            </div>

            {{-- 5. DESKRIPSI --}}
            <div class="form-group">
                <label>Deskripsi <span class="req">*</span></label>
                <input type="text" name="deskripsi" id="deskripsi" class="form-control"
                       value="{{ old('deskripsi', $keuangan->deskripsi ?: $keuangan->judul) }}"
                       placeholder="Contoh: Pembayaran Termin 1, Honor Tenaga Ahli, Pengadaan ATK Kantor" required autocomplete="off">
                @error('deskripsi') <div class="error-msg">{{ $message }}</div> @enderror
            </div>

            {{-- 6. VOL & SATUAN --}}
            @php
                $presetSatuans = ['paket', 'sesi', 'peserta', 'orang', 'dokumen', 'hari', 'bulan', 'jam', 'unit', 'eksemplar'];
                $valSatuan = old('satuan', $keuangan->satuan ?? 'paket');
                $isCustomSatuan = !in_array(strtolower($valSatuan), $presetSatuans) && $valSatuan;
                $valHargaSatuan = old('harga_satuan', $keuangan->harga_satuan ?? ($keuangan->volume > 0 ? $keuangan->nominal / $keuangan->volume : $keuangan->nominal));
            @endphp
            <div class="grid-satuan-volume">
                <div class="form-group">
                    <label>Volume</label>
                    <input type="number" name="volume" id="volumeInput" class="form-control" min="0.01" step="any"
                           value="{{ old('volume', $keuangan->volume ?? 1) }}" oninput="calculateTotal()">
                    @error('volume') <div class="error-msg">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label>Satuan</label>
                    <div style="display:flex; gap:6px;">
                        <select name="satuan" id="satuanSelect" class="form-control" onchange="checkCustomSatuan(this)">
                            @foreach($presetSatuans as $sat)
                                <option value="{{ $sat }}" {{ strtolower($valSatuan) === $sat ? 'selected' : '' }}>{{ ucfirst($sat) }}</option>
                            @endforeach
                            <option value="__custom__" {{ $isCustomSatuan ? 'selected' : '' }}>
                                {{ $isCustomSatuan ? $valSatuan : 'Lainnya (Ketik Manual)...' }}
                            </option>
                        </select>
                        <input type="text" id="satuanCustom" class="form-control" style="display:{{ $isCustomSatuan ? 'block' : 'none' }}; max-width:130px;"
                               value="{{ $isCustomSatuan ? $valSatuan : '' }}" placeholder="Ketik satuan..." oninput="syncCustomSatuan(this.value)">
                    </div>
                </div>
            </div>

            {{-- 6. HARGA SATUAN (RP) --}}
            <div class="form-group">
                <label>Harga Satuan <span class="req">*</span></label>
                <div class="input-group-rp">
                    <span class="input-group-addon-rp">Rp</span>
                    <input type="text" id="hargaSatuanDisplay" class="input-group-field-rp" placeholder="Contoh: 500.000" autocomplete="off"
                           value="{{ $valHargaSatuan ? number_format($valHargaSatuan, 0, ',', '.') : '' }}" oninput="onHargaSatuanInput(this)">
                </div>
                <input type="hidden" name="harga_satuan" id="hargaSatuanVal" value="{{ $valHargaSatuan ?? 0 }}">
                @error('harga_satuan') <div class="error-msg">{{ $message }}</div> @enderror
            </div>

            {{-- 7. TOTAL TRANSAKSI (OTOMATIS) --}}
            <div class="total-auto-wrap">
                <div class="total-auto-label">Total Transaksi (Otomatis)</div>
                <div class="total-auto-display" id="totalDisplay">Rp {{ number_format($keuangan->nominal, 0, ',', '.') }}</div>
                <input type="hidden" name="nominal" id="nominalVal" value="{{ old('nominal', $keuangan->nominal) }}">
                @error('nominal') <div class="error-msg">{{ $message }}</div> @enderror
            </div>

            {{-- Hidden Field Metode & Status (Default Nilai Aman) --}}
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:20px;">
                <div class="form-group" style="margin-bottom:0;">
                    <label>Metode Pembayaran</label>
                    <select name="metode_pembayaran" class="form-control">
                        @foreach(['Transfer Bank', 'Kas Tunai', 'Lainnya'] as $mp)
                            <option value="{{ $mp }}" {{ old('metode_pembayaran', $keuangan->metode_pembayaran) === $mp ? 'selected' : '' }}>{{ $mp }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group" style="margin-bottom:0;">
                    <label>Status Pembayaran</label>
                    <select name="status" class="form-control">
                        <option value="lunas" {{ old('status', $keuangan->status) === 'lunas' ? 'selected' : '' }}>Lunas</option>
                        <option value="pending" {{ old('status', $keuangan->status) === 'pending' ? 'selected' : '' }}>Piutang</option>
                    </select>
                </div>
            </div>

            {{-- 9. BUKTI TRANSAKSI --}}
            <div class="form-group">
                <label>Bukti Transaksi</label>
                @if($keuangan->bukti)
                    <div style="margin-bottom:10px; font-size:12px; color:#475569; display:flex; align-items:center; gap:8px;">
                        <span class="material-symbols-outlined" style="font-size:18px; color:#16a34a;">check_circle</span>
                        <span>File bukti tersimpan: </span>
                        <a href="{{ asset('storage/' . $keuangan->bukti) }}" target="_blank" style="color:#bb0027; font-weight:600;">Lihat Bukti</a>
                    </div>
                @endif
                @include('admin.keuangan.partials.file-upload', [
                    'name'  => 'bukti',
                    'id'    => 'bukti_transaksi_edit',
                    'label' => 'Upload bukti baru (opsional)',
                    'help'  => 'PDF, JPG, PNG (Maksimal 5MB). Kosongkan jika tidak ingin mengubah.',
                ])
            </div>

            {{-- Action Buttons --}}
            <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:28px; padding-top:18px; border-top:1px solid #f1f5f9;">
                <a href="{{ route('admin.keuangan.show', $keuangan->id) }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary" style="background:#bb0027; border-color:#bb0027;">
                    <span class="material-symbols-outlined" style="font-size:16px;">save</span> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Quick Kategori --}}
<div id="quickKatModal" class="quick-modal-backdrop" style="display: none;">
    <div class="quick-modal-card">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
            <h3 style="font-size:16px; font-weight:700; color:#0f172a; margin:0;">Tambah Kategori Baru</h3>
            <button type="button" onclick="closeQuickKatModal()" style="background:none; border:none; font-size:22px; color:#94a3b8; cursor:pointer;">&times;</button>
        </div>
        <form id="quickKatForm" onsubmit="submitQuickKat(event)">
            <input type="hidden" id="quickKatTipe" value="pemasukan">
            <div class="form-group">
                <label>Nama Kategori *</label>
                <input type="text" id="quickKatNama" class="form-control" placeholder="Contoh: Honor Narasumber / Konsultasi" required>
                <div id="quickKatError" class="error-msg" style="display:none;"></div>
            </div>
            <div class="form-group">
                <label>Deskripsi (Opsional)</label>
                <input type="text" id="quickKatKet" class="form-control" placeholder="Catatan singkat kategori">
            </div>
            <div style="display:flex; justify-content:flex-end; gap:8px; margin-top:20px;">
                <button type="button" class="btn btn-secondary btn-sm" onclick="closeQuickKatModal()">Batal</button>
                <button type="submit" class="btn btn-primary btn-sm" id="quickKatSubmitBtn">Simpan Kategori</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
(function() {
    function formatRibuan(num) {
        if (!num && num !== 0) return '0';
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function cleanNumber(str) {
        if (!str) return 0;
        return parseFloat(str.toString().replace(/\./g, "").replace(/,/g, ".")) || 0;
    }

    window.calculateTotal = function() {
        const vol = parseFloat(document.getElementById('volumeInput').value) || 0;
        const harga = cleanNumber(document.getElementById('hargaSatuanVal').value);
        const total = Math.round(vol * harga);

        document.getElementById('totalDisplay').textContent = 'Rp ' + formatRibuan(total);
        document.getElementById('nominalVal').value = total;
    };

    window.onHargaSatuanInput = function(input) {
        let raw = input.value.replace(/\D/g, "");
        document.getElementById('hargaSatuanVal').value = raw || 0;
        input.value = raw ? formatRibuan(raw) : "";
        calculateTotal();
    };

    window.checkCustomSatuan = function(sel) {
        const customInput = document.getElementById('satuanCustom');
        if (sel.value === '__custom__') {
            customInput.style.display = 'block';
            customInput.focus();
        } else {
            customInput.style.display = 'none';
        }
    };

    window.syncCustomSatuan = function(val) {
        const sel = document.getElementById('satuanSelect');
        const customOption = sel.querySelector('option[value="__custom__"]');
        if (customOption) {
            customOption.text = val ? val : 'Lainnya (Ketik Manual)...';
        }
    };

    window.onTipeRadioChange = function(tipe) {
        const wrapPenerima = document.getElementById('wrap_penerima');
        if (wrapPenerima) {
            wrapPenerima.style.display = tipe === 'pengeluaran' ? 'block' : 'none';
        }
        document.getElementById('quickKatTipe').value = tipe;

        const katSelect = document.getElementById('kategori_id');
        const options = katSelect.querySelectorAll('option');

        options.forEach(opt => {
            if (!opt.value) return;
            const optTipe = opt.getAttribute('data-tipe');
            if (optTipe === tipe) {
                opt.style.display = '';
            } else {
                opt.style.display = 'none';
                if (opt.selected) opt.selected = false;
            }
        });
    };

    window.onProyekChange = function(sel) {
        if (sel.value) {
            const opt = sel.options[sel.selectedIndex];
            const svcId = opt.getAttribute('data-service-id');
            if (svcId) {
                document.getElementById('service_id').value = svcId;
            }
        }
    };

    window.openQuickKatModal = function() {
        const tipe = document.querySelector('input[name="tipe"]:checked')?.value || 'pemasukan';
        document.getElementById('quickKatTipe').value = tipe;
        document.getElementById('quickKatNama').value = '';
        document.getElementById('quickKatKet').value = '';
        document.getElementById('quickKatError').style.display = 'none';
        document.getElementById('quickKatModal').style.display = 'flex';
    };

    window.closeQuickKatModal = function() {
        document.getElementById('quickKatModal').style.display = 'none';
    };

    window.submitQuickKat = function(e) {
        e.preventDefault();
        const nama = document.getElementById('quickKatNama').value.trim();
        const ket = document.getElementById('quickKatKet').value.trim();
        const tipe = document.getElementById('quickKatTipe').value;
        const errEl = document.getElementById('quickKatError');

        if (!nama) return;

        fetch('{{ route("admin.keuangan.kategori.quick-store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ nama: nama, tipe: tipe, keterangan: ket })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const katSelect = document.getElementById('kategori_id');
                const newOpt = document.createElement('option');
                newOpt.value = data.kategori.id;
                newOpt.textContent = data.kategori.nama;
                newOpt.setAttribute('data-tipe', data.kategori.tipe);
                newOpt.selected = true;
                katSelect.appendChild(newOpt);
                closeQuickKatModal();
            } else {
                errEl.textContent = data.message || 'Gagal menyimpan kategori';
                errEl.style.display = 'block';
            }
        })
        .catch(() => {
            errEl.textContent = 'Terjadi kesalahan sistem';
            errEl.style.display = 'block';
        });
    };

    document.addEventListener('DOMContentLoaded', function() {
        const currentTipe = document.querySelector('input[name="tipe"]:checked')?.value || 'pemasukan';
        onTipeRadioChange(currentTipe);
    });

    document.getElementById('formTransaksi')?.addEventListener('submit', function() {
        const sel = document.getElementById('satuanSelect');
        const customInput = document.getElementById('satuanCustom');
        if (sel.value === '__custom__' && customInput.value) {
            sel.options[sel.selectedIndex].value = customInput.value;
        }
    });
})();
</script>
@endpush
