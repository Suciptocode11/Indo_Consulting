<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    protected $table = 'pengaturan';
    public $timestamps = false;

    protected $fillable = [
        'company',
        'address',
        'phone',
        'email',
        'website',
        'map',
        'copyright',
    ];

    public function getWhatsappNumberAttribute(): string
    {
        $raw = $this->phone ?? '';
        $digits = preg_replace('/[^0-9]/', '', $raw);
        if (str_starts_with($digits, '0')) {
            $digits = '62' . substr($digits, 1);
        }
        return !empty($digits) ? $digits : '6287865309966';
    }

    public function getWhatsappUrlAttribute(): string
    {
        return $this->whatsappUrl();
    }

    public function whatsappUrl(?string $message = null): string
    {
        $phone = $this->whatsapp_number;
        $company = $this->company ?? 'Indo Consulting';
        $msg = $message ?: "Halo {$company}, saya ingin konsultasi.";
        return 'https://wa.me/' . $phone . '?text=' . rawurlencode($msg);
    }
}
