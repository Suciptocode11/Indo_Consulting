<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'member';
    public $timestamps = false;

    protected $fillable = [
        'nama',
        'wa',
        'email',
        'instagram',
        'twitter',
        'facebook',
        'youtube',
        'situs',
        'linkedin',
        'alamat',
        'pendidikan',
        'keahlian',
        'penunjang',
        'pengalaman',
        'jabatan',
        'profil',
        'foto',
        'cv',
        'status',
        'slug',
        'id_group',
        'no_anggota',
        'tanggal_anggota',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'Show');
    }
}
