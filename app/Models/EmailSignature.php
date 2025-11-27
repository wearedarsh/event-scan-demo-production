<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailSignature extends Model
{
    protected $fillable = ['id','key_name','html_content', 'title', 'active'];

}

