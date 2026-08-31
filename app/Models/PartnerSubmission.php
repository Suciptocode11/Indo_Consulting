<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerSubmission extends Model
{
    protected $fillable = [
        'company_name',
        'sector',
        'pic_name',
        'pic_position',
        'email',
        'phone',
        'address',
        'website',
        'logo',
        'company_profile',
        'reason',
        'status',
        'admin_notes',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
