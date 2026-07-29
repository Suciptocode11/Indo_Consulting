@extends('admin.layouts.app')

@section('title', 'Detail Pendaftaran - ' . $pendaftaran->nama)
@section('page-title', 'Detail Pendaftaran: ' . $pendaftaran->nama)

@section('content')
<a href="{{ route('admin.pendaftaran.index') }}" style="display: inline-flex; align-items: center; gap: 4px; font-size: 13px; color: #64748b; text-decoration: none; margin-bottom: 16px;">
    <span class="material-symbols-outlined" style="font-size: 18px;">arrow_back</span> Kembali
</a>

@if(session('success'))
<div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 10px; padding: 14px 18px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
    <span class="material-symbols-outlined" style="color: #16a34a;">check_circle</span>
    <span style="font-size: 14px; color: #166534;">{{ session('success') }}</span>
</div>
@endif

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">

    {{-- Data Pribadi --}}
    <div class="card">
        <h3 style="font-size: 14px; font-weight: 600; color: #64748b; margin-bottom: 16px; text-transform: uppercase; letter-spacing: 0.5px;">Data Pribadi</h3>

        <div style="display: flex; gap: 20px; margin-bottom: 20px;">
            <div>
                @if($pendaftaran->foto)
                    <img src="{{ asset('storage/' . $pendaftaran->foto) }}" style="width: 100px; height: 100px; border-radius: 12px; object-fit: cover;">
                @else
                    <div style="width: 100px; height: 100px; border-radius: 12px; background: #f1f5f9; display: flex; align-items: center; justify-content: center;">
                        <span class="material-symbols-outlined" style="font-size: 40px; color: #94a3b8;">person</span>
                    </div>
                @endif
            </div>
            <div>
                <p style="font-size: 18px; font-weight: 700; color: #0f172a; margin: 0 0 4px;">{{ $pendaftaran->nama }}</p>
                <p style="font-size: 13px; color: #64748b; margin: 0;">{{ $pendaftaran->posisi ?? '-' }}</p>
            </div>
        </div>

        <table style="width: 100%; border-collapse: collapse;">
            <tr><td style="padding: 6px 0; font-size: 13px; color: #64748b; width: 130px;">Email</td><td style="padding: 6px 0; font-size: 13px; color: #0f172a;">{{ $pendaftaran->email }}</td></tr>
            <tr><td style="padding: 6px 0; font-size: 13px; color: #64748b;">Telepon</td><td style="padding: 6px 0; font-size: 13px; color: #0f172a;">{{ $pendaftaran->telepon ?? '-' }}</td></tr>
            <tr><td style="padding: 6px 0; font-size: 13px; color: #64748b;">Tanggal Lahir</td><td style="padding: 6px 0; font-size: 13px; color: #0f172a;">{{ $pendaftaran->tanggal_lahir ? $pendaftaran->tanggal_lahir->format('d/m/Y') : '-' }}</td></tr>
            <tr><td style="padding: 6px 0; font-size: 13px; color: #64748b;">Jenis Kelamin</td><td style="padding: 6px 0; font-size: 13px; color: #0f172a;">{{ $pendaftaran->jenis_kelamin ?? '-' }}</td></tr>
            <tr><td style="padding: 6px 0; font-size: 13px; color: #64748b;">Provinsi</td><td style="padding: 6px 0; font-size: 13px; color: #0f172a;">{{ $pendaftaran->provinsi ?? '-' }} ({{ $pendaftaran->kode_provinsi ?? '-' }})</td></tr>
            <tr><td style="padding: 6px 0; font-size: 13px; color: #64748b;">Daerah Asal</td><td style="padding: 6px 0; font-size: 13px; color: #0f172a;">{{ $pendaftaran->daerah_asal ?? '-' }}</td></tr>
            <tr><td style="padding: 6px 0; font-size: 13px; color: #64748b;">Alamat</td><td style="padding: 6px 0; font-size: 13px; color: #0f172a;">{{ $pendaftaran->alamat ?? '-' }}</td></tr>
            @if($pendaftaran->profil_singkat)
            <tr><td style="padding: 6px 0; font-size: 13px; color: #64748b; vertical-align: top;">Profil Singkat</td><td style="padding: 6px 0; font-size: 13px; color: #0f172a;">{{ $pendaftaran->profil_singkat }}</td></tr>
            @endif
            @if($pendaftaran->link_wa)
            <tr><td style="padding: 6px 0; font-size: 13px; color: #64748b;">WhatsApp</td><td style="padding: 6px 0; font-size: 13px; color: #0f172a;"><a href="{{ $pendaftaran->link_wa }}" target="_blank" style="color: #2563eb;">{{ $pendaftaran->link_wa }}</a></td></tr>
            @endif
            @if($pendaftaran->link_linkedin)
            <tr><td style="padding: 6px 0; font-size: 13px; color: #64748b;">LinkedIn</td><td style="padding: 6px 0; font-size: 13px; color: #0f172a;"><a href="{{ $pendaftaran->link_linkedin }}" target="_blank" style="color: #2563eb;">{{ $pendaftaran->link_linkedin }}</a></td></tr>
            @endif
            @if($pendaftaran->link_instagram)
            <tr><td style="padding: 6px 0; font-size: 13px; color: #64748b;">Instagram</td><td style="padding: 6px 0; font-size: 13px; color: #0f172a;"><a href="{{ $pendaftaran->link_instagram }}" target="_blank" style="color: #2563eb;">{{ $pendaftaran->link_instagram }}</a></td></tr>
            @endif
            @if($pendaftaran->link_facebook)
            <tr><td style="padding: 6px 0; font-size: 13px; color: #64748b;">Facebook</td><td style="padding: 6px 0; font-size: 13px; color: #0f172a;"><a href="{{ $pendaftaran->link_facebook }}" target="_blank" style="color: #2563eb;">{{ $pendaftaran->link_facebook }}</a></td></tr>
            @endif
        </table>
    </div>

    {{-- Pendidikan & Lamaran --}}
    <div class="card">
        <h3 style="font-size: 14px; font-weight: 600; color: #64748b; margin-bottom: 16px; text-transform: uppercase; letter-spacing: 0.5px;">Pendidikan & Lamaran</h3>
        <table style="width: 100%; border-collapse: collapse;">
            <tr><td style="padding: 6px 0; font-size: 13px; color: #64748b; width: 130px;">Pendidikan</td><td style="padding: 6px 0; font-size: 13px; color: #0f172a;">{{ $pendaftaran->pendidikan ?? '-' }}</td></tr>
            <tr><td style="padding: 6px 0; font-size: 13px; color: #64748b;">Institusi</td><td style="padding: 6px 0; font-size: 13px; color: #0f172a;">{{ $pendaftaran->institusi ?? '-' }}</td></tr>
            <tr><td style="padding: 6px 0; font-size: 13px; color: #64748b;">Pengalaman</td><td style="padding: 6px 0; font-size: 13px; color: #0f172a;">{{ $pendaftaran->pengalaman ?? '-' }}</td></tr>
            <tr><td style="padding: 6px 0; font-size: 13px; color: #64748b;">Keahlian</td><td style="padding: 6px 0; font-size: 13px; color: #0f172a;">{{ $pendaftaran->keahlian ?? '-' }}</td></tr>
            <tr><td style="padding: 6px 0; font-size: 13px; color: #64748b;">Posisi</td><td style="padding: 6px 0; font-size: 13px; color: #0f172a;">{{ $pendaftaran->posisi ?? '-' }}</td></tr>
            <tr><td style="padding: 6px 0; font-size: 13px; color: #64748b;">Dikirim</td><td style="padding: 6px 0; font-size: 13px; color: #0f172a;">{{ $pendaftaran->created_at ? $pendaftaran->created_at->format('d M Y, H:i') : '-' }}</td></tr>
            <tr><td style="padding: 6px 0; font-size: 13px; color: #64748b;">Status</td><td style="padding: 6px 0;">
                @if($pendaftaran->status === 'Pending')
                    <span class="badge badge-warning">Pending</span>
                @elseif($pendaftaran->status === 'Approved')
                    <span class="badge badge-success">Approved</span>
                @else
                    <span class="badge badge-danger">Rejected</span>
                @endif
            </td></tr>
        </table>

        @if($pendaftaran->surat_motivasi)
        <hr style="margin: 16px 0; border: none; border-top: 1px solid #e2e8f0;">
        <p style="font-size: 13px; font-weight: 600; color: #64748b; margin-bottom: 8px;">Surat Motivasi</p>
        <p style="font-size: 13px; color: #334155; line-height: 1.6;">{{ $pendaftaran->surat_motivasi }}</p>
        @endif

        @if($pendaftaran->cv)
        <hr style="margin: 16px 0; border: none; border-top: 1px solid #e2e8f0;">
        <p style="font-size: 13px; color: #64748b; margin-bottom: 8px;">CV:</p>
        <a href="{{ asset('storage/' . $pendaftaran->cv) }}" target="_blank" class="btn btn-secondary btn-sm" style="display: inline-flex; align-items: center; gap: 6px;">
            <span class="material-symbols-outlined">description</span> Lihat CV (PDF)
        </a>
        @endif
    </div>
