<?php

namespace App\Models;

use App\Models\Registration;
use App\Models\Ticket;

use Illuminate\Database\Eloquent\Model;

class RegistrationTicket extends Model
{
    protected $fillable = ['registration_id', 'ticket_id', 'quantity', 'price_at_purchase'];
    public function event()
    {
        return $this->belongsTo(Registration::class);
    }
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

}
