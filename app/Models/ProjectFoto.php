<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectFoto extends Model
{
    protected $table = 'project_foto';
    public $timestamps = false;

    protected $fillable = [
        'id_project',
        'img',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'id_project');
    }
}
