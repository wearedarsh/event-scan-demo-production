<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Event;
use App\Models\Registration;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventPaymentMethod extends Model
{
    protected $fillable = ['event_id', 'name', 'payment_method', 'enabled', 'description'];

    public function event(){
        $this->belongsTo(Event::class);
    }

    public function registrations(){
        $this->hasMany(Registration::class);
    }
}
