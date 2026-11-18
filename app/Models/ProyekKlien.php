<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProyekKlien extends Model
{
    protected $table = 'proyek_klien';

    protected $fillable = [
        'kode_proyek',
        'nama_proyek',
        'nama_klien',
        'kontak_klien',
        'pic',
        'service_id',
        'nilai_kontrak',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
        'keterangan',
        'deskripsi',
        'created_by',
    ];

    protected $casts = [
        'nilai_kontrak'   => 'decimal:2',
        'tanggal_mulai'   => 'date',
        'tanggal_selesai' => 'date',
    ];

    // ─── Relationships ───────────────────────────────────────────────────────

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function transaksi()
    {
        return $this->hasMany(TransaksiKeuangan::class, 'proyek_klien_id');
    }

    // ─── Financial Helpers / Accessors ───────────────────────────────────────

    public function getTotalPemasukanAttribute()
    {
        return (float) $this->transaksi()
            ->where('tipe', 'pemasukan')
            ->where('status', 'lunas')
            ->sum('nominal');
    }

    public function getTotalPengeluaranAttribute()
    {
        return (float) $this->transaksi()
            ->where('tipe', 'pengeluaran')
            ->where('status', 'lunas')
            ->sum('nominal');
    }

    public function getPiutangPendingAttribute()
    {
        return (float) $this->transaksi()
            ->where('tipe', 'pemasukan')
            ->where('status', 'pending')
            ->sum('nominal');
    }

    public function getSisaTagihanAttribute()
    {
        $sisa = (float) $this->nilai_kontrak - $this->total_pemasukan;
        return $sisa > 0 ? $sisa : 0;
    }

    public function getLabaBersihAttribute()
    {
        return $this->total_pemasukan - $this->total_pengeluaran;
    }

    public function getProgressPembayaranAttribute()
    {
        if ((float) $this->nilai_kontrak <= 0) {
            return 0;
        }
        $pct = ($this->total_pemasukan / (float) $this->nilai_kontrak) * 100;
        return min(100, round($pct, 1));
    }

    public function getStatusBadgeAttribute()
    {
        return match ($this->status) {
            'berjalan' => ['label' => 'Berjalan', 'class' => 'badge-blue', 'icon' => 'sync'],
            'selesai'  => ['label' => 'Selesai',  'class' => 'badge-green', 'icon' => 'check_circle'],
            'pending'  => ['label' => 'Pending',  'class' => 'badge-amber', 'icon' => 'schedule'],
            'batal'    => ['label' => 'Batal',    'class' => 'badge-red', 'icon' => 'cancel'],
            default    => ['label' => ucfirst($this->status), 'class' => 'badge-gray', 'icon' => 'info'],
        };
    }

    // ─── Auto Generator Kode Kontrak ─────────────────────────────────────────

    public static function generateKodeProyek(): string
    {
        $prefix = 'KTR-' . date('Ym') . '-';
        $last = self::where('kode_proyek', 'like', $prefix . '%')
            ->orderByDesc('id')
            ->value('kode_proyek');

        if (!$last) {
            $oldPrefix = 'PRJ-' . date('Ym') . '-';
            $last = self::where('kode_proyek', 'like', $oldPrefix . '%')
                ->orderByDesc('id')
                ->value('kode_proyek');
        }

        if ($last) {
            $lastNum = (int) substr($last, -3);
            $nextNum = str_pad($lastNum + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $nextNum = '001';
        }

        return $prefix . $nextNum;
    }
}

