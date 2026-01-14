<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistrationFormStep extends Model
{
    protected $fillable = [
        'registration_form_id',
        'label',
        'help_information_copy',
        'key_name',
        'type',
        'display_order',
    ];

    public function form()
    {
        return $this->belongsTo(RegistrationForm::class);
    }

    public function inputs()
    {
        return $this->hasMany(RegistrationFormInput::class)
            ->orderBy('display_order');
    }

    public function isRigid(): bool
    {
        return $this->type === 'rigid';
    }
}

