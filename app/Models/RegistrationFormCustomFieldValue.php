<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistrationFormCustomFieldValue extends Model
{
    protected $fillable = [
        'registration_id',
        'custom_field_key',
        'value',
    ];

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }
}
