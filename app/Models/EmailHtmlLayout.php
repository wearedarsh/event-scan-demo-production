<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class EmailHtmlLayout extends Model
{
    protected $fillable = [
        'label',
        'key_name',
        'html_content',
    ];
    
    public static function getByKey(string $key_name): ?self
    {
        $cacheKey = "email_layout.{$key_name}";

        return Cache::rememberForever($cacheKey, function () use ($key_name) {
            return self::where('key_name', $key_name)->first();
        });
    }

    public static function clearCache(string $key_name): void
    {
        Cache::forget("email_layout.{$key_name}");
    }
}
