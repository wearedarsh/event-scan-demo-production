<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmailSend extends Model
{
    protected $fillable = [
        'email_broadcast_id',
        'recipient_id',
        'email_address',
        'subject',
        'html_content',
        'status',
        'sent_at',
        'last_error',
        'message_id',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function broadcast()
    {
        return $this->belongsTo(EmailBroadcast::class , 'email_broadcast_id');
    }

    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }

    public function clicks()
    {
        return $this->hasMany(EmailClick::class, 'email_send_id');
    }

    public function opens()
    {
        return $this->hasMany(EmailOpen::class, 'email_send_id');
    }
}
