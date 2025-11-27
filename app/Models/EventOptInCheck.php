<?php

namespace App\Models;
use App\Models\RegistrationOptInResponse;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventOptInCheck extends Model
{
    protected $fillable = ['event_id', 'name', 'description', 'sort_order', 'friendly_name'];

    public function event(){
        $this->belongsTo(Event::class);
    }

    public function registrationOptIns(){
        $this->hasMany(RegistrationOptInResponse::class);
    }
}
