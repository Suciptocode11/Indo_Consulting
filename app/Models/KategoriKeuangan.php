<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriKeuangan extends Model
{
    protected $table = 'kategori_keuangan';

    protected $fillable = [
        'nama',
        'tipe',
        'keterangan',
    ];

    public function transaksi()
    {
        return $this->hasMany(TransaksiKeuangan::class, 'kategori_id');
    }

    public function getTipeLabelAttribute(): string
    {
        return $this->tipe === 'pemasukan' ? 'Pemasukan' : 'Pengeluaran';
    }
}

