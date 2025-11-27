<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmailQueuedSend extends Model
{
    protected $fillable = [
        'email_broadcast_id',
        'recipient_id',
        'email_address',
        'subject',
        'html_content',
        'status',
        'attempts',
        'last_error',
        'scheduled_at',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
    ];

    public function broadcast(): BelongsTo
    {
        return $this->belongsTo(EmailBroadcast::class);
    }

    public function recipient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }
}
