<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $table = 'blog';
    public $timestamps = false;

    protected $fillable = [
        'date',
        'title',
        'slug',
        'img',
        'caption',
        'content',
        'status',
        'hit',
        'tags',
        'keyword',
        'id_category',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_category');
    }
}
