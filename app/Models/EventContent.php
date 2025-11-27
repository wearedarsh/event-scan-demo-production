<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Event;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventContent extends Model
{

    use SoftDeletes;
    protected $fillable = ['event_id', 'title', 'html_content', 'active', 'order'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
