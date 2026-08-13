<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Foto extends Model
{
    protected $table = 'foto';
    public $timestamps = false;

    protected $fillable = [
        'id_album',
        'img',
        'caption',
    ];

    public function album()
    {
        return $this->belongsTo(Album::class, 'id_album');
    }
}
