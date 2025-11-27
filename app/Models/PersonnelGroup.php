<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonnelGroup extends Model
{
    protected $fillable = ['title', 'label_background_colour', 'event_id', 'label_colour'];
    
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function personnel()
    {
        return $this->hasMany(Personnel::class, 'personnel_group_id');
    }
}