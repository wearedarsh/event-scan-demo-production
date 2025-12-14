<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventHtmlEmailContent extends Model
{
    protected $fillable = [
        'event_id',
        'key_name',
        'label',
        'subject',
        'html_content',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
