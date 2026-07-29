<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $table = 'album';
    public $timestamps = false;

    protected $fillable = [
        'title',
        'img',
        'hit',
        'slug',
        'date',
        'status',
    ];

    public function photos()
    {
        return $this->hasMany(Foto::class, 'id_album');
    }
}
