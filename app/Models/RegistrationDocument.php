<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Registration;
use App\Models\Ticket;

class RegistrationDocument extends Model
{
    protected $fillable = ['registration_id', 'file_path', 'original_name', 'ticket_id'];

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
