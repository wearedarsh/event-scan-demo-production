<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistrationFormInput extends Model
{
    protected $fillable = [
        'registration_form_step_id',
        'key_name',
        'label',
        'placeholder',
        'type',
        'required',
        'width',
        'options',
        'row_start',
        'row_end',
        'col_span',
        'validation_rules',
        'display_order',
        'relation_model',
    ];

    protected $casts = [
        'required' => 'boolean',
        'options' => 'array',
        'validation_rules' => 'array',
        'validation_messages' => 'array',
    ];

    public function step()
    {
        return $this->belongsTo(RegistrationFormStep::class);
    }
}


