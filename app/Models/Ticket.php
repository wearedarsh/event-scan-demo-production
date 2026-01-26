<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\RegistrationTicket;
use App\Models\Event;

class Ticket extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['event_id', 'name', 'price_cents', 
        'requires_document_upload', 'max_volume', 'requires_document_copy', 
        'active', 'display_front_end', 'ticket_group_id', 
        'display_order'
    ];

    protected $casts = [
        'price_cents' => 'integer',
    ];

    public function getPriceAttribute(): string
    {
        return number_format($this->price_cents / 100, 2);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function allowedFileTypes(): array
    {
        return $this->allowed_file_types
            ? array_map('trim', explode(',', $this->allowed_file_types))
            : [];
    }

    public function ticketGroup()
    {
        return $this->belongsTo(TicketGroup::class);
    }

    public function registrationTickets()
    {
        return $this->hasMany(RegistrationTicket::class);
    }

}
