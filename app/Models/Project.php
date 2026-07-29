<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'project';
    public $timestamps = false;

    protected $fillable = [
        'date',
        'title',
        'img',
        'content',
        'status',
        'hit',
        'url',
        'lokasi',
        'slug',
        'id_category',
        'id_service',
    ];

    public function kategoriProject()
    {
        return $this->belongsTo(KategoriProject::class, 'id_category');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'id_service');
    }

    public function photos()
    {
        return $this->hasMany(ProjectFoto::class, 'id_project');
    }
}
