<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class EmailBroadcastTypeCategory extends Model
{
    protected $fillable = ['key_name', 'label'];

    public function types()
    {
        return $this->hasMany(EmailBroadcastType::class, 'category_id');
    }
}