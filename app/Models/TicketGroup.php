<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Ticket;
use App\Models\RegistrationTicket;
use App\Models\Event;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketGroup extends Model
{
    use SoftDeletes;
    public $timestamps = false;
    protected $fillable = ['event_id', 'name', 'active', 'display_order', 'description', 'multiple_select', 'required'];

    public function event(){
        return $this->belongsTo(Event::class);
    }
    public function tickets(){
        return $this->hasMany(Ticket::class);
    }

    public function activeTickets(){
        return $this->hasMany(Ticket::class)->where('active', true);
    }

    public function registrationTickets()
    {
        return $this->hasMany(RegistrationTicket::class);
    }
}
