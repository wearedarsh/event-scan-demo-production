<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmailClick extends Model
{
    protected $fillable = ['email_send_id', 'recipient_email', 'url', 'ip_address', 'user_agent', 'event_time'];

    protected $casts = [
        'event_time' => 'datetime',
    ];

    public function emailSend(): BelongsTo
    {
        return $this->belongsTo(EmailSend::class);
    }
}