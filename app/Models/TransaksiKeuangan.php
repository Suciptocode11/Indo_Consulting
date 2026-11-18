<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TransaksiKeuangan extends Model
{
    protected $table = 'transaksi_keuangan';

    protected $fillable = [
        'kode_transaksi',
        'tanggal',
        'tipe',
        'kategori_id',
        'service_id',
        'proyek_klien_id',
        'judul',
        'penerima',
        'nominal',
        'satuan',
        'volume',
        'harga_satuan',
        'metode_pembayaran',
        'status',
        'bukti',
        'keterangan',
        'deskripsi',
        'created_by',
    ];

    protected $casts = [
        'tanggal'      => 'date',
        'nominal'      => 'decimal:2',
        'volume'       => 'decimal:2',
        'harga_satuan' => 'decimal:2',
    ];

    // ─── Relationships ───────────────────────────────────────────────────────

    public function kategori()
    {
        return $this->belongsTo(KategoriKeuangan::class, 'kategori_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function proyekKlien()
    {
        return $this->belongsTo(ProyekKlien::class, 'proyek_klien_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // ─── Accessors ───────────────────────────────────────────────────────────

    public function getNominalFormatAttribute(): string
    {
        return 'Rp ' . number_format($this->nominal, 0, ',', '.');
    }

    public function getStatusLabelAttribute(): string
    {
        return $this->status === 'lunas' ? 'Lunas' : 'Menunggu Pembayaran';
    }

    public function getTipeLabelAttribute(): string
    {
        return $this->tipe === 'pemasukan' ? 'Pemasukan' : 'Pengeluaran';
    }

    public function getTerbilangAttribute(): string
    {
        $raw = trim(static::penyebut((int) $this->nominal));
        $clean = preg_replace('/\s+/', ' ', $raw);
        return ucwords($clean) . ' Rupiah';
    }

    public static function penyebut($nilai): string
    {
        $nilai = abs($nilai);
        $huruf = ["", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas"];
        $temp = "";

        if ($nilai < 12) {
            $temp = " " . $huruf[$nilai];
        } else if ($nilai < 20) {
            $temp = static::penyebut($nilai - 10) . " belas";
        } else if ($nilai < 100) {
            $temp = static::penyebut((int)($nilai / 10)) . " puluh" . static::penyebut($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " seratus" . static::penyebut($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = static::penyebut((int)($nilai / 100)) . " ratus" . static::penyebut($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " seribu" . static::penyebut($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = static::penyebut((int)($nilai / 1000)) . " ribu" . static::penyebut($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = static::penyebut((int)($nilai / 1000000)) . " juta" . static::penyebut($nilai % 1000000);
        } else if ($nilai < 1000000000000) {
            $temp = static::penyebut((int)($nilai / 1000000000)) . " miliar" . static::penyebut(fmod($nilai, 1000000000));
        } else if ($nilai < 1000000000000000) {
            $temp = static::penyebut((int)($nilai / 1000000000000)) . " triliun" . static::penyebut(fmod($nilai, 1000000000000));
        }

        return $temp;
    }

    // ─── Static Helpers ──────────────────────────────────────────────────────

    /**
     * Generate kode transaksi sequential per bulan: TRX-202611-0001
     */
    public static function generateKode(): string
    {
        $prefix = 'TRX-' . now()->format('Ym') . '-';
        $last   = static::where('kode_transaksi', 'like', $prefix . '%')
            ->orderByDesc('kode_transaksi')
            ->value('kode_transaksi');

        $seq = $last ? ((int) substr($last, -4)) + 1 : 1;

        return $prefix . str_pad($seq, 4, '0', STR_PAD_LEFT);
    }
}