</div>

{{-- Action Buttons --}}
@if($pendaftaran->status === 'Pending')
<div class="card" style="margin-top: 20px; text-align: center;">
    <p style="font-size: 14px; color: #64748b; margin-bottom: 14px;">Aksi untuk lamaran ini:</p>
    <div style="display: flex; gap: 12px; justify-content: center;">
        <form method="POST" action="{{ route('admin.pendaftaran.approve', $pendaftaran) }}">
            @csrf
            <button type="submit" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 6px;" onclick="return confirm('Setujui lamaran ini? Data akan ditambahkan ke daftar anggota.')">
                <span class="material-symbols-outlined">check_circle</span> Terima
            </button>
        </form>
        <form method="POST" action="{{ route('admin.pendaftaran.reject', $pendaftaran) }}">
            @csrf
            <button type="submit" class="btn btn-danger" style="display: inline-flex; align-items: center; gap: 6px;" onclick="return confirm('Tolak lamaran ini?')">
                <span class="material-symbols-outlined">cancel</span> Tolak
            </button>
        </form>
    </div>
</div>
@endif

@if($pendaftaran->status === 'Approved')
<div class="card" style="margin-top: 20px; text-align: center; background: #f0fdf4; border: 1px solid #bbf7d0;">
    <div style="display: flex; align-items: center; justify-content: center; gap: 10px; margin-bottom: 12px;">
        <span class="material-symbols-outlined" style="color: #16a34a; font-size: 24px;">check_circle</span>
        <span style="font-size: 15px; font-weight: 600; color: #166534;">Lamaran telah disetujui</span>
    </div>
    <p style="font-size: 13px; color: #64748b; margin-bottom: 8px;">Data anggota telah ditambahkan ke daftar Expert.</p>
    <p style="font-size: 13px; color: #64748b; margin-bottom: 14px;">No. Anggota: <strong style="font-family: 'Courier New', monospace; color: #0f172a;">{{ $pendaftaran->no_anggota }}</strong></p>
    <a href="{{ route('admin.members.index') }}" class="btn btn-primary btn-sm" style="display: inline-flex; align-items: center; gap: 6px;">
        <span class="material-symbols-outlined">group</span> Lihat di Expert/Team
    </a>
</div>
@endif

@if($pendaftaran->status === 'Rejected')
<div class="card" style="margin-top: 20px; text-align: center; background: #fef2f2; border: 1px solid #fecaca;">
    <div style="display: flex; align-items: center; justify-content: center; gap: 10px;">
        <span class="material-symbols-outlined" style="color: #dc2626; font-size: 24px;">cancel</span>
        <span style="font-size: 15px; font-weight: 600; color: #991b1b;">Lamaran ditolak</span>
    </div>
</div>
@endif
@endsection
