<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $table = 'faq';
    public $timestamps = false;

    protected $fillable = [
        'question',
        'answer',
        'urutan',
        'status',
    ];

    // Scope: hanya yang aktif
    public function scopeActive($query)
    {
        return $query->where('status', 'Show');
    }

    // Scope: urutkan berdasarkan urutan
    public function scopeOrdered($query)
    {
        return $query->orderBy('urutan');
    }
}
