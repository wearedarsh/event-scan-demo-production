<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\EventSessionGroup;
use App\Models\EventSessionType;
use App\Models\Event;

use Illuminate\Database\Eloquent\SoftDeletes;

class EventSession extends Model
{
    use softDeletes;
    protected $casts = [
        'cme_points' => 'float',
    ];
    protected $fillable = ['title', 'start_time', 'end_time', 'cme_points', 'event_session_type_id', 'event_session_group_id', 'display_order'];

    public function group(){
        return $this->belongsTo(EventSessionGroup::class, 'event_session_group_id');
    }

    public function type(){
        return $this->belongsTo(EventSessionType::class, 'event_session_type_id');
    }
}
