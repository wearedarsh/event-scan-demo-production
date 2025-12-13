<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\EmailBroadcast;

class EmailBroadcastType extends Model
{
    protected $fillable = ['key_name', 'label'];

    public function broadcasts()
    {
        return $this->hasMany(EmailBroadcast::class);
    }

    public function category(){
        return $this->belongsTo(EmailBroadcastTypeCategory::class);
    }
}
