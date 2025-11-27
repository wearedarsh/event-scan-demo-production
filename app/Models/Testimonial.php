<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Testimonial extends Model
{
    use SoftDeletes;
    protected $fillable = ['content', 'title', 'sub_title', 'star_rating', 'active', 'display_order'];
    
}
