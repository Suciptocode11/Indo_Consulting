<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'review';
    public $timestamps = false;

    protected $fillable = [
        'nama',
        'review',
        'stars',
        'status',
        'pekerjaan',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'Show');
    }
}
