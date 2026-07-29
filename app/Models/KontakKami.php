<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KontakKami extends Model
{
    protected $table = 'kontak_kami';
    public $timestamps = false;

    protected $fillable = [
        'kontak',
        'title',
        'type',
    ];
}
