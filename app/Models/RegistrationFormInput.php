<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistrationFormInput extends Model
{
    protected $fillable = [
        'registration_form_step_id',
        'key_name',
        'label',
        'help',
        'placeholder',
        'type',
        'required',
        'options',
        'row_start',
        'row_end',
        'col_span',
        'validation_rules',
        'validation_messages',
        'allowed_file_types',
        'display_order',
        'custom',
        'relation_model',
    ];

    protected $casts = [
        'required' => 'boolean',
        'options' => 'array',
        'validation_rules' => 'array',
        'validation_messages' => 'array',
        'custom' => 'boolean'
    ];

    public function step()
    {
        return $this->belongsTo(RegistrationFormStep::class);
    }

    public function customValues()
    {
        return $this->hasMany(RegistrationFormCustomFieldValue::class);
    }
}


