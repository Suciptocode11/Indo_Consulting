@extends('admin.layouts.app')

@section('title', 'Detail Pendaftaran Partner - ' . $submission->company_name)
@section('page-title', 'Detail Pendaftaran Partner')

@section('content')
<a href="{{ route('admin.partner-submissions.index') }}" style="display: inline-flex; align-items: center; gap: 4px; font-size: 13px; color: #64748b; text-decoration: none; margin-bottom: 16px;">
    <span class="material-symbols-outlined" style="font-size: 18px;">arrow_back</span> Kembali
</a>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">

    {{-- Detail Perusahaan --}}
    <div class="card">
        <h3 style="font-size: 14px; font-weight: 600; color: #64748b; margin-bottom: 16px; text-transform: uppercase; letter-spacing: 0.5px;">Informasi Perusahaan</h3>

        @if($submission->logo)
        <div style="margin-bottom: 20px; text-align: center;">
            <img src="{{ asset('storage/' . $submission->logo) }}" style="max-width: 200px; max-height: 100px; object-fit: contain; border-radius: 8px; border: 1px solid #e2e8f0;">
        </div>
        @endif

        <table style="width: 100%; border-collapse: collapse;">
            <tr><td style="padding: 8px 0; font-size: 13px; color: #64748b; width: 140px;">Nama Perusahaan</td><td style="padding: 8px 0; font-size: 14px; color: #0f172a; font-weight: 600;">{{ $submission->company_name }}</td></tr>
            <tr><td style="padding: 8px 0; font-size: 13px; color: #64748b;">Sektor</td><td style="padding: 8px 0; font-size: 13px; color: #0f172a;">{{ $submission->sector ?? '-' }}</td></tr>
            <tr><td style="padding: 8px 0; font-size: 13px; color: #64748b;">Website</td><td style="padding: 8px 0; font-size: 13px;">
                @if($submission->website)
                    <a href="{{ $submission->website }}" target="_blank" style="color: #3b82f6; text-decoration: none;">{{ $submission->website }}</a>
                @else
                    -
                @endif
            </td></tr>
            <tr><td style="padding: 8px 0; font-size: 13px; color: #64748b; vertical-align: top;">Alamat</td><td style="padding: 8px 0; font-size: 13px; color: #0f172a;">{{ $submission->address ?? '-' }}</td></tr>
        </table>

        @if($submission->company_profile)
        <div style="margin-top: 16px; padding-top: 16px; border-top: 1px solid #e2e8f0;">
            <p style="font-size: 13px; font-weight: 600; color: #64748b; margin-bottom: 8px;">Profil Perusahaan</p>
            <p style="font-size: 13px; color: #475569; line-height: 1.6;">{{ $submission->company_profile }}</p>
        </div>
        @endif

        @if($submission->reason)
        <div style="margin-top: 16px; padding-top: 16px; border-top: 1px solid #e2e8f0;">
            <p style="font-size: 13px; font-weight: 600; color: #64748b; margin-bottom: 8px;">Alasan Bergabung</p>
            <p style="font-size: 13px; color: #475569; line-height: 1.6;">{{ $submission->reason }}</p>
        </div>
        @endif
    </div>

    {{-- PIC & Status --}}
    <div>
        <div class="card" style="margin-bottom: 20px;">
            <h3 style="font-size: 14px; font-weight: 600; color: #64748b; margin-bottom: 16px; text-transform: uppercase; letter-spacing: 0.5px;">Person in Charge</h3>

            <table style="width: 100%; border-collapse: collapse;">
                <tr><td style="padding: 8px 0; font-size: 13px; color: #64748b; width: 100px;">Nama</td><td style="padding: 8px 0; font-size: 14px; color: #0f172a; font-weight: 600;">{{ $submission->pic_name }}</td></tr>
                <tr><td style="padding: 8px 0; font-size: 13px; color: #64748b;">Jabatan</td><td style="padding: 8px 0; font-size: 13px; color: #0f172a;">{{ $submission->pic_position ?? '-' }}</td></tr>
                <tr><td style="padding: 8px 0; font-size: 13px; color: #64748b;">Email</td><td style="padding: 8px 0; font-size: 13px;"><a href="mailto:{{ $submission->email }}" style="color: #3b82f6; text-decoration: none;">{{ $submission->email }}</a></td></tr>
                <tr><td style="padding: 8px 0; font-size: 13px; color: #64748b;">Telepon</td><td style="padding: 8px 0; font-size: 13px; color: #0f172a;">{{ $submission->phone ?? '-' }}</td></tr>
            </table>
        </div>

        <div class="card">
            <h3 style="font-size: 14px; font-weight: 600; color: #64748b; margin-bottom: 16px; text-transform: uppercase; letter-spacing: 0.5px;">Status Pendaftaran</h3>

            <div style="margin-bottom: 16px;">
                <p style="font-size: 13px; color: #64748b; margin-bottom: 4px;">Status Saat Ini</p>
                @if($submission->status === 'Pending')
                    <span class="badge badge-warning">Pending</span>
                @elseif($submission->status === 'Approved')
                    <span class="badge badge-success">Approved</span>
                @else
                    <span class="badge badge-danger">Rejected</span>
                @endif
            </div>

            <div style="margin-bottom: 16px;">
                <p style="font-size: 13px; color: #64748b;">Tanggal Daftar: <strong>{{ $submission->created_at->format('d/m/Y H:i') }}</strong></p>
            </div>

            @if($submission->admin_notes)
            <div style="background: #fef3c7; border: 1px solid #fbbf24; border-radius: 8px; padding: 12px; margin-bottom: 16px;">
                <p style="font-size: 12px; font-weight: 600; color: #92400e; margin-bottom: 4px;">Catatan Admin</p>
                <p style="font-size: 13px; color: #78350f;">{{ $submission->admin_notes }}</p>
            </div>
            @endif

            @if($submission->status === 'Pending')
            <div style="display: flex; gap: 8px; margin-top: 20px;">
                <form method="POST" action="{{ route('admin.partner-submissions.approve', $submission) }}" style="flex: 1;">
                    @csrf
                    <button type="submit" class="btn btn-success" style="width: 100%; display: flex; align-items: center; justify-content: center; gap: 6px;" onclick="return confirm('Setujui pendaftaran ini? Partner akan ditambahkan ke halaman Partners & Clients.')">
                        <span class="material-symbols-outlined">check_circle</span> Setujui
                    </button>
                </form>

                <button onclick="document.getElementById('rejectModal').style.display='flex'" class="btn btn-danger" style="flex: 1; display: flex; align-items: center; justify-content: center; gap: 6px;">
                    <span class="material-symbols-outlined">cancel</span> Tolak
                </button>
            </div>
            @endif

            <form method="POST" action="{{ route('admin.partner-submissions.destroy', $submission) }}" style="margin-top: 12px;" onsubmit="return confirm('Hapus pendaftaran ini?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm" style="width: 100%;">
                    <span class="material-symbols-outlined">delete</span> Hapus Pendaftaran
                </button>
            </form>
        </div>
    </div>

</div>

{{-- Reject Modal --}}
<div id="rejectModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
    <div class="card" style="max-width: 500px; width: 90%; margin: 20px;">
        <h3 style="font-size: 16px; font-weight: 600; color: #0f172a; margin-bottom: 12px;">Tolak Pendaftaran</h3>
        <form method="POST" action="{{ route('admin.partner-submissions.reject', $submission) }}">
            @csrf
            <div class="form-group">
                <label>Catatan (Opsional)</label>
                <textarea name="admin_notes" rows="3" placeholder="Alasan penolakan..." style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 13px;"></textarea>
            </div>
            <div style="display: flex; gap: 8px; margin-top: 16px;">
                <button type="button" onclick="document.getElementById('rejectModal').style.display='none'" class="btn btn-secondary" style="flex: 1;">Batal</button>
                <button type="submit" class="btn btn-danger" style="flex: 1;">Tolak</button>
            </div>
        </form>
    </div>
</div>

@endsection
