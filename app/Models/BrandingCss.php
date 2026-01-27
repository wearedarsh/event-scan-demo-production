<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BrandingCss extends Model
{
    protected $fillable = [
        'branding_platform_id',
        'key_name',
        'name',
        'css',
        'version',
        'is_active',
        'created_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function platform(): BelongsTo
    {
        return $this->belongsTo(BrandingPlatform::class, 'branding_platform_id');
    }
}
