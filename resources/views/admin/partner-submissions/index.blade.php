@extends('admin.layouts.app')

@section('title', 'Pendaftaran Partner & Client')
@section('page-title', 'Pendaftaran Partner & Client')

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h3 style="font-size: 16px; font-weight: 600; color: #0f172a;">Daftar Pendaftaran</h3>
        <a href="{{ route('partner.create') }}" target="_blank" class="btn btn-secondary btn-sm">
            <span class="material-symbols-outlined">open_in_new</span> Lihat Form Publik
        </a>
    </div>

    @if($submissions->isEmpty())
        <p style="text-align: center; padding: 40px; color: #94a3b8;">Belum ada pendaftaran partner/client.</p>
    @else
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                        <th style="padding: 12px; text-align: left; font-size: 13px; font-weight: 600; color: #64748b;">Perusahaan</th>
                        <th style="padding: 12px; text-align: left; font-size: 13px; font-weight: 600; color: #64748b;">Sektor</th>
                        <th style="padding: 12px; text-align: left; font-size: 13px; font-weight: 600; color: #64748b;">PIC</th>
                        <th style="padding: 12px; text-align: left; font-size: 13px; font-weight: 600; color: #64748b;">Kontak</th>
                        <th style="padding: 12px; text-align: center; font-size: 13px; font-weight: 600; color: #64748b;">Status</th>
                        <th style="padding: 12px; text-align: center; font-size: 13px; font-weight: 600; color: #64748b;">Tanggal</th>
                        <th style="padding: 12px; text-align: center; font-size: 13px; font-weight: 600; color: #64748b;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($submissions as $sub)
                    <tr style="border-bottom: 1px solid #e2e8f0;">
                        <td style="padding: 12px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                @if($sub->logo)
                                    <img src="{{ asset('storage/' . $sub->logo) }}" style="width: 40px; height: 40px; object-fit: contain; border-radius: 8px; border: 1px solid #e2e8f0;">
                                @else
                                    <div style="width: 40px; height: 40px; background: #f1f5f9; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                        <span class="material-symbols-outlined" style="font-size: 20px; color: #94a3b8;">business</span>
                                    </div>
                                @endif
                                <strong style="font-size: 14px;">{{ $sub->company_name }}</strong>
                            </div>
                        </td>
                        <td style="padding: 12px; font-size: 13px; color: #64748b;">{{ $sub->sector ?? '-' }}</td>
                        <td style="padding: 12px;">
                            <div style="font-size: 13px; color: #0f172a; font-weight: 500;">{{ $sub->pic_name }}</div>
                            @if($sub->pic_position)
                                <div style="font-size: 12px; color: #94a3b8;">{{ $sub->pic_position }}</div>
                            @endif
                        </td>
                        <td style="padding: 12px; font-size: 13px;">
                            <div>{{ $sub->email }}</div>
                            @if($sub->phone)
                                <div style="color: #64748b;">{{ $sub->phone }}</div>
                            @endif
                        </td>
                        <td style="padding: 12px; text-align: center;">
                            @if($sub->status === 'Pending')
                                <span class="badge badge-warning">Pending</span>
                            @elseif($sub->status === 'Approved')
                                <span class="badge badge-success">Approved</span>
                            @else
                                <span class="badge badge-danger">Rejected</span>
                            @endif
                        </td>
                        <td style="padding: 12px; text-align: center; font-size: 12px; color: #64748b;">
                            {{ $sub->created_at->format('d/m/Y') }}
                        </td>
                        <td style="padding: 12px; text-align: center;">
                            <a href="{{ route('admin.partner-submissions.show', $sub) }}" class="btn btn-secondary btn-sm">
                                <span class="material-symbols-outlined">visibility</span> Detail
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
