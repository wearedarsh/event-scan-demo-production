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

    public function sender()
    {
        return $this->belongsTo(User::class, 'sent_by');
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function opens()
    {
        return $this->hasMany(EmailOpen::class);
    }

    public function clicks()
    {
        return $this->hasMany(EmailClick::class);
    }

    public function bounces()
    {
        return $this->hasMany(EmailBounce::class);
    }

    public function sentCount()
    {
        return $this->sends()->count();
    }

    public function isBulk()
    {
        return $this->sentCount > 1;
    }

    
}
