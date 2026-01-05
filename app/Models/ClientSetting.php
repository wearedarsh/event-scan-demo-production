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
        return $this->belongsTo(ClientSettingCategory::class, 'category_id');
    }

}
