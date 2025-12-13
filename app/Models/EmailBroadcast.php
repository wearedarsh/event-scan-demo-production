<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class EmailBroadcast extends Model
{
    protected $fillable = ['friendly_name', 'sent_by', 'queued_at', 'event_id', 'email_broadcast_type_id'];

    protected $casts = [
        'queued_at' => 'datetime',
    ];

    public function sends()
    {
        return $this->hasMany(EmailSend::class, 'email_broadcast_id');
    }

    public function type()
    {
        return $this->belongsTo(EmailBroadcastType::class, 'email_broadcast_type_id');
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sent_by');
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

    public function sentCount(): int
    {
        return $this->sends()->count();
    }

    
}
