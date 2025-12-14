<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;

class ClientSetting extends Model
{
    protected $fillable = [
        'category_id',
        'key_name',
        'label',
        'type',
        'display_order',
        'value',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ClientSettingsCategory::class, 'category_id');
    }

    /**
     * Get a setting value by category + key
     * e.g. ClientSetting::getValue('booking', 'support_email')
     */
    public static function getValue(string $categoryKey, string $settingKey, $default = null)
    {
        $cacheKey = "client_setting.{$categoryKey}.{$settingKey}";

        return Cache::rememberForever($cacheKey, function () use ($categoryKey, $settingKey, $default) {
            return optional(
                self::whereHas('category', fn ($q) =>
                    $q->where('key_name', $categoryKey)
                )->where('key_name', $settingKey)->first()
            )->value ?? $default;
        });
    }

    public static function clearCache(string $categoryKey, string $settingKey): void
    {
        Cache::forget("client_setting.{$categoryKey}.{$settingKey}");
    }
}
