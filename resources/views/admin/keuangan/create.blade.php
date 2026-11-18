@extends('admin.layouts.app')

@section('title', 'Tambah Transaksi')
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
        <a href="{{ route('admin.keuangan.index') }}" class="btn btn-secondary btn-sm"
           style="display:inline-flex; align-items:center; gap:5px;">
            <span class="material-symbols-outlined" style="font-size:15px;">arrow_back</span> Kembali
        </a>
    </div>

    <div class="form-card">
        <h2 class="form-card-title">Tambah Transaksi</h2>
        <p class="form-card-sub">Isi formulir transaksi keuangan berikut dengan lengkap dan benar.</p>

        <form method="POST" action="{{ route('admin.keuangan.store') }}" enctype="multipart/form-data" id="formTransaksi">
            @csrf

            {{-- 1. PILIH PROGRAM / PROYEK --}}
            <div class="form-group">
                <label>Pilih Program / Proyek Klien</label>
                <select name="proyek_klien_id" id="proyek_klien_id" class="form-control" onchange="onProyekChange(this)">
                    <option value="">— Transaksi Kas Umum (Tanpa Terikat Proyek) —</option>
                    @if(isset($proyekKliens) && $proyekKliens->count() > 0)
                        <optgroup label="Proyek Klien Aktif">
                            @foreach($proyekKliens as $pk)
                                <option value="{{ $pk->id }}" data-service-id="{{ $pk->service_id }}" {{ old('proyek_klien_id') == $pk->id ? 'selected' : '' }}>
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
                        <option value="{{ $svc->id }}" {{ old('service_id') == $svc->id ? 'selected' : '' }}>
                            {{ $svc->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- 2. TANGGAL TRANSAKSI --}}
            <div class="form-group">
                <label>Tanggal Transaksi <span class="req">*</span></label>
                <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', now()->format('Y-m-d')) }}" required>
                @error('tanggal') <div class="error-msg">{{ $message }}</div> @enderror
            </div>

            {{-- 3. TRANSAKSI (RADIO) --}}
            <div class="form-group">
                <label>Transaksi <span class="req">*</span></label>
                <div class="radio-row">
                    <label class="radio-item">
                        <input type="radio" name="tipe" value="pemasukan" {{ old('tipe', 'pemasukan') === 'pemasukan' ? 'checked' : '' }} onchange="onTipeRadioChange(this.value)">
                        <span>Penerimaan (Pemasukan)</span>
                    </label>
                    <label class="radio-item">
                        <input type="radio" name="tipe" value="pengeluaran" {{ old('tipe') === 'pengeluaran' ? 'checked' : '' }} onchange="onTipeRadioChange(this.value)">
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
                            {{ old('kategori_id') == $kat->id ? 'selected' : '' }}>
                            {{ $kat->nama }}
                        </option>
                    @endforeach
                </select>
                @error('kategori_id') <div class="error-msg">{{ $message }}</div> @enderror
            </div>

            {{-- 5. DESKRIPSI --}}
            <div class="form-group">
                <label>Deskripsi <span class="req">*</span></label>
                <input type="text" name="deskripsi" id="deskripsi" class="form-control" value="{{ old('deskripsi', old('judul')) }}"
                       placeholder="Contoh: Pembayaran Termin 1, Honor Tenaga Ahli, Pengadaan ATK Kantor" required autocomplete="off">
                @error('deskripsi') <div class="error-msg">{{ $message }}</div> @enderror
            </div>

            {{-- 6. VOL & SATUAN --}}
            <div class="grid-satuan-volume">
                <div class="form-group">
                    <label>Volume</label>
                    <input type="number" name="volume" id="volumeInput" class="form-control" min="0.01" step="any" value="{{ old('volume', 1) }}" oninput="calculateTotal()">
                    @error('volume') <div class="error-msg">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label>Satuan</label>
                    <div style="display:flex; gap:6px;">
                        <select name="satuan" id="satuanSelect" class="form-control" onchange="checkCustomSatuan(this)">
                            @php
                                $presetSatuans = ['paket', 'sesi', 'peserta', 'orang', 'dokumen', 'hari', 'bulan', 'jam', 'unit', 'eksemplar'];
                                $currentSatuan = old('satuan', 'paket');
                            @endphp
                            @foreach($presetSatuans as $sat)
                                <option value="{{ $sat }}" {{ strtolower($currentSatuan) === $sat ? 'selected' : '' }}>{{ ucfirst($sat) }}</option>
                            @endforeach
                            <option value="__custom__" {{ !in_array(strtolower($currentSatuan), $presetSatuans) && $currentSatuan ? 'selected' : '' }}>Lainnya (Ketik Manual)...</option>
                        </select>
                        <input type="text" id="satuanCustom" class="form-control" style="display:none; max-width:130px;" placeholder="Ketik satuan..." oninput="syncCustomSatuan(this.value)">
                    </div>
                </div>
            </div>

            {{-- 6. HARGA SATUAN (RP) --}}
            <div class="form-group">
                <label>Harga Satuan <span class="req">*</span></label>
                <div class="input-group-rp">
                    <span class="input-group-addon-rp">Rp</span>
                    <input type="text" id="hargaSatuanDisplay" class="input-group-field-rp" placeholder="Contoh: 500.000" autocomplete="off"
                           value="{{ old('harga_satuan') ? number_format(old('harga_satuan'), 0, ',', '.') : '' }}" oninput="onHargaSatuanInput(this)">
                </div>
                <input type="hidden" name="harga_satuan" id="hargaSatuanVal" value="{{ old('harga_satuan', 0) }}">
                @error('harga_satuan') <div class="error-msg">{{ $message }}</div> @enderror
            </div>

            {{-- 7. TOTAL TRANSAKSI (OTOMATIS) --}}
            <div class="total-auto-wrap">
                <div class="total-auto-label">Total Transaksi (Otomatis)</div>
                <div class="total-auto-display" id="totalDisplay">Rp 0</div>
                <input type="hidden" name="nominal" id="nominalVal" value="{{ old('nominal', 0) }}">
                @error('nominal') <div class="error-msg">{{ $message }}</div> @enderror
            </div>

            {{-- Hidden Field Metode & Status (Default Nilai Aman) --}}
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:20px;">
                <div class="form-group" style="margin-bottom:0;">
                    <label>Metode Pembayaran</label>
                    <select name="metode_pembayaran" class="form-control">
                        <option value="Transfer Bank" {{ old('metode_pembayaran', 'Transfer Bank') === 'Transfer Bank' ? 'selected' : '' }}>Transfer Bank</option>
                        <option value="Kas Tunai" {{ old('metode_pembayaran') === 'Kas Tunai' ? 'selected' : '' }}>Kas Tunai</option>
                        <option value="Lainnya" {{ old('metode_pembayaran') === 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>
                <div class="form-group" style="margin-bottom:0;">
                    <label>Status Pembayaran</label>
                    <select name="status" class="form-control">
                        <option value="lunas" {{ old('status', 'lunas') === 'lunas' ? 'selected' : '' }}>Lunas</option>
                        <option value="pending" {{ old('status') === 'pending' || old('status') === 'piutang' ? 'selected' : '' }}>Piutang</option>
                    </select>
                </div>
            </div>

            {{-- 9. BUKTI TRANSAKSI --}}
            <div class="form-group">
                <label>Bukti Transaksi</label>
                @include('admin.keuangan.partials.file-upload', [
                    'name'  => 'bukti',
                    'id'    => 'bukti_transaksi_create',
                    'label' => 'Upload bukti transaksi',
                    'help'  => 'PDF, JPG, PNG (Maksimal 5MB)',
                ])
            </div>

            {{-- Action Buttons --}}
            <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:28px; padding-top:18px; border-top:1px solid #f1f5f9; align-items:center; flex-wrap:wrap;">
                <a href="{{ route('admin.keuangan.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" name="save_and_add" value="1" class="btn btn-secondary" style="background:#fff; border:1px solid #bb0027; color:#bb0027; font-weight:600; display:inline-flex; align-items:center; gap:6px;">
                    <span class="material-symbols-outlined" style="font-size:16px; color:#bb0027;">add_circle</span> Simpan & Tambah
                </button>
                <button type="submit" class="btn btn-primary" style="background:#bb0027; border-color:#bb0027; display:inline-flex; align-items:center; gap:6px;">
                    <span class="material-symbols-outlined" style="font-size:16px;">save</span> Simpan Transaksi
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
    // ── Number Formatting ──────────────────────────────────────
    function formatRibuan(num) {
        if (!num && num !== 0) return '0';
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function cleanNumber(str) {
        if (!str) return 0;
        return parseFloat(str.toString().replace(/\./g, "").replace(/,/g, ".")) || 0;
    }

    // ── Live Calculation ──────────────────────────────────────
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

    // ── Satuan Custom Logic ────────────────────────────────────
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

    // ── Filter Kategori By Tipe ────────────────────────────────
    window.onTipeRadioChange = function(tipe) {
        const wrapPenerima = document.getElementById('wrap_penerima');
        if (wrapPenerima) {
            wrapPenerima.style.display = tipe === 'pengeluaran' ? 'block' : 'none';
        }
        document.getElementById('quickKatTipe').value = tipe;

        const katSelect = document.getElementById('kategori_id');
        const options = katSelect.querySelectorAll('option');
        let hasSelected = false;

        options.forEach(opt => {
            if (!opt.value) return;
            const optTipe = opt.getAttribute('data-tipe');
            if (optTipe === tipe) {
                opt.style.display = '';
                if (!hasSelected) {
                    opt.selected = true;
                    hasSelected = true;
                }
            } else {
                opt.style.display = 'none';
                if (opt.selected) opt.selected = false;
            }
        });
    };

    // ── Proyek Change ──────────────────────────────────────────
    window.onProyekChange = function(sel) {
        const wrapService = document.getElementById('wrap_service');
        if (sel.value) {
            const opt = sel.options[sel.selectedIndex];
            const svcId = opt.getAttribute('data-service-id');
            if (svcId) {
                document.getElementById('service_id').value = svcId;
            }
        }
    };

    // ── Modal Quick Kategori ───────────────────────────────────
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

    // On Load Initial Calculation
    document.addEventListener('DOMContentLoaded', function() {
        const currentTipe = document.querySelector('input[name="tipe"]:checked')?.value || 'pemasukan';
        onTipeRadioChange(currentTipe);
        calculateTotal();
    });

    // Handle Form Submit (clean custom satuan)
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
