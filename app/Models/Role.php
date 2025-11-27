<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Role extends Model
{
    public function role(){
        return $this->hasMany(User::class);
    }

}
