<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'service';
    public $timestamps = false;

    protected $fillable = [
        'title',
        'short',
        'content',
        'icon',
        'img',
        'status',
        'slug',
        'url',
    ];

    public function projects()
    {
        return $this->hasMany(Project::class, 'id_service');
    }
}
