<?php

namespace App\Models;
use App\Models\EventOptInCheck;
use App\Models\Registration;
use App\Models\User;

use Illuminate\Database\Eloquent\Model;

class RegistrationOptInResponse extends Model
{

    protected $fillable = ['event_opt_in_check_id', 'registration_id', 'value'];

    public function eventOptInCheck(){
        return $this->belongsTo(EventOptInCheck::class);
    }

    public function registration(){
        return $this->belongsTo(Registration::class);
    }

}
