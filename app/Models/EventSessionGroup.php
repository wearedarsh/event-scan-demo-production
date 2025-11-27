<?php

namespace App\Models;

use App\Models\EventSession;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventSessionGroup extends Model
{
    use SoftDeletes;
    protected $fillable = ['friendly_name', 'display_order', 'active', 'event_id'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
    
    public function sessions(){
        return $this->hasMany(EventSession::class);
    }
}
