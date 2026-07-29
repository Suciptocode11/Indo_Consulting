<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    protected $table = 'pengaturan';
    public $timestamps = false;

    protected $fillable = [
        'company',
        'address',
        'phone',
        'email',
        'website',
        'map',
        'copyright',
        'logo',
    ];
}
