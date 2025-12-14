<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClientSettingsCategory extends Model
{
    protected $fillable = [
        'key_name',
        'label',
        'display_order',
    ];

    public function settings(): HasMany
    {
        return $this->hasMany(ClientSetting::class, 'category_id')
            ->orderBy('display_order');
    }
}

