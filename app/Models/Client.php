<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'client';
    public $timestamps = false;

    protected $fillable = [
        'title',
        'sector',
        'img',
        'status',
        'url',
    ];
}
