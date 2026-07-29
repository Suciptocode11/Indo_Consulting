<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriProject extends Model
{
    protected $table = 'kategori_project';
    public $timestamps = false;

    protected $fillable = [
        'title',
        'slug',
    ];

    public function projects()
    {
        return $this->hasMany(Project::class, 'id_category');
    }
}
