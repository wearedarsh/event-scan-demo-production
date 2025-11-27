<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Personnel extends Model
{
    protected $table = 'personnel';
    protected $fillable = ['line_1', 'line_2', 'line_3', 'personnel_group_id', 'event_id'];

    public function group(){
        return $this->belongsTo(PersonnelGroup::class, 'personnel_group_id');
    }

    public function event(){
        return $this->belongsTo(Event::class, 'event_id');
    }
}
