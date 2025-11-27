<?php

namespace App\Models;

use App\Models\EventSession;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventSessionType extends Model
{
    
    protected $fillable = ['friendly_name', 'active'];

    public function sessions(){
        return $this->hasMany(EventSession::class);
    }
}
