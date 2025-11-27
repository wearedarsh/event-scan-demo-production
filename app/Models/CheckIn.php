<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CheckIn extends Model
{
    protected $fillable = [
        'attendee_id',
        'event_session_id',
        'checked_in_at',
        'event_id',
        'checked_in_by',
        'checked_in_route',
    ];

    protected $casts = [
        'checked_in_at'  => 'datetime',
        'checked_out_at' => 'datetime',
    ];

    public function attendee()
    {
        return $this->belongsTo(Registration::class, 'attendee_id');
    }

    public function session()
    {
        return $this->belongsTo(EventSession::class, 'event_session_id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function checkedInBy()
    {
        return $this->belongsTo(User::class, 'checked_in_by');
    }
}
