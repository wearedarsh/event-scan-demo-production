<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailHtmlContent extends Model
{
    use SoftDeletes;
    protected $fillable = ['key_name', 'label', 'subject', 'pre_header', 'category', 'html_content'];
}
