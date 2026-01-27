<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BrandingImage extends Model
{
    protected $fillable = [
        'branding_platform_id',
        'key_name',
        'path',
        'alt_text',
        'width',
        'height',
        'custom_classes',
    ];

    public function platform(): BelongsTo
    {
        return $this->belongsTo(BrandingPlatform::class, 'branding_platform_id');
    }
}
