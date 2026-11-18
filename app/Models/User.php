<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'users';
    public $timestamps = false;

    protected $fillable = [
        'username',
        'email',
        'password',
        'nama',
        'level',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function isSuperAdmin(): bool
    {
        return in_array($this->level, ['super_admin', 'superadmin']);
    }

    public function isAdmin(): bool
    {
        return $this->level === 'admin';
    }

    public function isFinance(): bool
    {
        return $this->level === 'finance';
    }

    public function canAccessFinance(): bool
    {
        return $this->isSuperAdmin() || $this->isFinance();
    }

    public function canAccessContent(): bool
    {
        return $this->isSuperAdmin() || $this->isAdmin();
    }

    public function getRoleLabelAttribute(): string
    {
        if ($this->isSuperAdmin()) {
            return 'Super Admin';
        }
        if ($this->isFinance()) {
            return 'Finance';
        }
        return 'Admin';
    }
}
