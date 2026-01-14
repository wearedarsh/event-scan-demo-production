<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RegistrationPayment extends Model
{
    protected $fillable = [
        'registration_id',
        'event_payment_method_id',
        'amount_cents',
        'total_cents',
        'payment_intent_id',
        'paid_at',
        'status',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];


    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }

    public function eventPaymentMethod()
    {
        return $this->belongsTo(EventPaymentMethod::class);
    }

    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

}
