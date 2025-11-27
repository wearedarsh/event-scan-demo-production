<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendeeType extends Model
{
    protected $fillable = ['name', 'active', 'key_name'];

    public function isOther()
    {
        return $this->key_name === 'other';
    }
}
