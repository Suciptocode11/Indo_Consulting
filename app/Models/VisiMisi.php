<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisiMisi extends Model
{
    protected $table = 'visi_misi';
    public $timestamps = false;

    protected $fillable = [
        'type',
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
