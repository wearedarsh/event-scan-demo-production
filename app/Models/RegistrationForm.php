<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistrationForm extends Model
{
    protected $fillable = ['label', 'key_name', 'description', 'is_active', 'type'];

    public function steps()
    {
        return $this->hasMany(RegistrationFormStep::class)
            ->orderBy('display_order');
    }

}

