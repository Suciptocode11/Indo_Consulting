<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageContent extends Model
{
    protected $table = 'page_contents';

    protected $fillable = [
        'page',
        'key',
        'value',
        'type',
    ];

    // Helper: ambil nilai konten berdasarkan page dan key
    public static function getValue($page, $key, $default = null)
    {
        $content = static::where('page', $page)->where('key', $key)->first();
        return $content ? $content->value : $default;
    }

    // Helper: ambil semua konten satu page sebagai key => value collection
    public static function getPage($page)
    {
        return static::where('page', $page)->pluck('value', 'key');
    }
}
