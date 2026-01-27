<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BrandingPlatform extends Model
{
    protected $fillable = [
        'key_name',
        'label',
    ];

    public function css(): HasMany
    {
        return $this->hasMany(BrandingCss::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(BrandingImage::class);
    }
}
