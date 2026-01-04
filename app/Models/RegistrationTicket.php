<?php

namespace App\Models;

use App\Models\Registration;
use App\Models\Ticket;

use Illuminate\Database\Eloquent\Model;

class RegistrationTicket extends Model
{
    protected $fillable = ['registration_id', 'ticket_id', 'quantity', 'price_cents_at_purchase'];

    protected $casts = [
        'price_cents_at_purchase' => 'integer',
    ];

    public function getLineTotalCentsAttribute(): int
    {
        return $this->price_cents_at_purchase * $this->quantity;
    }

    public function getLineTotalAttribute(): string
    {
        return number_format($this->line_total_cents / 100, 2);
    }


    public function event()
    {
        return $this->belongsTo(Registration::class);
    }
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

}
