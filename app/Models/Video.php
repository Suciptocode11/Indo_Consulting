<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $table = 'video';
    public $timestamps = false;

    protected $fillable = [
        'date',
        'title',
        'content',
        'source',
        'hit',
        'status',
        'slug',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'Show');
    }
}
