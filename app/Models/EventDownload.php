<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Event;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventDownload extends Model
{
    use SoftDeletes;
    protected $fillable = ['event_id', 'title', 'file_name', 'file_path', 'file_type', 'file_size', 'display_order', 'active'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
