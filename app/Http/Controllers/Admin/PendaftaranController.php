<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Models\Member;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PendaftaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Pendaftaran::query();

        $status = $request->input('status', 'Pending');
        $query->where('status', $status);

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('posisi', 'like', "%{$search}%");
            });
        }

        $pendaftarans = $query->orderByDesc('id')->paginate(15)->withQueryString();

        return view('admin.pendaftaran.index', compact('pendaftarans'));
    }

    public function show(Pendaftaran $pendaftaran)
    {
        return view('admin.pendaftaran.show', compact('pendaftaran'));
    }

    public function approve(Pendaftaran $pendaftaran)
    {
        // Generate no anggota
        $noAnggota = $this->generateNoAnggota($pendaftaran->tanggal_lahir, $pendaftaran->kode_provinsi);

        // Insert ke table member
        Member::create([
            'nama'            => $pendaftaran->nama,
            'email'           => $pendaftaran->email,
            'wa'              => $pendaftaran->link_wa ?: $pendaftaran->telepon,
            'foto'            => $pendaftaran->foto,
            'jabatan'         => $pendaftaran->posisi,
            'alamat'          => $pendaftaran->alamat,
            'profil'          => $pendaftaran->profil_singkat,
            'linkedin'        => $pendaftaran->link_linkedin,
            'instagram'       => $pendaftaran->link_instagram,
            'facebook'        => $pendaftaran->link_facebook,
            'pendidikan'      => $pendaftaran->pendidikan,
            'pengalaman'      => $pendaftaran->pengalaman,
            'keahlian'        => $pendaftaran->keahlian,
            'no_anggota'      => $noAnggota,
            'tanggal_anggota' => now()->toDateString(),
            'slug'            => \Illuminate\Support\Str::slug($pendaftaran->nama),
            'status'          => 'Show',
        ]);

        // Update status pendaftaran
        $pendaftaran->update([
            'status'     => 'Approved',
            'no_anggota' => $noAnggota,
        ]);

        return redirect()->route('admin.pendaftaran.show', $pendaftaran)
            ->with('success', "Lamaran disimpan! No. Anggota: {$noAnggota}");
    }

    public function reject(Pendaftaran $pendaftaran)
    {
        $pendaftaran->update(['status' => 'Rejected']);

        return redirect()->route('admin.pendaftaran.show', $pendaftaran)
            ->with('success', 'Lamaran ditolak.');
    }

    public function destroy(Pendaftaran $pendaftaran)
    {
        // Hapus file
        if ($pendaftaran->foto && \Storage::disk('public')->exists($pendaftaran->foto)) {
            \Storage::disk('public')->delete($pendaftaran->foto);
        }
        if ($pendaftaran->cv && \Storage::disk('public')->exists($pendaftaran->cv)) {
            \Storage::disk('public')->delete($pendaftaran->cv);
        }

        $pendaftaran->delete();

        return redirect()->route('admin.pendaftaran.index')->with('success', 'Data pendaftaran dihapus.');
    }

    private function generateNoAnggota($tanggalLahir, $kodeProvinsi)
    {
        $provinsi = $kodeProvinsi ?? '51';
        $perusahaan = '369';

        // Tanggal lahir → DDMMYY (fallback ke 1 Januari 2000 jika kosong)
        $tgl = $tanggalLahir ? Carbon::parse($tanggalLahir) : Carbon::create(2000, 1, 1);
        $tglCode = $tgl->format('d') . $tgl->format('m') . $tgl->format('y');

        // No urut
        $count = Member::count() + 1;
        $noUrut = str_pad($count, 3, '0', STR_PAD_LEFT);

        return "{$provinsi}.{$perusahaan}.{$tglCode}.{$noUrut}";
    }
}
