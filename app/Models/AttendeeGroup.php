<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendeeGroup extends Model
{
    protected $fillable = ['title', 'colour', 'event_id', 'label_colour'];
    
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function attendees()
    {
        return $this->hasMany(Registration::class, 'attendee_group_id');
    }
}
