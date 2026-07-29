<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    protected $table = 'pendaftaran';

    protected $fillable = [
        'foto',
        'nama',
        'email',
        'telepon',
        'tanggal_lahir',
        'jenis_kelamin',
        'provinsi',
        'kode_provinsi',
        'alamat',
        'daerah_asal',
        'pendidikan',
        'institusi',
        'pengalaman',
        'keahlian',
        'posisi',
        'surat_motivasi',
        'cv',
        'status',
        'no_anggota',
        'catatan_admin',
        'profil_singkat',
        'link_wa',
        'link_linkedin',
        'link_instagram',
        'link_facebook',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];
}
