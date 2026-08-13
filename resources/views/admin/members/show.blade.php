@extends('admin.layouts.app')

@section('title', 'Kartu Anggota - ' . $member->nama)
@section('page-title', 'Kartu Anggota: ' . $member->nama)

@section('content')
<a href="{{ route('admin.members.index') }}" style="display: inline-flex; align-items: center; gap: 4px; font-size: 13px; color: #64748b; text-decoration: none; margin-bottom: 16px;">
    <span class="material-symbols-outlined" style="font-size: 18px;">arrow_back</span> Kembali ke Expert/Team
</a>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">

    {{-- Data Anggota --}}
    <div class="card">
        <h3 style="font-size: 14px; font-weight: 600; color: #64748b; margin-bottom: 16px; text-transform: uppercase; letter-spacing: 0.5px;">Data Anggota</h3>

        <div style="display: flex; gap: 20px; margin-bottom: 20px;">
            <div>
                @if($member->foto && !str_starts_with($member->foto, 'http'))
                    <img src="{{ asset('storage/' . $member->foto) }}" style="width: 100px; height: 100px; border-radius: 12px; object-fit: cover;">
                @elseif($member->foto)
                    <img src="{{ $member->foto }}" style="width: 100px; height: 100px; border-radius: 12px; object-fit: cover;">
                @else
                    <div style="width: 100px; height: 100px; border-radius: 12px; background: #f1f5f9; display: flex; align-items: center; justify-content: center;">
                        <span class="material-symbols-outlined" style="font-size: 40px; color: #94a3b8;">person</span>
                    </div>
                @endif
            </div>
            <div>
                <p style="font-size: 18px; font-weight: 700; color: #0f172a; margin: 0 0 4px;">{{ $member->nama }}</p>
                <p style="font-size: 13px; color: #64748b; margin: 0 0 8px;">{{ $member->jabatan ?? '-' }}</p>
                @if($member->no_anggota)
                    <span style="font-family: 'Courier New', monospace; font-size: 14px; font-weight: 700; background: #f0fdf4; color: #16a34a; padding: 4px 10px; border-radius: 6px; border: 1px solid #bbf7d0;">{{ $member->no_anggota }}</span>
                @endif
            </div>
        </div>

        <table style="width: 100%; border-collapse: collapse;">
            <tr><td style="padding: 6px 0; font-size: 13px; color: #64748b; width: 120px;">Email</td><td style="padding: 6px 0; font-size: 13px; color: #0f172a;">{{ $member->email ?? '-' }}</td></tr>
            <tr><td style="padding: 6px 0; font-size: 13px; color: #64748b;">Telepon</td><td style="padding: 6px 0; font-size: 13px; color: #0f172a;">{{ $member->wa ?? '-' }}</td></tr>
            <tr><td style="padding: 6px 0; font-size: 13px; color: #64748b;">Alamat</td><td style="padding: 6px 0; font-size: 13px; color: #0f172a;">{{ $member->alamat ?? '-' }}</td></tr>
            <tr><td style="padding: 6px 0; font-size: 13px; color: #64748b;">Pendidikan</td><td style="padding: 6px 0; font-size: 13px; color: #0f172a;">{{ $member->pendidikan ?? '-' }}</td></tr>
            <tr><td style="padding: 6px 0; font-size: 13px; color: #64748b;">Pengalaman</td><td style="padding: 6px 0; font-size: 13px; color: #0f172a;">{{ $member->pengalaman ?? '-' }}</td></tr>
            <tr><td style="padding: 6px 0; font-size: 13px; color: #64748b;">Keahlian</td><td style="padding: 6px 0; font-size: 13px; color: #0f172a;">{{ $member->keahlian ?? '-' }}</td></tr>
            <tr><td style="padding: 6px 0; font-size: 13px; color: #64748b;">Status</td><td style="padding: 6px 0;"><span class="badge {{ $member->status === 'Show' ? 'badge-success' : 'badge-danger' }}">{{ $member->status }}</span></td></tr>
        </table>

        <div style="margin-top: 16px; display: flex; gap: 8px;">
            <a href="{{ route('admin.members.edit', $member) }}" class="btn btn-secondary btn-sm" style="display: inline-flex; align-items: center; gap: 6px;">
                <span class="material-symbols-outlined">edit</span> Edit Data
            </a>
        </div>
    </div>

    {{-- Kartu Anggota --}}
    @if($member->no_anggota)
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
            <h3 style="font-size: 14px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Kartu Anggota</h3>
            <button onclick="window.print()" class="btn btn-secondary btn-sm" style="display: inline-flex; align-items: center; gap: 6px;">
                <span class="material-symbols-outlined">print</span> Cetak
            </button>
        </div>
        <div id="memberCard" style="max-width: 400px; margin: 0 auto; background: linear-gradient(135deg, #020220 0%, #010110 100%); border-radius: 20px; padding: 28px; color: white; box-shadow: 0 8px 32px rgba(0,0,0,0.15);">
            <div style="text-align: center; border-bottom: 1px solid rgba(255,255,255,0.15); padding-bottom: 14px; margin-bottom: 14px;">
                @if($pengaturan && $pengaturan->logo)
                    <img src="{{ asset('storage/' . $pengaturan->logo) }}" alt="Logo" style="height: 40px; width: auto; margin: 0 auto; display: block; filter: brightness(0) invert(1);">
                @else
                    <h2 style="font-family: 'Outfit', sans-serif; font-size: 20px; font-weight: 800; margin: 0; letter-spacing: 1px;">INDO CONSULTING</h2>
                @endif
                <p style="font-size: 10px; color: rgba(255,255,255,0.6); text-transform: uppercase; letter-spacing: 2px; margin: 4px 0 0;">Kartu Anggota</p>
            </div>
            <div style="display: flex; gap: 16px; align-items: start;">
                <div style="flex-shrink: 0;">
                    @if($member->foto && !str_starts_with($member->foto, 'http'))
                        <img src="{{ asset('storage/' . $member->foto) }}" style="width: 75px; height: 75px; border-radius: 12px; object-fit: cover; border: 2px solid rgba(255,255,255,0.2);">
                    @elseif($member->foto)
                        <img src="{{ $member->foto }}" style="width: 75px; height: 75px; border-radius: 12px; object-fit: cover; border: 2px solid rgba(255,255,255,0.2);">
                    @else
                        <div style="width: 75px; height: 75px; border-radius: 12px; background: rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: center; border: 2px solid rgba(255,255,255,0.2);">
                            <span class="material-symbols-outlined" style="font-size: 32px; color: rgba(255,255,255,0.4);">person</span>
                        </div>
                    @endif
                </div>
                <div style="flex: 1;">
                    <p style="font-family: 'Outfit', sans-serif; font-size: 15px; font-weight: 700; margin: 0 0 2px;">{{ $member->nama }}</p>
                    <p style="font-size: 11px; color: rgba(255,255,255,0.6); margin: 0 0 8px;">{{ $member->jabatan ?? '' }}</p>
                    <div style="background: rgba(255,255,255,0.1); border-radius: 8px; padding: 8px 12px;">
                        <p style="font-size: 9px; color: rgba(255,255,255,0.5); margin: 0 0 2px; text-transform: uppercase;">No. Anggota</p>
                        <p style="font-family: 'Courier New', monospace; font-size: 17px; font-weight: 700; margin: 0; letter-spacing: 1px;">{{ $member->no_anggota }}</p>
                    </div>
                </div>
            </div>
            <div style="border-top: 1px solid rgba(255,255,255,0.15); padding-top: 10px; margin-top: 14px; text-align: center;">
                @if($member->tanggal_anggota)
                    @php $berlakuSampai = \Carbon\Carbon::parse($member->tanggal_anggota)->addYear(); @endphp
                    <p style="font-size: 10px; color: rgba(255,255,255,0.5); margin: 0; letter-spacing: 1px;">
                        BERLAKU {{ \Carbon\Carbon::parse($member->tanggal_anggota)->format('d/m/Y') }} — {{ $berlakuSampai->format('d/m/Y') }}
                    </p>
                @else
                    <p style="font-size: 10px; color: rgba(255,255,255,0.5); margin: 0; letter-spacing: 1px;">BERLAKU SEUMUR HIDUP</p>
                @endif
            </div>
        </div>
    </div>
    @else
    <div class="card" style="text-align: center; display: flex; flex-direction: column; align-items: center; justify-content: center;">
        <span class="material-symbols-outlined" style="font-size: 48px; color: #cbd5e1; margin-bottom: 12px;">badge</span>
        <p style="font-size: 14px; color: #94a3b8;">Belum ada nomor anggota</p>
        <p style="font-size: 12px; color: #cbd5e1;">Anggota ini tidak berasal dari pendaftaran online</p>
    </div>
    @endif
</div>

<style type="text/css" media="print">
    body * { visibility: hidden; }
    #memberCard, #memberCard * { visibility: visible; }
    #memberCard { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); margin: 0; }
</style>
@endsection
