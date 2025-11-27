<?php

namespace App\Models;
use App\Models\Event;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class EventFlyer extends Model
{
    use SoftDeletes;
    protected $fillable = ['event_id', 'file_path'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
