<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keunggulan extends Model
{
    protected $table = 'keunggulan';
    public $timestamps = false;

    protected $fillable = [
        'icon',
        'title',
        'description',
        'urutan',
        'status',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'Show');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('urutan');
    }
}
