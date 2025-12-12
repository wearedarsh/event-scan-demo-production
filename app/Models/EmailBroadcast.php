<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmailBroadcast extends Model
{
    protected $fillable = ['friendly_name', 'sent_by', 'sent_at', 'event_id', 'email_broadcast_type_id'];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function sends()
    {
        return $this->hasMany(EmailSend::class, 'email_broadcast_id');
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sent_by');
    }

    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function opens(): HasMany
    {
        return $this->hasMany(EmailOpen::class);
    }

    public function clicks(): HasMany
    {
        return $this->hasMany(EmailClick::class);
    }

    public function bounces(): HasMany
    {
        return $this->hasMany(EmailBounce::class);
    }
}