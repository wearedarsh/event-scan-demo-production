<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistrationFormCustomFieldValue extends Model
{
    protected $fillable = [
        'registration_id',
        'registration_form_input_id',
        'value',
    ];

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }

    public function input()
    {
        return $this->belongsTo(RegistrationFormInput::class);
    }
}
